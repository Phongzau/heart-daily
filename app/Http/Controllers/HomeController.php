<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Banner;
use App\Models\Brand;
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
            $slider = Banner::where('status', 1)->get();
        $homepage_section_banner_one = Advertisement::query()->where('key', 'homepage_section_banner_one')->first();
        $homepage_section_banner_one = json_decode($homepage_section_banner_one?->value);
        return view('client.page.home.home', compact('slider', 'products', 'brands', 'homepage_section_banner_one'));
    }
}
