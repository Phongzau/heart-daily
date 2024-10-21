<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocicalLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'facebook',
        'instagram',
        'twitter',
    ];
}
