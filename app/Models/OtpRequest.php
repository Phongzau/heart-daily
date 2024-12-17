<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpRequest extends Model
{
    public $fillable = [
        'email',
        'otp',
        'otp_send_at',
    ];
}
