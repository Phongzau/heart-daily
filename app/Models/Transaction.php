<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
