<?php

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
