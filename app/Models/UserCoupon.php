<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCoupon extends Model
{
    public $fillable = [
        'user_id',
        'coupon_id',
        'qty',
    ];
}