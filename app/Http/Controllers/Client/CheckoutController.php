<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\PaypalSetting;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Transaction;
use App\Models\VnpaySetting;
use App\Models\Attribute;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class CheckoutController extends Controller
{

    public function index()
    {
        $carts = session('cart', []);
        $paymentSetting = VnpaySetting::where('status', 1)->get(['method', 'name']);
        $paypalSetting = PaypalSetting::where('status', 1)->get(['method', 'name']);


        $paymentMethods = collect();
        if ($paymentSetting->isNotEmpty()) {
            $paymentMethods = $paymentMethods->merge($paymentSetting);
        }
        if ($paypalSetting->isNotEmpty()) {
            $paymentMethods = $paymentMethods->merge($paypalSetting);
        }
        return view('client.page.checkout', compact('carts', 'paymentMethods'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email',
            'address' => 'required|string|max:255',
            'province_id' => 'required|string|max:100',
            'district_id' => 'required|string|max:100',
            'commune_id' => 'required|string|max:100',
            'payment_method' => 'required|string|in:cod,vnpay,paypal',
        ]);

        session(['address' => $request->only([
            'first_name',
            'phone',
            'email',
            'address',
            'province_id',
            'district_id',
            'commune_id',
        ])]);

        $paymentMethod = $request->input('payment_method');
        $order = $this->createOrder($request);

        if ($paymentMethod === 'vnpay') {
            return $this->createPayment($order);
        } elseif ($paymentMethod === 'paypal') {
            return $this->payWithPaypal();
        } else {
            return $this->handleCodPayment();
        }
    }
    private function handleCodPayment()
    {
        $transactionId = Str::random(10);
        $paidAmount = getMainCartTotal();
        $paidCurrencyName = 'VND';
        $this->storeOrder('cod', 0, $transactionId, $paidAmount, $paidCurrencyName);
        $this->clearSession();
        toastr('Đơn hàng của bạn đã được đặt thành công!', 'success');
        return redirect()->route('order.complete');
    }

    public function orderComplete()
    {
        return view('client.page.complete');
    }

    public function storeOrder($paymentMethod, $paymentStatus, $transactionId, $paidAmount, $paidCurrencyName)
    {
        DB::beginTransaction();

        try {
            $carts = session('cart', []);

            // Lưu thông tin đơn hàng
            $order = new Order();
            $order->invoice_id = (string) Str::uuid();
            $order->user_id = Auth::user()->id;
            $order->sub_total = getCartTotal();
            $order->amount = getMainCartTotal();
            $order->product_qty = count($carts);
            $order->payment_method = $paymentMethod;
            $order->payment_status = $paymentStatus;
            $order->order_address = json_encode(session()->get('address'));
            $order->cod = getCartCod();
            $order->coupon_method = json_encode(session()->get('coupon'));
            $order->order_status = 'pending';
            $order->save();

            // Lưu sản phẩm trong đơn hàng
            foreach ($carts as $item) {
                $product = Product::query()->findOrFail($item['product_id']);
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $order->id;
                $orderProduct->product_id = $item['product_id'];
                $orderProduct->product_name = $item['name'];

                if ($product->type_product == 'product_simple') {
                    $orderProduct->variants = "Không";
                    $product->qty -= $item['qty'];
                    $product->save();
                } else if ($product->type_product == 'product_variant') {
                    $orderProduct->variants = json_encode($item['options']['variants']);
                    $attributeIdArray = [];
                    foreach ($item['options']['variants'] as $variant) {
                        $nameVariant = strtolower($variant);
                        $slugVariant = Str::slug($nameVariant);
                        $attributeId = Attribute::query()->where('slug', $slugVariant)->pluck('id')->first();
                        $attributeIdArray[] = $attributeId;
                    }

                    $productVariant = ProductVariant::where('product_id', $item['product_id'])
                        ->whereJsonContains('id_variant', $attributeIdArray)
                        ->first();
                    $productVariant->qty -= $item['qty'];
                    $productVariant->save(); // Cập nhật số lượng cho biến thể
                }

                $orderProduct->unit_price = $item['price'];
                $orderProduct->qty = $item['qty'];
                $orderProduct->save();
            }

            // Lưu thông tin giao dịch
            $transaction = new Transaction();
            $transaction->order_id = $order->id;
            $transaction->transaction_id = $transactionId;
            $transaction->payment_method = $paymentMethod;
            $transaction->amount = getMainCartTotal();
            $transaction->amount_real_currency = $paidAmount;
            $transaction->amount_real_currency_name = $paidCurrencyName;
            $transaction->save();

            // Commit transaction
            DB::commit();
        } catch (\Exception $e) {
            // Rollback transaction nếu có lỗi
            DB::rollBack();
            // Xử lý lỗi hoặc ghi log nếu cần
            throw $e;
        }
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
            'first_name' => $request->input('first_name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'address' => $request->input('address'),
            'province_id' => $request->input('province_id'),
            'district_id' => $request->input('district_id'),
            'commune_id' => $request->input('commune_id'),
            'order_comments' => $request->input('order_comments'),
        ]);
        $order->cod = getCartCod();
        $order->order_status = now();
        $order->coupon_method = json_encode(fetchCartDiscountInfo() ?? []);

        return $order;
    }

    private function createPayment($order)
    {
        $paymentMethods = VnpaySetting::where('method', 'vnpay')->first();

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
        $paymentMethods = VnpaySetting::where('method', 'vnpay')->first();
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
                $transactionId = $request->vnp_TransactionNo;
                $paidAmount = $request->vnp_Amount / 100;
                $paidCurrencyName = 'VND';
                $this->storeOrder('vnpay', true, $transactionId, $paidAmount, $paidCurrencyName);
                $this->clearSession();

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

    public function paypalConfig()
    {
        $paypalSetting  = PaypalSetting::query()->firstOrFail();
        $config = [
            'mode'    => $paypalSetting->mode === 1 ? 'live' : 'sandbox',
            'sandbox' => [
                'client_id'         => $paypalSetting->client_id,
                'client_secret'     => $paypalSetting->secret_key,
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => $paypalSetting->client_id,
                'client_secret'     => $paypalSetting->secret_key,
                'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
            ],

            'payment_action' => 'Sale',
            'currency'       => $paypalSetting->currency_name,
            'notify_url'     => '',
            'locale'         => 'en_US',
            'validate_ssl'   => true,
        ];
        return $config;
    }

    public function payWithPaypal()
    {
        $config = $this->paypalConfig();
        $paypalSetting  = PaypalSetting::query()->findOrFail(1);

        $provider = new PayPalClient($config);
        $provider->getAccessToken();
        // $provider->setApiCredentials($config);
        // Tính giá trị chuyển đổi thành USD
        $total = getMainCartTotal();
        $payableAmount = round($total / $paypalSetting->currency_rate, 2);
        $response = $provider->createOrder([
            "intent" => "CAPTURE",

            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => $config['currency'],
                        "value" => $payableAmount,
                    ],
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('paypal.cancel');
        }
    }

    public function paypalSuccess(Request $request)
    {
        $config = $this->paypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            // calculate payable amount depending on currency rate
            $paypalSetting = PaypalSetting::query()->findOrFail(1);
            $total = getMainCartTotal();
            $paidAmount = round($total / $paypalSetting->currency_rate, 2);

            $this->storeOrder('paypal', 1, $response['id'], $paidAmount, $paypalSetting->currency_name);

            // clear session
            $this->clearSession();
            toastr('Thanh toán qua Paypal thành công!', 'success');
            return redirect()->route('order.complete');
        }

        return redirect()->route('paypal.cancel');
    }

    public function paypalCancel()
    {
        toastr('Bạn vui lòng thử lại', 'error');
        return redirect()->route('checkout');
    }

    public function clearSession()
    {
        session()->forget('cart');
        session()->forget('coupon');
        session()->forget('address');
    }
}
