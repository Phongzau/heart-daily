<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderUserController extends Controller
{
    public function cancelOrder(Request $request)
    {
        $order = Order::query()->findOrFail($request->orderId);

        if (isset($order)) {
            $order->order_status = 'canceled';
            $order->save();
            if (isset($order->transaction)) {
                $order->transaction->delete();
            }
            foreach ($order->orderProducts as $orderProduct) {
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

            $orders = $ordersQuery->paginate(6, ['*'], 'page', $page)->appends([
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
            $order->payment_status = 1;
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

            $orders = $ordersQuery->paginate(6, ['*'], 'page', $page)->appends([
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

    public function reOrder(Request $request)
    {
        $order = Order::query()->with(['orderProducts'])->findOrFail($request->orderId);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Đơn hàng không tồn tại',
            ]);
        }
        // Hủy session giỏ hàng hiện tại
        session()->forget('cart');

        $cart = session()->get('cart', []);

        foreach ($order->orderProducts as $orderProduct) {
            $product = $orderProduct->product;
            $productPrice = checkDiscount($product) ? $product->offer_price : $product->price;
            if (isset($product) && !empty($product)) {
                if ($product->type_product === 'product_variant') {
                    // Lấy ra biến thể
                    $variants = json_decode($orderProduct->variants, true);
                    $attributeIdArray = [];
                    foreach ($variants as $variant) {
                        $nameVariant = strtolower($variant);
                        $slugVariant = Str::slug($nameVariant);
                        $attributeId = Attribute::query()->where('slug', $slugVariant)->pluck('id')->first();
                        $attributeIdArray[] = $attributeId;
                    }
                    $productVariant = ProductVariant::where('product_id', $product->id)
                        ->whereJsonContains('id_variant', $attributeIdArray)
                        ->first();
                    if ($productVariant && $productVariant->qty > 0) {
                        $newQty = min($productVariant->qty, $orderProduct->qty);

                        // Tạo cartKey duy nhất cho biến thể
                        $cartKey = $product->id . '_' . implode('_', $attributeIdArray);

                        $cart[$cartKey] = [
                            'product_id' => $product->id,
                            'name' => $product->name,
                            'qty' => $newQty,
                            'price' => $productPrice,
                            'options' => [
                                'variants' => $variants,
                                'image' => $product->image,
                                'slug' => $product->slug,
                            ],
                        ];
                    } else {
                        continue;
                    }
                } else if ($product->type_product === 'product_simple') {
                    // Xử lý sản phẩm đơn giản
                    $cartKey = $product->id;
                    if ($product->qty > 0) {
                        $newQty = min($product->qty, $orderProduct->qty);

                        $cart[$cartKey] = [
                            'product_id' => $product->id,
                            'name' => $product->name,
                            'qty' => $newQty,
                            'price' => $productPrice,
                            'options' => [
                                'image' => $product->image,
                                'slug' => $product->slug,
                            ],
                        ];
                    } else {
                        continue; // Bỏ qua nếu hết hàng
                    }
                }
            } else {
                continue;
            }
        }
        // Lưu giỏ hàng vào session
        session()->put('cart', $cart);
        $cartEmpty = empty($cart);
        if ($cartEmpty) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm hiện tại đã hết hàng',
            ]);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Đã thêm lại các sản phẩm còn hàng vào giỏ hàng',
                'url' => '/cart',
            ]);
        }
    }
}
