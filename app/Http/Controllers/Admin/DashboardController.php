<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderProduct;
use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);

        $pendingCount = Order::where('order_status', 'pending')
            ->whereMonth('created_at', $month)
            ->count();

        $readyCount = Order::where('order_status', 'processed_and_ready_to_ship')
            ->whereMonth('created_at', $month)
            ->count();

        $droppedOffCount = Order::where('order_status', 'dropped_off')
            ->whereMonth('created_at', $month)
            ->count();

        $shippingCount = Order::where('order_status', 'shipped')
            ->whereMonth('created_at', $month)
            ->count();

        $areDeliveringCount = Order::where('order_status', 'out_for_delivery')
            ->whereMonth('created_at', $month)
            ->count();

        $completedCount = Order::where('order_status', 'delivered')
            ->whereMonth('created_at', $month)
            ->count();

        $totalOrdersCount = $pendingCount + $readyCount + $droppedOffCount + $shippingCount + $areDeliveringCount + $completedCount;

        $totalRevenue = Order::where('order_status', 'delivered')
            ->whereMonth('created_at', $month)
            ->sum('amount');

        $totalProductsSold = OrderProduct::whereHas('order', function ($query) use ($month) {
            $query->where('order_status', 'delivered')
                ->whereMonth('created_at', $month);
        })->sum('qty');

        // Lấy tên tháng
        $monthName = Carbon::createFromFormat('m', $month)->format('F');
        $orders = Order::with('user')->orderBy('created_at', 'desc')->take(3)->get();
        
        // Trả về view cùng dữ liệu
        return view('admin.page.dashboard', [
            'pendingCount' => $pendingCount ?? 0,
            'shippingCount' => $shippingCount ?? 0,
            'completedCount' => $completedCount ?? 0,
            'totalOrdersCount' => $totalOrdersCount ?? 0,
            'totalRevenue' => $totalRevenue ?? 0,
            'totalProductsSold' => $totalProductsSold ?? 0,
            'month' => $month,
            'monthName' => $monthName,
            'orders' => $orders
        ]);
    }

    public function orderStatistics(Request $request, $month)
    {

        $pendingCount = Order::where('order_status', 'pending')
            ->whereMonth('created_at', $month)
            ->count();

        $readyCount = Order::where('order_status', 'processed_and_ready_to_ship')
            ->whereMonth('created_at', $month)
            ->count();

        $droppedOffCount = Order::where('order_status', 'dropped_off')
            ->whereMonth('created_at', $month)
            ->count();

        $shippingCount = Order::where('order_status', 'shipped')
            ->whereMonth('created_at', $month)
            ->count();

        $areDeliveringCount = Order::where('order_status', 'out_for_delivery')
            ->whereMonth('created_at', $month)
            ->count();

        $completedCount = Order::where('order_status', 'delivered')
            ->whereMonth('created_at', $month)
            ->count();

        $totalOrdersCount = $pendingCount + $readyCount + $droppedOffCount + $shippingCount + $areDeliveringCount + $completedCount;

        $totalRevenue = Order::where('order_status', 'delivered')
            ->whereMonth('created_at', $month)
            ->sum('amount');

        $totalProductsSold = OrderProduct::whereHas('order', function ($query) use ($month) {
            $query->where('order_status', 'delivered')
                ->whereMonth('created_at', $month);
        })->sum('qty');

        $startOfMonth = Carbon::createFromFormat('m', $month)->startOfMonth();
        $endOfMonth = Carbon::createFromFormat('m', $month)->endOfMonth();
        $weeksInMonth = $startOfMonth->diffInWeeks($endOfMonth) + 1;

        $labels = [];
        $revenueData = [];
        $salesData = [];
        for ($week = 0; $week < $weeksInMonth; $week++) {
            $startOfWeek = $startOfMonth->copy()->addWeeks($week);
            $endOfWeek = $startOfMonth->copy()->addWeeks($week + 1);

            $weekRevenue = Order::where('order_status', 'delivered')
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->sum('amount');
            $revenueData[] = $weekRevenue;

            $weekSales = OrderProduct::whereHas('order', function ($query) use ($startOfWeek, $endOfWeek) {
                $query->where('order_status', 'delivered')
                    ->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            })->sum('qty');
            $salesData[] = $weekSales;

            $labels[] = $startOfWeek->format('d/m') . " - " . $endOfWeek->format('d/m');
        }

        return response()->json([
            'pendingCount' => $pendingCount ?? 0,
            'shippingCount' => $shippingCount ?? 0,
            'completedCount' => $completedCount ?? 0,
            'totalOrdersCount' => $totalOrdersCount ?? 0,
            'totalRevenue' => $totalRevenue ?? 0,
            'totalProductsSold' => $totalProductsSold ?? 0,
            'monthName' => Carbon::createFromFormat('m', $month)->format('F'),
            'chartLabels' => $labels,
            'revenueData' => $revenueData,
            'salesData' => $salesData,

        ]);
    }
    public function yearlyStatistics(Request $request)
    {
        $year = Carbon::now()->year;
        $monthlyRevenue = [];
        $monthlySales = [];

        for ($month = 1; $month <= 12; $month++) {
            $startOfMonth = Carbon::createFromDate($year, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::createFromDate($year, $month, 1)->endOfMonth();


            $revenue = Order::where('order_status', 'delivered')
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount');
            $monthlyRevenue[] = $revenue;


            $sales = OrderProduct::whereHas('order', function ($query) use ($startOfMonth, $endOfMonth) {
                $query->where('order_status', 'delivered')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
            })->sum('qty');
            $monthlySales[] = $sales;
        }

        return response()->json([
            'monthlyRevenue' => $monthlyRevenue,
            'monthlySales' => $monthlySales,
        ]);
    }

    public function topProducts(Request $request, $period)
    {
        $startDate = null;
        $endDate = null;

        switch ($period) {
            case 'today':
                $startDate = Carbon::today()->startOfDay();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
        }

        // Lấy top 5 sản phẩm bán chạy trong khoảng thời gian
        $topProducts = OrderProduct::select('product_id', DB::raw('SUM(qty) as total_sales'))
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('order_status', 'delivered');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->limit(5)
            ->get();

        $products = $topProducts->map(function ($product) {
            return [
                'name' => $product->product->name,
                'sales' => $product->total_sales,
                'image' => $product->product->image,
            ];
        });

        return response()->json($products);
    }

    public function getTopRevenue($period)
    {

        $startDate = null;
        $endDate = null;

        switch ($period) {
            case 'today':
                $startDate = Carbon::today()->startOfDay();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'year':
                $startDate = Carbon::now()->startOfYear();
                $endDate = Carbon::now()->endOfYear();
                break;
            default:
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
        }

        // Lấy top 5 sản phẩm có doanh thu cao nhất trong khoảng thời gian
        $topRevenueProducts = OrderProduct::select('product_id', DB::raw('SUM(qty * unit_price) as total_revenue'))
            ->whereHas('order', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate])
                    ->where('order_status', 'delivered');
            })
            ->groupBy('product_id')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();
        $products = $topRevenueProducts->map(function ($product) {
            return [
                'name' => $product->product->name,
                'revenue' => $product->total_revenue,
                'image' => $product->product->image,
            ];
        });

        return response()->json($products);
    }
    public function bestRatedProducts()
    {
        $bestRatedProducts = ProductReview::select('product_id', DB::raw('AVG(rate) as avg_rating'), DB::raw('COUNT(*) as review_count'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('avg_rating') 
            ->limit(5) 
            ->get();

        $products = $bestRatedProducts->map(function ($item) {
            return [
                'name' => $item->product->name,
                'image' => $item->product->image,
                'slug' => $item->product->slug,
                'avg_rating' => number_format($item->avg_rating, 1),
                'review_count' => $item->review_count,
            ];
        });

        return response()->json($products);
    }


