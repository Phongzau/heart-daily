<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TransactionDataTable;
use App\DataTables\OrderDataTable;
use App\DataTables\ReturnOrderDataTable;
use App\Events\ChangeStatusOrder;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\PointTransaction;
use App\Models\ProductVariant;
use App\Notifications\ChangeStatusOrder as NotificationsChangeStatusOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index(OrderDataTable $dataTable)
    {
        $this->autoDeleteOrders();
        return $dataTable->render('admin.page.order.index');
    }
    public function autoDeleteOrders()
    {
        $now = Carbon::now();

        $canceledOrders = Order::whereIn('order_status', ['canceled', 'return'])
            ->where('created_at', '<=', $now->subYears(1))
            ->get();

        foreach ($canceledOrders as $order) {
            $order->orderProducts()->delete();
            $order->transaction()->delete();
            $order->delete();
        }

        $deliveredOrders = Order::where('order_status', 'delivered')
            ->where('created_at', '<=', $now->subYears(3))
            ->get();

        foreach ($deliveredOrders as $order) {
            $order->orderProducts()->delete();
            $order->transaction()->delete();
            $order->delete();
        }
    }

    public function orderReturn(ReturnOrderDataTable $dataTable)
    {
        return $dataTable->render('admin.page.order.return-order');
    }

    public function transaction(TransactionDataTable $dataTable)
    {
        return $dataTable->render('admin.page.order.transaction');
    }

    public function show(string $id)
    {
        $order = Order::query()->with(['user'])->findOrFail($id);
        return view('admin.page.order.show', compact(['order']));
    }

    public function destroy(string $id)
    {
        $order = Order::query()->findOrFail($id);
        // Kiểm tra trạng thái đơn hàng
        if ($order->order_status == 'canceled' || $order->order_status == 'return') {

            $createdAt = Carbon::parse($order->created_at);
            $now = Carbon::now();
            $diffInMonths = $createdAt->diffInMonths($now);

            if ($diffInMonths < 6) {
                return response([
                    'status' => 'error',
                    'message' => 'Không thể xóa đơn hàng đã hủy hoặc trả hàng chưa đủ 6 tháng!',
                ]);
            }
        } elseif ($order->order_status == 'delivered') {
            $createdAt = Carbon::parse($order->created_at);
            $now = Carbon::now();
            $diffInYears = $createdAt->diffInYears($now);

            if ($diffInYears < 3) {
                return response([
                    'status' => 'error',
                    'message' => 'Không thể xóa đơn hàng chưa đủ 3 năm!',
                ]);
            }
        }

        // delete order products
        $order->orderProducts()->delete();
        // delete transaction
        $order->transaction()->delete();
        $order->delete();

        return response([
            'status' => 'success',
            'message' => 'Đã xóa mềm đơn hàng thành công!',
        ]);
    }
    public function deletedOrders()
    {
        $deletedOrders = Order::onlyTrashed()->with('orderProducts', 'transaction')->get();

        return view('admin.page.order.deleted', [
            'orders' => $deletedOrders,
        ]);
    }
    public function restore(string $id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);

        $order->orderProducts()->restore();
        $order->transaction()->restore();
        $order->restore();

        toastr('Khôi phục đơn hàng thành công!', 'success');
        return redirect()->route('admin.orders.index');
    }
    public function forceDelete(string $id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);

        $order->orderProducts()->forceDelete();
        $order->transaction()->forceDelete();
        $order->forceDelete();

        toastr('Xóa vĩnh viễn đơn hàng thành công!', 'success');
        return redirect()->route('admin.orders.deleted');
    }



    public function changeOrderStatus(Request $request)
    {
        $order = Order::query()->findOrFail($request->id);

        // Trạng thái hiện tại của đơn hàng
        $currentStatus = $order->order_status;

        $newStatus = $request->input('status');

        // Danh sách trạng thái hợp lệ
        $validTransitions = [
            'pending' => ['processed_and_ready_to_ship'],
            'processed_and_ready_to_ship' => ['dropped_off'],
            'dropped_off' => ['shipped'],
            'shipped' => ['delivered', 'return'],
            'delivered' => [],
            'return' => [],
            'canceled' => [],
        ];

        // Kiểm tra trạng thái mới có hợp lệ không
        if (
            !array_key_exists($currentStatus, $validTransitions) ||
            !in_array($newStatus, $validTransitions[$currentStatus])
        ) {
            return response()->json([
                'status' => 'error',
                'message' => 'Chuyển trạng thái không thành công. Vui lòng reload lại trang.',
            ]);
        }

        $order->order_status = $request->status;
        $order->save();
        $user = $order->user;
        event(new ChangeStatusOrder($order->user, $order));
        $user->notify(new NotificationsChangeStatusOrder($order));
        return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật trạng thái thành công',
            'current_status' => $request->status,
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
        // $request->validate([
        //     'id' => ['required', 'integer', 'exists:order_returns,id'],
        // ]);

        // $returnOrder = OrderReturn::query()->findOrFail($request->id);

        // if ($returnOrder->order->order_status !== 'return') {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Không thể chuyển trạng thái, đơn hàng này không trong trạng thái hoàn hàng',
        //     ]);
        // }

        // // Logic hủy bỏ đơn hoàn
        // if ($request->value === 'canceled') {
        //     if ($returnOrder->return_status === 'completed') {
        //         return response()->json([
        //             'status' => 'error',
        //             'message' => 'Không thể hủy bỏ đơn hàng đã thành công',
        //         ]);
        //     }
        //     if ($returnOrder->order) {
        //         $returnOrder->order->order_status = 'delivered';
        //         $returnOrder->order->save();
        //     }
        //     // Xóa đơn hoàn hàng
        //     $returnOrder->delete();

        //     return response()->json([
        //         'status' => 'success',
        //         'message' => 'Đơn hoàn hàng đã được hủy bỏ thành công.',
        //     ]);
        // }

        $request->validate([
            'id' => ['required', 'integer', 'exists:order_returns,id'],
        ]);

        $returnOrder = OrderReturn::query()->findOrFail($request->id);

        if ($returnOrder->order->order_status !== 'return') {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể chuyển trạng thái, đơn hàng này không trong trạng thái hoàn hàng',
            ]);
        }

        $currentStatus = $returnOrder->return_status;
        $newStatus = $request->value;

        // Danh sách trạng thái hợp lệ
        $validTransitions = [
            'pending' => ['approved', 'canceled'],
            'approved' => ['completed', 'canceled', 'rejected'],
            'rejected' => [],
            'completed' => [],
            'canceled' => [],
        ];

        // Kiểm tra trạng thái mới có hợp lệ không
        if (!isset($validTransitions[$currentStatus]) || !in_array($newStatus, $validTransitions[$currentStatus])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không thể chuyển trạng thái từ "' . $currentStatus . '" sang "' . $newStatus . '".',
                'current_status' => $currentStatus,
            ]);
        }

        // Logic hủy bỏ đơn hoàn
        if ($newStatus === 'canceled') {
            if (
                $currentStatus === 'completed'
            ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không thể hủy bỏ đơn hàng đã thành công',
                ]);
            }
            if ($returnOrder->order) {
                $returnOrder->order->order_status = 'delivered';
                $returnOrder->order->save();
            }
            // Xóa đơn hoàn hàng
            $returnOrder->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Đơn hoàn hàng đã được hủy bỏ thành công.',
            ]);
        }



        DB::beginTransaction();

        try {
            // $returnOrder->return_status = $request->value;
            $returnOrder->return_status = $newStatus;

            if ($newStatus == 'completed') {
                foreach ($returnOrder->order->orderProducts as $orderProduct) {
                    $product = $orderProduct->product;
                    if ($product) {
                        if ($product->type_product === 'product_simple') {
                            $product->qty += $orderProduct->qty;
                            $product->save();
                        } else if ($product->type_product === 'product_variant') {
                            $variants = json_decode($orderProduct->variants, true);
                            if (is_array($variants)) {
                                $attributeIdArray = Attribute::query()
                                    ->whereIn('slug', array_map(fn($v) => Str::slug(strtolower($v)), $variants))
                                    ->pluck('id')
                                    ->toArray();

                                if (count($attributeIdArray) === count($variants)) {
                                    $productVariant = ProductVariant::where('product_id', $orderProduct->product_id)
                                        ->whereJsonContains('id_variant', $attributeIdArray)
                                        ->first();

                                    if ($productVariant) {
                                        $productVariant->qty += $orderProduct->qty;
                                        $productVariant->save();
                                    } else {
                                        throw new \Exception('Không tìm thấy biến thể sản phẩm.');
                                    }
                                }
                            }
                        }
                    }
                }
                // Hoàn tiền lại cho user
                $amount = $returnOrder->order->amount;
                if ($returnOrder->order->user) {
                    $point = json_decode($returnOrder->order->point_method, true);
                    if ($point && isset($point['point_value'])) {
                        $usedPoint = $point['point_value'];
                        $amount += $usedPoint;
                        $order = $returnOrder->order;
                        PointTransaction::create([
                            'user_id' => $order->user_id,
                            'order_id' => $order->id,
                            'type' => 'refund',
                            'points' => $amount,
                            'description' => "Hoàn điểm đơn hoàn #$order->id",
                        ]);
                    } else {
                        $order = $returnOrder->order;
                        PointTransaction::create([
                            'user_id' => $order->user_id,
                            'order_id' => $order->id,
                            'type' => 'refund',
                            'points' => $amount,
                            'description' => "Hoàn điểm đơn hoàn #$order->id",
                        ]);
                    }

                    // Cộng điểm lại cho user
                    $returnOrder->order->user->point += $amount - getCartCod();
                    $returnOrder->order->user->save();
                }
            }

            $returnOrder->save();
            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Cập nhật trạng thái thành công',
            ]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Đã xảy ra lỗi khi cập nhật trạng thái:' . $th->getMessage(),
            ]);
        }
    }



    // if ($returnOrder->return_status == 'completed') {
    //     foreach ($returnOrder->order->orderProducts as $orderProduct) {
    //         $product = $orderProduct->product;
    //         if (isset($product)) {
    //             if ($orderProduct->product->type_product === 'product_simple') {
    //                 $product->qty += $orderProduct->qty;
    //                 $product->save();
    //             } else if ($orderProduct->product->type_product === 'product_variant') {
    //                 $variants = json_decode($orderProduct->variants, true);
    //                 $attributeIdArray = [];
    //                 foreach ($variants as $variant) {
    //                     $nameVariant = strtolower($variant);
    //                     $slugVariant = Str::slug($nameVariant);
    //                     $attributeId = Attribute::query()->where('slug', $slugVariant)->pluck('id')->first();
    //                     if ($attributeId) {
    //                         $attributeIdArray[] = $attributeId;
    //                     }
    //                 }
    //                 if (count($attributeIdArray) === count($variants)) {
    //                     $productVariant = ProductVariant::where('product_id', $orderProduct->product_id)
    //                         ->whereJsonContains('id_variant', $attributeIdArray)
    //                         ->first();
    //                     if ($productVariant) {
    //                         $productVariant->qty += $orderProduct->qty;
    //                         $productVariant->save();
    //                     }
    //                 }
    //             }
    //         }
    //     }
    //     $returnOrder->order->user->point += $returnOrder->order->amount;
    // }
    // $returnOrder->save();

    // return response()->json([
    //     'status' => 'success',
    //     'message' => 'Cập nhật trạng thái thành công',
    // ]);
}
