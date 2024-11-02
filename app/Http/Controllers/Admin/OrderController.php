<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.page.order.index');
    }

    public function show(string $id)
    {
        $order = Order::query()->with(['user'])->findOrFail($id);
        return view('admin.page.order.show', compact(['order']));
    }

    public function destroy(string $id)
    {
        $order = Order::query()->findOrFail($id);

        // delete order products
        $order->orderProducts()->delete();
        // delete transaction
        $order->transaction()->delete();
        $order->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công !',
        ]);
    }

    public function changeOrderStatus(Request $request)
    {
        $order = Order::query()->findOrFail($request->id);
        $order->order_status = $request->status;
        $order->save();

        return response([
            'status' => 'success',
            'message' => 'Cập nhật trạng thái thành công'
        ]);
    }

    public function changePaymentStatus(Request $request)
    {
        $paymentStatus = Order::query()->findOrFail($request->id);
        $paymentStatus->payment_status = $request->status;
        $paymentStatus->save();

        return response([
            'status' => 'success',
            'message' => 'Cập nhật trạng thái thành công'
        ]);
    }
}