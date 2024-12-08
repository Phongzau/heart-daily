<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservedStock extends Model
{
    public $fillable = [
        'product_id',
        'variant_id',
        'session_id',
        'reserved_qty',
        'expires_at',
    ];
}
