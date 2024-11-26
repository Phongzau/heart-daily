<?php

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

function checkActive(array $route)
{
    if (is_array($route)) {
        foreach ($route as $r) {
            if (request()->routeIs($r)) {
                return 'active';
            }
        }
    }
}

function checkActiveClient($menuItemUrl)
{
    return request()->url() === config('app.url') . $menuItemUrl ? 'active' : 'hehe';
}

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
        case 'return':
            return "Trả hàng";
            break;
        default:
            return "";
            break;
    }
}

function checkReason($type)
{
    switch ($type) {
        case 'san_pham_loi':
            return "Sản phẩm bị lỗi";
            break;
        case 'giao_sai_san_pham':
            return "Giao sai sản phẩm";
            break;
        case 'san_pham_khong_giong_quang_cao':
            return "Sản phẩm không giống quảng cáo";
            break;
        case 'giao_hang_tre_hon_du_kien':
            return "Giao hàng trễ hơn dự kiến";
            break;
        case 'khong_con_nhu_cau':
            return "Không còn nhu cầu";
            break;
        default:
            return "";
            break;
    }
}

function checkReasonCancel($type)
{
    switch ($type) {
        case 'khong_muon_mua_nua':
            return "Không muốn mua nữa";
            break;
        case 'gia_re_hon_o_noi_khac':
            return "Giá rẻ hơn ở nơi khác";
            break;
        case 'thay_doi_dia_chi_giao_hang':
            return "Thay đổi địa chỉ giao hàng";
            break;
        case 'thay_doi_phuong_thuc_thanh_toan':
            return "Thay đổi phương thức thanh toán";
            break;
        case 'thay_doi_ma_giam_gia':
            return "Thay đổi mã giảm giá";
            break;
        default:
            return "";
            break;
    }
}
/** Check the product type */
function orderTypeReturn($type)
{
    switch ($type) {
        case 'pending':
            return "CHỜ XÁC NHẬN";
            break;
        case 'approved':
            return "ĐÃ DUYỆT";
            break;
        case 'rejected':
            return "TỪ CHỐI";
            break;
        case 'completed':
            return "Hoàn TẤT";
            break;
        default:
            return "";
            break;
    }
}

function renderOrderButtons($order_status, $order)
{
    $buttons = '';

    switch ($order_status) {
        case 'pending':
            $buttons .= '<button class="btn btn-danger cancel-order-button" id="myBtnCancelOrder" data-order-id="' . $order->id . '">Hủy Đơn Hàng</button>';
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
            $buttons .= '<button class="btn btn-success confirm-order-button" data-order-id="' . $order->id . '">Đã Nhận Hàng</button>';
            $buttons .= '<button class="btn btn-warning">Liên Hệ Người Bán</button>';
            break;

        case 'delivered':
            // $buttons .= '<button class="btn btn-primary">Đánh Giá</button>';
            $buttons .= '<button class="btn btn-success return-button" id="myBtnReturnOrder" data-order-id="' . $order->id . '">Hoàn Hàng</button>';
            $buttons .= '<button class="btn btn-primary reorder-button" data-order-id="' . $order->id . '">Mua Lại</button>';
            $buttons .= '<button class="btn btn-warning">Liên Hệ Người Bán</button>';
            break;

        case 'canceled':
            $buttons .= '<button class="btn btn-primary reorder-button" data-order-id="' . $order->id . '">Mua lại</button>';
            break;

        case 'return':
            if ($order->orderReturn->return_status == 'pending' || $order->orderReturn->return_status == 'approved') {
                $buttons .= '<button class="btn btn-danger cancel-order-return" data-order-id="' . $order->id . '">Hủy hoàn hàng</button>';
            }
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
