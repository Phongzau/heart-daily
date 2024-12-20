<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    use HasFactory;
    public function parentId()
    {
        return $this->belongsTo(CategoryProduct::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CategoryProduct::class, 'parent_id')->with('children');
    }
}
