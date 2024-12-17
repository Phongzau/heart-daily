<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointTransaction extends Model
{
    public $fillable = [
        'user_id',
        'order_id',
        'type',
        'points',
        'description',
    ];
}
