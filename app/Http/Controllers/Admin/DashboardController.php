<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);

        $pendingCount = Order::where('order_status', 'pending')
            ->whereMonth('created_at', $month)
            ->count();

        $shippingCount = Order::where('order_status', 'shipped')
            ->whereMonth('created_at', $month)
            ->count();

        $completedCount = Order::where('order_status', 'delivered')
            ->whereMonth('created_at', $month)
            ->count();

        $totalOrdersCount = $pendingCount + $shippingCount + $completedCount;

        $totalRevenue = Order::where('order_status', 'delivered')
            ->whereMonth('created_at', $month)
            ->sum('amount');

        $totalProductsSold = OrderProduct::whereHas('order', function ($query) use ($month) {
            $query->where('order_status', 'delivered')
                ->whereMonth('created_at', $month);
        })
            ->sum('qty');

        // Lấy tên tháng
        $monthName = Carbon::createFromFormat('m', $month)->format('F');

        // Trả về view cùng dữ liệu
        return view('admin.page.dashboard', [
            'pendingCount' => $pendingCount ?? 0,
            'shippingCount' => $shippingCount ?? 0,
            'completedCount' => $completedCount ?? 0,
            'totalOrdersCount' => $totalOrdersCount ?? 0,
            'totalRevenue' => $totalRevenue ?? 0,
            'totalProductsSold' => $totalProductsSold ?? 0,
            'month' => $month,
            'monthName' => $monthName
        ]);
    }

    public function orderStatistics(Request $request, $month)
    {
   
        $pendingCount = Order::where('order_status', 'pending')
            ->whereMonth('created_at', $month)
            ->count();

        $shippingCount = Order::where('order_status', 'shipped')
            ->whereMonth('created_at', $month)
            ->count();

        $completedCount = Order::where('order_status', 'delivered')
            ->whereMonth('created_at', $month)
            ->count();

        $totalOrdersCount = $pendingCount + $shippingCount + $completedCount;

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
}
