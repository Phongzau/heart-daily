<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        
        $perPage = $request->input('count', 12);
        $products = Product::query()->where('status', 1)->paginate($perPage);
        return view('client.page.product.list_product', compact('products'));
    }
    public function ajaxIndex(Request $request) {
        $perPage = $request->input('count', 12);
        $orderby  = $request->input('orderby', 'menu_order'); 

        $query = Product::with('brand')->where('status', 1);
    
        if ($orderby == 'price') {
            $query->orderBy('price', 'asc');
        } elseif ($orderby == 'price-desc') {
            $query->orderBy('price', 'desc');
        } elseif ($orderby == 'date') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'asc'); // Mặc định
        }
    
        $products = $query->paginate($perPage);
    
        return response()->json([
            'products' => $products,
        ]);
    }
    
}
