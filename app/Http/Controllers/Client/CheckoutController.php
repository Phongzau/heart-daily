<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use App\Models\PaymentSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
    public function index()
    {
        $carts = session('cart', []);
        $paymentMethods = PaymentSetting::where('status', 1)->get();
        return view('client.page.checkout', compact('carts','paymentMethods'));
    }

    public function process(Request $request)
    {
        $carts = session('cart', []);
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'ward' => 'required|string|max:100',
            'payment_method' => 'required|string|in:cod,vnpay,momo',
        ]);

        // Sử dụng hàm createOrder để tạo đơn hàng
        $order = $this->createOrder($request);

        if ($request->input('payment_method') === 'vnpay') {
            return $this->createPayment($order);
        } elseif ($request->input('payment_method') === 'momo') {
            return $this->createMoMoPayment($order);
        } else {
            $order->payment_method = 'COD';
            $order->save();
            $this->sendOrderConfirmation($order);
            session()->forget('cart');
            session()->forget('coupon');
            toastr('Đơn hàng của bạn đã được đặt thành công!', 'success');
            return redirect()->route('order.complete');
        }
    }

    public function orderComplete()
    {
        return view('client.page.complete');
    }

    private function createOrder($request)
    {
        $carts = session('cart', []);
        $order = new Order();
        $order->invoice_id = (string) Str::uuid();
        $order->user_id = Auth::id();
        $order->sub_total = getCartTotal();
        $order->amount = getMainCartTotal();
        $order->product_qty = array_sum(array_column($carts, 'qty'));
        $order->payment_status = false;
        $order->order_address = json_encode([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'district' => $request->input('district'),
            'ward' => $request->input('ward'),
            'order_comments' => $request->input('order_comments'),
        ]);
        $order->cod = getCartCod();
        $order->order_status = now();
        $order->coupon_method = json_encode(fetchCartDiscountInfo() ?? []);

        return $order;
    }

    private function createPayment($order)
    {
        $paymentMethods = PaymentSetting::where('method', 'vnpay')->first();

        $vnp_TmnCode = $paymentMethods->vnp_tmncode;
        $vnp_HashSecret = $paymentMethods->vnp_hashsecret;
        $vnp_Url = $paymentMethods->vnp_url;
        $vnp_ReturnUrl = config('vnpay.vnp_Returnurl');

        $vnp_TxnRef = $order->invoice_id;
        $vnp_OrderInfo = 'Thanh toán đơn hàng ' . $order->invoice_id;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->amount * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = '';

        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => Carbon::now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        $paymentMethods = PaymentSetting::where('method', 'vnpay')->first();
        $vnp_SecureHash  = $request->vnp_SecureHash;
        $inputData = $request->all();
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = '';
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . "&";
        }
        $hashData = rtrim($hashData, '&');
        $secureHash = hash_hmac('sha512', $hashData, $paymentMethods->vnp_hashsecret);

        if ($secureHash === $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                $order = $this->createOrder($request);
                $order->payment_status = true;
                $order->payment_method = 'VNPay';
                $order->save();
                $this->sendOrderConfirmation($order);
                session()->forget('cart');
                session()->forget('coupon');
                toastr('Thanh toán qua VNPay thành công!', 'success');
                return redirect()->route('order.complete');
            } else {
                toastr('Thanh toán qua VNPay thất bại!', 'error');
                return redirect()->route('checkout');
            }
        } else {
            toastr('Chữ ký bảo mật không chính xác!', 'error');
            return redirect()->route('checkout');
        }
    }
    private function createMoMoPayment($order)
    {
        $endpoint = config('services.momo.endpoint');
        $partnerCode = config('services.momo.partner_code');
        $accessKey = config('services.momo.access_key');
        $secretKey = config('services.momo.secret_key');
        // $serectkey = $secretKey;
        $orderId = $order->invoice_id;
        $orderInfo = "Thanh toán đơn hàng " . $orderId;
        $amount = $order->amount;
        $redirectUrl = config('services.momo.return_url');
        $ipnUrl = $redirectUrl;
        $extraData = "";
        $requestId = time() . "";
        $requestType = "payWithATM"; //captureWallet

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        ];

        $response = Http::post($endpoint, $data);

        if ($response->successful()) {
            $responseBody = $response->json();

            return redirect($responseBody['payUrl']);
        } else {
            toastr('Có lỗi xảy ra khi tạo thanh toán qua MoMo', 'error');
            return redirect()->route('checkout');
        }
    }
    public function momoReturn(Request $request)
    {
        $orderId = $request->input('orderId');
        $order = Order::where('invoice_id', $orderId)->first();

        if ($order && $request->input('errorCode') == '0') {
            $order->payment_status = true;
            $order->payment_method = 'MoMo';
            $order->save();

            $this->sendOrderConfirmation($order);
            session()->forget('cart');
            session()->forget('coupon');
            toastr('Thanh toán qua MoMo thành công!', 'success');
            return redirect()->route('order.complete');
        } else {
            toastr('Thanh toán qua MoMo thất bại!', 'error');
            return redirect()->route('checkout');
        }
    }

    private function sendOrderConfirmation($order)
    {
        $user = Auth::user();
        Mail::to($user->email)->send(new OrderConfirmation($order));
    }
}
