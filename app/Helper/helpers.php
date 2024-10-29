<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

function limitText($text, $limit = 20)
{
    return Str::limit($text, $limit);
}

function limitTextDescription($text, $limit)
{
    // Loại bỏ các thẻ HTML nhưng giữ lại nội dung văn bản
    $cleanText = strip_tags($text);

    // Nếu nội dung dài hơn giới hạn, cắt bớt và thêm '...'
    if (strlen($cleanText) > $limit) {
        return substr($cleanText, 0, $limit) . '...';
    }

    return $cleanText;
}

/** Check if product have discount */

function checkDiscount($product)
{
    $currentDate = date('Y-m-d');

    if ($product->offer_price > 0 && $currentDate >= $product->offer_start_date && $currentDate <= $product->offer_end_date) {
        return true;
    }

    return false;
}

/** Get Cart Total */
function getCartTotal()
{
    $carts = session()->get('cart', []);
    $total = 0;
    foreach ($carts as $product) {
        $total += $product['price'] * $product['qty'];
    }
    return $total;
}

// Get Cart Total
function getMainCartTotal()
{
    $subTotal = getCartTotal();
    $cod = getCartCod();
    if (Session::has('coupon')) {
        $coupon = Session::get('coupon');
        // $subTotal = getCartTotal();
        if ($coupon['discount_type'] === 'amount') {
            $total = $subTotal - $coupon['discount'];
        } else if ($coupon['discount_type'] === 'percent') {
            $discount = $subTotal * $coupon['discount'] / 100;
            $total = $subTotal - $discount;
        }
        // return $total;
    } else {
        // return getCartTotal();
        $total = $subTotal;
    }
    $total += $cod;

    return $total;
}

// Get cart discount
function getCartDiscount()
{
    if (Session::has('coupon')) {
        $coupon = Session::get('coupon');
        $subTotal = getCartTotal();
        if ($coupon['discount_type'] === 'amount') {
            return $coupon['discount'];
        } else if ($coupon['discount_type'] === 'percent') {
            $discount = $subTotal * $coupon['discount'] / 100;
            return $discount;
        }
    } else {
        return 0;
    }
}
function fetchCartDiscountInfo()
{
    if (Session::has('coupon')) {
        $coupon = Session::get('coupon');
        return [
            'coupon_name' => $coupon['coupon_name'],
            'coupon_code' => $coupon['coupon_code'],
            'discount_type' => $coupon['discount_type'],
            'discount' => $coupon['discount'],
        ];
    } else {
        return null;
    }
}

// get order discount
function getOrderDiscount($discountType, $subTotal, $discount)
{
    if ($discountType === 'amount') {
        return $discount;
    } else if ($discountType === 'percent') {
        $discountValue = $subTotal * $discount / 100;
        return $discountValue;
    }
}

function getCartCod()
{
    $cod = 30000;
    return $cod;
}
