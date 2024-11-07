<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpOffice\PhpSpreadsheet\Calculation\Category;

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

    public function ProductAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // public function categoryProduct()
    // {
    //     return $this->belongsTo(CategoryProduct::class);
    // }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function category()
    {
        return $this->belongsTo(CategoryProduct::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
