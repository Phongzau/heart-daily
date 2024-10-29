<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaypalSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'method',
        'status',
        'mode',
        'currency_name',
        'currency_rate',
        'client_id',
        'secret_key',
    ];
}
