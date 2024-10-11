<?php

namespace App\Helper;

class BadwordsHelper
{
    protected static $badWords;

    public static function init()
    {
        // Khởi tạo mảng từ nhạy cảm
        self::$badWords = require base_path('app/Helper/badwords.php');
    }

    public static function isProfane($text)
    {
        // Chuyển đổi văn bản thành chữ thường
        $textLower = strtolower($text);

        foreach (self::$badWords as $badWord) {
            // Kiểm tra từ xấu trong văn bản viết liền hoặc có dấu cách
            if (strpos($textLower, $badWord) !== false) {
                return true; // Có từ xấu
            }
        }
        return false; // Không có từ xấu
    }
}

// Khởi tạo helper
BadwordsHelper::init();
