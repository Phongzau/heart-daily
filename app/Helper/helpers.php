<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

function limitText($text, $limit = 20)
{
    return Str::limit($text, $limit);
}

/** Check the product type */
function orderType($type)
{
    switch ($type) {
        case 'pending':
            return "CHỜ XÁC NHẬN";
            break;
        case 'processed_and_ready_to_ship':
            return "ĐƠN HÀNG ĐÃ SẴN SÀNG VẬN CHUYỂN";
            break;
        case 'dropped_off':
            return "ĐƠN HÀNG ĐÃ GỬI CHO ĐƠN VỊ VẬN CHUYỂN";
            break;
        case 'shipped':
            return "ĐANG GIAO HÀNG";
            break;
        case 'delivered':
            return "ĐÃ NHẬN HÀNG";
            break;
        case 'canceled':
            return "ĐÃ HỦY ĐƠN HÀNG";
            break;
        default:
            return "";
            break;
    }
}

function renderOrderButtons($order_status, $id)
{
    $buttons = '';

    switch ($order_status) {
        case 'pending':
            $buttons .= '<button class="btn btn-danger cancel-order-button" data-order-id="' . $id . '">Hủy Đơn Hàng</button>';
            $buttons .= '<button class="btn btn-warning">Liên Hệ Người Bán</button>';
            break;

        case 'processed_and_ready_to_ship':
            $buttons .= '<button class="btn btn-danger" disabled>Hủy Đơn Hàng</button>';
            $buttons .= '<button class="btn btn-warning">Liên Hệ Người Bán</button>';
            break;

        case 'dropped_off':
            $buttons .= '<button class="btn btn-success" disabled>Đã Nhận Hàng</button>';
            $buttons .= '<button class="btn btn-warning">Liên Hệ Người Bán</button>';
            break;

        case 'shipped':
            $buttons .= '<button class="btn btn-success confirm-order-button" data-order-id="' . $id . '">Đã Nhận Hàng</button>';
            $buttons .= '<button class="btn btn-warning">Liên Hệ Người Bán</button>';
            break;

        case 'delivered':
            $buttons .= '<button class="btn btn-primary">Đánh Giá</button>';
            $buttons .= '<button class="btn btn-primary reorder-button" data-order-id="' . $id . '">Mua Lại</button>';
            $buttons .= '<button class="btn btn-warning">Liên Hệ Người Bán</button>';
            break;

        case 'canceled':
            $buttons .= '<button class="btn btn-primary reorder-button" data-order-id="' . $id . '">Mua lại</button>';
            break;

        default:
            break;
    }

    return $buttons;
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
