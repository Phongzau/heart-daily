<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Banner;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\NewletterPopup;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\Social;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Truy vấn 3 sản phẩm có lượt bán nhiều nhất
        $topProductIds = OrderProduct::select('product_id', DB::raw('SUM(qty) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->pluck('product_id');

        $topProducts = Product::whereIn('id', $topProductIds)->take(3)->get();

        // truy vấn ra 6 sản phẩm có lượt bán nhiều nhất 
        $featuredProduct = Product::whereIn('id', $topProductIds)->take(5)->get();

        // Truy vấn 3 sản phẩm có lượt xem nhiều nhất
        $topViewedProducts = Product::orderBy('views', 'desc')->take(3)->get();
        $blogs = Blog::where('status', 1)->orderBy('created_at', 'desc')->paginate(10);
        $popup = NewletterPopup::query()->first();
        $slider = Banner::where('status', 1)->get();
        $homepage_section_banner_one = Advertisement::query()->where('key', 'homepage_section_banner_one')->first();
        $homepage_section_banner_one = json_decode($homepage_section_banner_one?->value);

        $homepage_section_banner_two = Advertisement::query()->where('key', 'homepage_section_banner_two')->first();
        $homepage_section_banner_two = json_decode($homepage_section_banner_two?->value);

        return view('client.page.home.home', compact('slider', 'blogs', 'popup', 'products', 'brands', 'homepage_section_banner_one', 'homepage_section_banner_two', 'topViewedProducts', 'topProducts', 'featuredProduct'));
    }
}
