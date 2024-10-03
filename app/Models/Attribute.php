<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category_attribute_id',
        'price_start',
        'price_end',
        'status',
        'userid_created',
        'userid_updated',
    ];


    public function categoryAttribute()
    {
        return $this->belongsTo(CategoryAttribute::class , 'category_attribute_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'userid_created');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'userid_updated');
    }
}
