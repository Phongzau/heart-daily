<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    public function index()
    {
        $carts = session('cart', []);
        return view('client.page.checkout', compact('carts'));
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
            'payment_method' => 'required|string|in:cod,vnpay',

        ]);
        $subTotal = getCartTotal();
        $shippingCost = getCartCod();
        $discountInfo = fetchCartDiscountInfo();
        $totalAmount = getMainCartTotal();
        // do {
        //     $invoiceId = rand(100000, 999999);
        // } while (Order::where('invoice_id', $invoiceId)->exists());
        $order = new Order();
        $order->invoice_id = (string) Str::uuid();
        $order->user_id = Auth::id();
        $order->sub_total = $subTotal;
        $order->amount = $totalAmount;
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
        $order->cod = $shippingCost;
        $order->order_status = now();
        $order->coupon_method = json_encode($discountInfo ?? []);

        if ($request->input('payment_method') === 'vnpay') {
            return $this->createPayment($order);
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
    // private function getOrderAddress($request)
    // {
    //     return $request->address . ', ' . $request->ward . ', ' . $request->district . ', ' . $request->city;
    // }
    private function createPayment($order)
    {
        $vnp_TmnCode = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url = config('vnpay.vnp_Url');
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
        // $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_SecureHash  = $request->vnp_SecureHash;
        $inputData = $request->all();
        // $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = '';
        foreach ($inputData as $key => $value) {
            $hashData .= urlencode($key) . "=" . urlencode($value) . "&";
        }
        $hashData = rtrim($hashData, '&');
        $secureHash = hash_hmac('sha512', $hashData, config('vnpay.vnp_HashSecret'));
        if ($secureHash === $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                $carts = session('cart', []);
                $subTotal = getCartTotal();
                $shippingCost = getCartCod();
                $discountInfo = fetchCartDiscountInfo();
                $totalAmount = getMainCartTotal();
                // do {
                //     $invoiceId = rand(100000, 999999);
                // } while (Order::where('invoice_id', $invoiceId)->exists());
                $order = new Order();
                $order->invoice_id = (string) Str::uuid();
                $order->user_id = Auth::id();
                $order->sub_total = $subTotal;
                $order->amount = $totalAmount;
                $order->product_qty = array_sum(array_column($carts, 'qty'));
                $order->payment_status = true;
                $order->payment_method = 'VNPay';
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
                $order->cod = $shippingCost;
                $order->order_status = now();
                $order->coupon_method = json_encode($discountInfo ?? []);
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


    private function sendOrderConfirmation($order)
    {
        $user = Auth::user();
        Mail::to($user->email)->send(new OrderConfirmation($order));
    }
}