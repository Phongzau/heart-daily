<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function district()
    {
        return $this->hasMany(District::class);
    }

    public function commnue()
    {
        return $this->hasMany(Commune::class);
    }
}
