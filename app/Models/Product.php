<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function ProductVariants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function ProductImageGalleries()
    {
        return $this->hasMany(ProductImageGallery::class);
    }
}
