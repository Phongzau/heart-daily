<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\User;


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat-channel.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});

Broadcast::channel('coupon-channel', function () {
    return true; // Hoặc kiểm tra quyền truy cập kênh ở đây nếu cần
});

Broadcast::channel('user.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;  // Kiểm tra quyền truy cập cho người dùng với ID tương ứng
});
