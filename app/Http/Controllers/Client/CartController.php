<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\UserCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $formDataString = $request->input('formData');
        parse_str($formDataString, $formDataArray);
        $qty = $formDataArray['qty'] ?? null;
        $product_id = $formDataArray['product_id'] ?? null;
        $variants = $request->input('variants', []);
        $attributeIdArray = [];
        $product = Product::query()->where('id', $product_id)->first();

        // Lấy giỏ hàng từ session (nếu chưa có thì khởi tạo một mảng rỗng)
        $cart = session()->get('cart', []);

        $productPrice = 0;
        if ($product->type_product === 'product_variant') {
            foreach ($variants as $variant) {
                $nameVariant = strtolower($variant);
                $slugVariant = Str::slug($nameVariant);
                $attributeId = Attribute::query()->where('slug', $slugVariant)->pluck('id')->first();
                $attributeIdArray[] = $attributeId;
            }
            $productVariant = ProductVariant::where('product_id', $product_id)
                ->whereJsonContains('id_variant', $attributeIdArray)
                ->first();
            if ($productVariant->qty === 0) {
                $variantString = '';
                foreach ($variants as $key => $value) {
                    $variantString = ucfirst($key) . ' ' . $value;
                }
                return response()->json([
                    'status' => 'error',
                    'message' => $variantString . ' tạm thời hết hàng',
                ]);
            }
            // else if ($productVariant->qty < $qty) {
            //     return response()->json([
            //         'status' => 'error',
            //         'message' => 'Số lượng vượt quá sản phẩm hiện có',
            //     ]);
            // }
            // Tạo ID duy nhất cho mỗi biến thể sản phẩm
            $cartKey = $product_id . '_' . implode('_', $attributeIdArray);

            $currentQtyInCart = isset($cart[$cartKey]) ? $cart[$cartKey]['qty'] : 0;
            $totalQtyToAdd = $currentQtyInCart + $qty;

            if ($totalQtyToAdd > $productVariant->qty) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng vượt quá sản phẩm hiện có. Chỉ còn ' . $productVariant->qty . ' sản phẩm trong kho.',
                ]);
            }

            if (checkDiscountVariant($productVariant)) {
                $productPrice += $productVariant->offer_price_variant;
            } else {
                $productPrice += $productVariant->price_variant;
            }

            // Kiểm tra xem sản phẩm biến thể đã có trong giỏ hàng
            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['qty'] += $qty;
            } else {
                // Thêm sản phẩm mới vào giỏ hàng
                $cart[$cartKey] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'qty' => $qty,
                    'price' => $productPrice,
                    'options' => [
                        'variants' => $variants,
                        'image' => $product->image,
                        'slug' => $product->slug,
                    ],
                ];
            }
        } else if ($product->type_product === 'product_simple') {
            if ($product->qty === 0) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Sản phẩm hết hàng',
                ]);
            }

            $cartKey = $product_id;
            $currentQtyInCart = isset($cart[$cartKey]) ? $cart[$cartKey]['qty'] : 0;
            $totalQtyToAdd = $currentQtyInCart + $qty;

            if ($totalQtyToAdd > $product->qty) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng vượt quá sản phẩm hiện có. Chỉ còn ' . $product->qty . ' sản phẩm trong kho.',
                ]);
            }

            if (checkDiscount($product)) {
                $productPrice += $product->offer_price;
            } else {
                $productPrice += $product->price;
            }

            if (isset($cart[$cartKey])) {
                $cart[$cartKey]['qty'] += $qty;
            } else {
                $cart[$cartKey] = [
                    'product_id' => $product_id,
                    'name' => $product->name,
                    'qty' => $qty,
                    'price' => $productPrice,
                    'options' => [
                        'image' => $product->image,
                        'slug' => $product->slug,
                    ],
                ];
            }
        }

        // Lưu giỏ hàng vào sesstion
        session()->put('cart', $cart);

        return response()->json([
            'status' => 'success',
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng',
        ]);
    }

    public function cartDetails()
    {
        // Session::forget('coupon');
        // Session::forget('point');
        $carts = session()->get('cart', []);
        if (count($carts) === 0) {
            Session::forget('coupon');
            toastr('Giỏ hàng đang trống bạn hãy làm đầy giỏ hàng nào 😊!', 'warning');
        }
        return view('client.page.cart-details', compact('carts'));
    }

    public function updateProductQty(Request $request)
    {
        // Lấy session cart
        $carts = session()->get('cart', []);
        $productCart = null;

        // Tìm sản phẩm muốn update số lượng trong giỏ hàng
        foreach ($carts as $cartKey => $cart) {
            if ($cartKey == $request->cartKey) {
                $productCart = $cart;
                break;
            }
        }

        if (!$productCart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng',
            ]);
        }

        $product = Product::query()->findOrFail($productCart['product_id']);
        if ($product->type_product === 'product_variant') {
            $attributeIdArray = [];
            foreach ($productCart['options']['variants'] as $variant) {
                $slugVariant = strtolower($variant);
                $attributeId = Attribute::query()->where('slug', $slugVariant)->pluck('id')->first();
                $attributeIdArray[] = $attributeId;
            }

            $productVariant = ProductVariant::where('product_id', $productCart['product_id'])
                ->whereJsonContains('id_variant', $attributeIdArray)
                ->first();

            if ($productVariant->qty < $request->quantity) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng vượt quá sản phẩm hiện có',
                    'current_qty' => $productCart['qty'],
                ]);
            }
        } else if ($product->type_product === 'product_simple') {
            if ($product->qty < $request->quantity) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Số lượng vượt quá sản phẩm hiện có',
                    'current_qty' => $productCart['qty'],
                ]);
            }
        }

        // Update số lượng sản phẩm trong giỏ hàng và lưu lại session
        foreach ($carts as $cartKey => &$cart) {
            if ($cartKey == $request->cartKey) {
                $cart['qty'] = $request->quantity;
                break;
            }
        }

        // Cập nhật lại giỏ hàng vào session
        session()->put('cart', $carts);
        $productTotal = $this->getProductTotal($request->cartKey);
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật số lượng sản phẩm thành công',
            'product_total' => number_format($productTotal),
        ]);
    }

    public function getProductTotal($keyCart)
    {
        $carts = session()->get('cart', []);
        foreach ($carts as $cartKey => $cart) {
            if ($cartKey == $keyCart) {
                return $cart['price'] * $cart['qty'];
            }
        }

        return 0;
    }

    public function cartTotal()
    {
        $carts = session()->get('cart', []);
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart['price'] * $cart['qty'];
        }
        return number_format($total);
    }

    public function getTotalCart()
    {
        $carts = session()->get('cart', []);
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart['price'] * $cart['qty'];
        }
        $total += 30000;
        return $total;
    }

    public function couponCalculation()
    {
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            $subTotal = $this->getTotalCart();
            if ($coupon['discount_type'] === 'amount') {
                $total = $subTotal - $coupon['discount'];
                // $total giá sau khuyến mãi
                if (Session::has('point')) {
                    if ($total < Session::get('point')['point_value']) {
                        $refundPoint = Session::get('point')['point_value'] - $total;
                        Session::put('point', ['point_value' => Session::get('point')['point_value'] - $refundPoint]);
                    }
                    $total -= Session::get('point')['point_value'];
                }
                return response([
                    'status' => 'success',
                    'cart_total' =>  number_format($total),
                    'discount' => number_format($coupon['discount']),
                    'point_value' => number_format(Session::get('point')['point_value']),
                ]);
            } else if ($coupon['discount_type'] === 'percent') {
                if (isset($coupon['max_discount'])) {
                    $maxDiscount = $coupon['max_discount'];
                    $discount = $subTotal * $coupon['discount'] / 100;

                    if ($discount > $maxDiscount) {
                        $discount = $maxDiscount;
                    }

                    $total = $subTotal - $discount;
                    if (Session::has('point')) {
                        if ($total < Session::get('point')['point_value']) {
                            $refundPoint = Session::get('point')['point_value'] - $total;
                            Session::put('point', ['point_value' => Session::get('point')['point_value'] - $refundPoint]);
                        }
                        $total -= Session::get('point')['point_value'];
                    }
                    return response([
                        'status' => 'success',
                        'cart_total' =>  number_format($total),
                        'discount' => number_format($discount),
                        'point_value' => number_format(Session::get('point')['point_value']),
                    ]);
                } else {
                    $discount = $subTotal * $coupon['discount'] / 100;
                    $total = $subTotal - $discount;
                    if (Session::has('point')) {
                        if ($total < Session::get('point')['point_value']) {
                            $refundPoint = Session::get('point')['point_value'] - $total;
                            Session::put('point', ['point_value' => Session::get('point')['point_value'] - $refundPoint]);
                        }
                        $total -= Session::get('point')['point_value'];
                    }
                    return response([
                        'status' => 'success',
                        'cart_total' =>  number_format($total),
                        'discount' => number_format($discount),
                        'point_value' => number_format(Session::get('point')['point_value']),
                    ]);
                }
            }
        } else {
            $total = $this->getTotalCart();
            if (Session::has('point')) {
                $total -= Session::get('point')['point_value'];
            }
            return response()->json([
                'status' => 'success',
                'cart_total' => number_format($total),
                'discount' => 0,
                'point_value' => number_format(Session::get('point')['point_value']),
            ]);
        }
    }

    public function applyCoupon(Request $request)
    {
        if ($request->coupon_code === null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Mã giảm giá không được để trống!',
            ]);
        }

        if (Session::has('coupon')) {
            $oldCoupon = Session::get('coupon');
            if ($request->coupon_code == $oldCoupon['coupon_code']) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mã giảm đã được áp dụng rồi!',
                ]);
            }
        }

        $coupon = Coupon::query()
            ->where('code', $request->coupon_code)
            ->where('status', 1)
            ->first();
        // Kiểm tra ngày bắt đầu và ngày hết hạn với Carbon
        $currentDate = Carbon::now()->format('Y-m-d');
        if ($coupon === null) {
            return response([
                'status' => 'error',
                'message' => 'Mã giảm giá không tồn tại',
            ]);
        } else if ($coupon->start_date > $currentDate) {
            return response([
                'status' => 'error',
                'message' => 'Mã giảm giá không tồn tại!',
            ]);
        } else if ($coupon->end_date < $currentDate) {
            return response([
                'status' => 'error',
                'message' => 'Mã giảm giá đã hết hạn!',
            ]);
        } else if ($coupon->total_used >= $coupon->quantity) {
            return response([
                'status' => 'error',
                'message' => 'Bạn không thể áp dụng mã giảm giá này!',
            ]);
        }

        if ($coupon->is_publish == 0) {
            $userHasCoupon = UserCoupon::query()
                ->where('user_id', Auth::user()->id)
                ->where('coupon_id', $coupon->id)
                ->exists();

            if (!$userHasCoupon) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn không có mã giảm giá này',
                ]);
            }
        } else {
            $usageCount = Order::query()
                ->whereJsonContains('coupon_method', ['coupon_code' => $coupon->code])
                ->where('order_status', '!=', 'canceled')
                ->count();
            if ($usageCount >= $coupon->max_use) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Mã giảm giá này đã được sử dụng quá số lần cho phép',
                ]);
            }
        }

        if ($coupon->min_order_value > 0) {
            $carts = session()->get('cart', []);
            $total = 0;
            foreach ($carts as $cart) {
                $total += $cart['price'] * $cart['qty'];
            }
            if ($total < $coupon->min_order_value) {
                return response([
                    'status' => 'error',
                    'message' => 'Tổng giá trị giỏ hàng phải đạt để sử dụng: ' . number_format($coupon->min_order_value) . ' VND',
                ]);
            }
        }

        if ($coupon->discount_type === 'amount') {
            Session::put('coupon', [
                'coupon_name' => $coupon->name,
                'coupon_code' => $coupon->code,
                'discount_type' => 'amount',
                'discount' => $coupon->discount,
            ]);
        } else if ($coupon->discount_type === 'percent') {
            if ($coupon->max_discount_percent && $coupon->max_discount_percent != null && $coupon->max_discount_percent > 0) {
                Session::put('coupon', [
                    'coupon_name' => $coupon->name,
                    'coupon_code' => $coupon->code,
                    'discount_type' => 'percent',
                    'discount' => $coupon->discount,
                    'max_discount' => $coupon->max_discount_percent,
                ]);
            } else {
                Session::put('coupon', [
                    'coupon_name' => $coupon->name,
                    'coupon_code' => $coupon->code,
                    'discount_type' => 'percent',
                    'discount' => $coupon->discount,
                ]);
            }
        }

        return response([
            'status' => 'success',
            'message' => 'Áp dụng mã giảm giá thành công!'
        ]);
    }

    public function clearCart()
    {
        Session::forget('cart');

        return response([
            'status' => 'success',
            'message' => 'Giỏ hàng đã được xóa thành công!',
        ]);
    }

    public function removeProduct(string $cartKey)
    {
        $carts = session()->get('cart', []);

        if (array_key_exists($cartKey, $carts)) {
            unset($carts[$cartKey]);
            session()->put('cart', $carts);
        }
        toastr('Xóa sản phẩm thành công', 'success');
        return redirect()->back();
    }

    public function removeSidebarProduct(Request $request)
    {
        $carts = session()->get('cart', []);

        if (array_key_exists($request->cartKey, $carts)) {
            unset($carts[$request->cartKey]);
            session()->put('cart', $carts);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Xóa sản phẩm thành công',
        ]);
    }

    public function getCartCount()
    {
        $carts = session()->get('cart', []);
        // Nếu cart là một mảng và không rỗng
        if (is_array($carts) && !empty($carts)) {
            return count($carts);
        }

        return 0;
    }

    public function getCartProducts()
    {
        $carts = session()->get('cart', []);
        return $carts;
    }

    function getAmountTotal()
    {
        $subTotal = getCartTotal();
        $cod = getCartCod();
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            if ($coupon['discount_type'] === 'amount') {
                $total = $subTotal - $coupon['discount'];
            } else if ($coupon['discount_type'] === 'percent') {
                if (isset($coupon['max_discount'])) {
                    $maxDiscount = $coupon['max_discount'];
                    $discount = $subTotal * $coupon['discount'] / 100;

                    if ($discount > $maxDiscount) {
                        $discount = $maxDiscount;
                    }
                    $total = $subTotal - $discount;
                } else {
                    $discount = $subTotal * $coupon['discount'] / 100;
                    $total = $subTotal - $discount;
                }
            }
        } else {
            $total = $subTotal;
        }

        $total += $cod;

        return $total;
    }

    public function usePoint(Request $request)
    {
        $request->validate([
            'point' => ['required', 'min:1', 'integer'],
        ], [
            'point.required' => 'Điểm không được bỏ trống',
            'point.min' => 'Tối thiểu 1 điểm',
            'point.integer' => 'Điểm phải là số',
        ]);

        $user = Auth::user();
        $total = $this->getAmountTotal();
        if ($request->point > $total) {
            $useablePoint = $total;
        } else {
            $useablePoint = $request->point;
        }

        if ($request->point > $user->point) {
            return response()->json([
                'status' => 'error',
                'message' => 'Số điểm sử dụng vượt quá số điểm hiện có',
            ]);
        }

        Session::put('point', [
            'point_value' => (float)$useablePoint,
        ]);

        if ($request->point > $total) {
            return response()->json([
                'status' => 'success',
                'message' => "Bạn chỉ được sử dụng tối đa " . number_format($useablePoint) . " điểm tương đương với số tiền đơn hàng là: " . number_format($useablePoint),
                'useablePoint' => number_format($useablePoint),
            ]);
        }
        return response()->json([
            'status' => 'success',
            'message' => "Sử dụng thành công " . number_format($useablePoint) . "điểm",
            'useablePoint' => number_format($useablePoint),
        ]);
    }
}
