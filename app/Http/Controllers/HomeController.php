<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\NewletterPopup;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $brands = Brand::query()->where('status', 1)->get();
        $products = Product::with('brand')
            ->where('status', 1)
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('created_at', 'desc')
            ->get();
        $slider = Banner::all();
        $blogs = Blog::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
        $popup = NewletterPopup::query()->first();
        return view('client.page.home.home', compact('slider', 'products','brands','blogs','popup'));
    }
}