<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawRequest extends Model
{
    public $fillable = [
        'user_id',
        'point',
        'equivalent_money',
        'bank_name',
        'final_balance',
        'account_name',
        'bank_account',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
