<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderUserController extends Controller
{
    public function cancelOrder(Request $request)
    {
        $order = Order::query()->findOrFail($request->orderId);

        if (isset($order)) {
            $order->order_status = 'canceled';
            $order->save();

            // Lấy các tham số lọc
            $status = $request->input('status');
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $page = $request->input('page', 1); // Lấy trang hiện tại

            // Tạo truy vấn với các tham số lọc
            $ordersQuery = Order::query()
                ->with(['orderProducts'])
                ->where('user_id', Auth::user()->id)
                ->when($status, function ($query) use ($status) {
                    return $query->where('order_status', $status);
                })
                ->when($fromDate, function ($query) use ($fromDate) {
                    return $query->whereDate('created_at', '>=', $fromDate);
                })
                ->when($toDate, function ($query) use ($toDate) {
                    return $query->whereDate('created_at', '<=', $toDate);
                })
                ->orderByDesc('created_at');

            $orders = $ordersQuery->paginate(1, ['*'], 'page', $page)->appends([
                'status' => $status,
                'from_date' => $fromDate,
                'to_date' => $toDate,
            ]);

            $updatedOrderHtml = view('client.page.dashboard.sections.order-list', compact('orders'))->render();


            return response()->json([
                'status' => 'success',
                'message' => 'Hủy đơn hàng thành công',
                'updatedOrderHtml' => $updatedOrderHtml,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Đơn hàng không tồn tại',
        ]);
    }

    public function confirmOrder(Request $request)
    {
        $order = Order::query()->findOrFail($request->orderId);

        if (isset($order)) {
            $order->order_status = 'delivered';
            $order->save();

            // Lấy các tham số lọc
            $status = $request->input('status');
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            $page = $request->input('page', 1); // Lấy trang hiện tại

            // Tạo truy vấn với các tham số lọc
            $ordersQuery = Order::query()
                ->with(['orderProducts'])
                ->where('user_id', Auth::user()->id)
                ->when($status, function ($query) use ($status) {
                    return $query->where('order_status', $status);
                })
                ->when($fromDate, function ($query) use ($fromDate) {
                    return $query->whereDate('created_at', '>=', $fromDate);
                })
                ->when($toDate, function ($query) use ($toDate) {
                    return $query->whereDate('created_at', '<=', $toDate);
                })
                ->orderByDesc('created_at');

            $orders = $ordersQuery->paginate(1, ['*'], 'page', $page)->appends([
                'status' => $status,
                'from_date' => $fromDate,
                'to_date' => $toDate,
            ]);

            $updatedOrderHtml = view('client.page.dashboard.sections.order-list', compact('orders'))->render();

            return response()->json([
                'status' => 'success',
                'message' => 'Xác nhận đã nhận hàng thành công',
                'updatedOrderHtml' => $updatedOrderHtml,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Đơn hàng không tồn tại',
        ]);
    }
}
