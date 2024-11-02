<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Wishlist extends Model
{
    use HasFactory;

    public static function countWishlist($product_id){
        $countWishlist = Wishlist::where(['user_id' => Auth::user()->id,'product_id' => $product_id])->count();
        return $countWishlist;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
}
