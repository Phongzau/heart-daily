<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrderDataTable;
use App\DataTables\ReturnOrderDataTable;
use App\Events\ChangeStatusOrder;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\ProductVariant;
use App\Notifications\ChangeStatusOrder as NotificationsChangeStatusOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable)
    {
        return $dataTable->render('admin.page.order.index');
    }

    public function orderReturn(ReturnOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.page.order.return-order');
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
        $user = $order->user;
        event(new ChangeStatusOrder($order->user, $order));
        $user->notify(new NotificationsChangeStatusOrder($order));
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

    public function changeApproveStatus(Request $request)
    {
        $returnOrder = OrderReturn::query()->findOrFail($request->id);
        if ($returnOrder->order->order_status == 'return') {
            $returnOrder->return_status = $request->value;
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể chuyển trạng thái, đơn hàng này không trong trạng thái hoàn hàng',
            ]);
        }

        if ($returnOrder->return_status == 'completed') {
            foreach ($returnOrder->order->orderProducts as $orderProduct) {
                $product = $orderProduct->product;
            if (isset($product)) {
                    if ($orderProduct->product->type_product === 'product_simple') {
                        $product->qty += $orderProduct->qty;
                        $product->save();
                    } else if ($orderProduct->product->type_product === 'product_variant') {
                        $variants = json_decode($orderProduct->variants, true);
                        $attributeIdArray = [];
                        foreach ($variants as $variant) {
                            $nameVariant = strtolower($variant);
                            $slugVariant = Str::slug($nameVariant);
                            $attributeId = Attribute::query()->where('slug', $slugVariant)->pluck('id')->first();
                            if ($attributeId) {
                                $attributeIdArray[] = $attributeId;
                            }
                        }
                        if (count($attributeIdArray) === count($variants)) {
                            $productVariant = ProductVariant::where('product_id', $orderProduct->product_id)
                                ->whereJsonContains('id_variant', $attributeIdArray)
                                ->first();
                            if ($productVariant) {
                                $productVariant->qty += $orderProduct->qty;
                                $productVariant->save();
                            }
                        }
                    }
                }
            }
        }
        $returnOrder->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật trạng thái thành công',
        ]);
    }
}
