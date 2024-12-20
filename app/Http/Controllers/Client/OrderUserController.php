<?php

namespace App\Http\Controllers\Client;

use App\Events\ChangeStatusOrder;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Commune;
use App\Models\Coupon;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderReturn;
use App\Models\PointTransaction;
use App\Models\ProductVariant;
use App\Models\Province;
use App\Models\User;
use App\Models\UserCoupon;
use App\Notifications\ChangeStatusOrder as NotificationsChangeStatusOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class OrderUserController extends Controller
{
    public function returnOrder(Request $request)
    {
        // dd($request->all());
        $order = Order::query()->find($request->orderId);
        if ($order) {
            $order->order_status = 'return';
            $order->cause_cancel_order = NULL;
            $order->save();
            $returnOrder = new OrderReturn();
            if ($request->returnReason != 'san_pham_loi' && $request->returnReason != 'giao_sai_san_pham' && $request->returnReason != 'san_pham_khong_giong_quang_cao' && $request->returnReason != 'giao_hang_tre_hon_du_kien' && $request->returnReason != 'khong_con_nhu_cau') {
                $reasonOrder = $request->returnReason;
            } else {
                $reasonOrder = checkReason($request->returnReason);
            }

            $returnOrder->order_id = $order->id;
            $returnOrder->return_reason = $reasonOrder;
            $returnOrder->return_status = 'pending';
            $returnOrder->refund_amount = $order->amount;
            // Xử lý lưu video nếu có
            if ($request->hasFile('videoPath') && $request->file('videoPath')->isValid()) {
                // Đặt tên video duy nhất
                $videoName = uniqid() . '.' . $request->file('videoPath')->getClientOriginalExtension();

                // Lưu video vào thư mục storage/app/public/videos
                $videoPath = $request->file('videoPath')->storeAs('uploads/videos', $videoName, 'public');

                // Lưu đường dẫn video vào DB
                $returnOrder->video_path = $videoPath;
            }

            $returnOrder->save();

            $admins = User::query()
                ->where('role_id', '!=', 4)
                ->where('status', 1)
                ->get();
            if ($admins && !empty($admins)) {
                foreach ($admins as $user) {
                    event(new ChangeStatusOrder($user, $order));
                    $user->notify(new NotificationsChangeStatusOrder($order));
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

            $orders = $ordersQuery->paginate(5, ['*'], 'page', $page)->appends([
                'status' => $status,
                'from_date' => $fromDate,
                'to_date' => $toDate,
            ]);

            $updatedOrderHtml = view('client.page.dashboard.sections.order-list', compact('orders'))->render();


            return response()->json([
                'status' => 'success',
                'message' => 'Đã gửi yêu cầu trả hàng thành công',
                'updatedOrderHtml' => $updatedOrderHtml,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Đơn hàng không tồn tại',
        ]);
    }

    public function cancelOrder(Request $request)
    {
        $order = Order::query()->find($request->orderId);
        if (isset($order)) {
            if ($order->order_status == 'processed_and_ready_to_ship' || $order->order_status == 'dropped_off' || $order->order_status == 'shipped' || $order->order_status == 'delivered') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không thể hủy đơn hàng đơn hàng đã được xử lý',
                ]);
            }
            $order->order_status = 'canceled';
            if ($request->cancelReason != 'khong_muon_mua_nua' && $request->cancelReason != 'gia_re_hon_o_noi_khac' && $request->cancelReason != 'thay_doi_dia_chi_giao_hang' && $request->cancelReason != 'thay_doi_phuong_thuc_thanh_toan' && $request->cancelReason != 'thay_doi_ma_giam_gia') {
                $reasonCancelOrder = $request->cancelReason;
            } else {
                $reasonCancelOrder = checkReasonCancel($request->cancelReason);
            }
            $order->cause_cancel_order = $reasonCancelOrder;
            $point = json_decode($order->point_method, true);
            $user = User::query()->find(Auth::user()->id);
            $total = $order->amount;
            if ($point) {
                // Nếu có điểm đã sử dụng
                $usedPoint = $point['point_value'];

                // Chỉ hoàn lại điểm nếu đơn hàng đã thanh toán
                if ($order->payment_status == 1) {
                    $total += $usedPoint;
                    $user->point += $total;
                    $user->save();

                    // Ghi lại giao dịch hoàn điểm
                    PointTransaction::create([
                        'user_id' => $order->user_id,
                        'order_id' => $order->id,
                        'type' => 'refund',
                        'points' => $total,
                        'description' => "Hoàn điểm đơn hủy #$order->id",
                    ]);
                } else {
                    // Nếu đơn hàng chưa thanh toán, chỉ hoàn lại điểm đã sử dụng mà không cộng tiền
                    $user->point += $usedPoint;
                    $user->save();

                    PointTransaction::create([
                        'user_id' => $order->user_id,
                        'order_id' => $order->id,
                        'type' => 'refund',
                        'points' => $usedPoint,
                        'description' => "Hoàn điểm đơn hủy (chưa thanh toán) #$order->id",
                    ]);
                }
            } else if ($order->payment_status == 1) {
                // Nếu không có điểm và đơn hàng đã thanh toán thành công
                $user->point += $total;  // Cộng tiền vào điểm người dùng
                $user->save();

                PointTransaction::create([
                    'user_id' => $order->user_id,
                    'order_id' => $order->id,
                    'type' => 'refund',
                    'points' => $total,
                    'description' => "Hoàn điểm đơn hủy #$order->id",
                ]);
            }
            $order->save();


            if ($order->coupon_method != 'null') {
                $couponMethod = json_decode($order->coupon_method, true);
                $coupon = Coupon::query()->where('code', $couponMethod['coupon_code'])->first();
                if ($coupon && $coupon->is_publish == 0 && now()->between($coupon->start_date, $coupon->end_date)) {
                    $userCoupon = UserCoupon::query()
                        ->where('user_id', Auth::user()->id)
                        ->where('coupon_id', $coupon->id)
                        ->first();

                    if ($userCoupon && !empty($userCoupon)) {
                        $userCoupon->increment('qty');
                        $userCoupon->save();
                    } else {
                        UserCoupon::create([
                            'user_id' => Auth::user()->id,
                            'coupon_id' => $coupon->id,
                            'qty' => 1,
                        ]);
                    }
                }
            }
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
            $orders = $ordersQuery->paginate(5, ['*'], 'page', $page)->appends([
                'status' => $status,
                'from_date' => $fromDate,
                'to_date' => $toDate,
            ]);

            $updatedOrderHtml = view('client.page.dashboard.sections.order-list', compact('orders'))->render();


            return response()->json([
                'status' => 'success',
                'message' => 'Hủy đơn hàng thành công.',
                'updatedOrderHtml' => $updatedOrderHtml,
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Đơn hàng không tồn tại',
        ]);
    }

    public function cancelOrderReturn(Request $request)
    {
        $order = Order::query()->find($request->orderId);

        if (isset($order)) {
            if ($order->order_status != 'return') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Không thể hủy đơn hàng không ở trạng thái hoàn hàng',
                ]);
            }
            if ($order->orderReturn) {
                if ($order->orderReturn->return_status == 'approved' || $order->orderReturn->return_status == 'completed') {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Không thể hủy đơn hoàn, vui lòng tải lại trang web',
                    ]);
                }
            }

            $order->order_status = 'delivered';
            if (Storage::disk('public')->exists($order->orderReturn->video_path)) {
                Storage::disk('public')->delete($order->orderReturn->video_path);
            }
            $order->orderReturn->delete();
            $order->cause_cancel_order = NULL;
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

            $orders = $ordersQuery->paginate(5, ['*'], 'page', $page)->appends([
                'status' => $status,
                'from_date' => $fromDate,
                'to_date' => $toDate,
            ]);

            $updatedOrderHtml = view('client.page.dashboard.sections.order-list', compact('orders'))->render();

            return response()->json([
                'status' => 'success',
                'message' => 'Hủy hoàn hàng thành công',
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
        $order = Order::query()->find($request->orderId);

        if (isset($order)) {
            if ($order->order_status != 'shipped') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Bạn không thể xác nhận đã nhận',
                ]);
            }
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

            $orders = $ordersQuery->paginate(5, ['*'], 'page', $page)->appends([
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
        $order = Order::query()->with(['orderProducts'])->find($request->orderId);

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
                        $productPrice = checkDiscountVariant($productVariant) ? $productVariant->offer_price_variant : $productVariant->price_variant;
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
                    $productPrice = checkDiscount($product) ? $product->offer_price : $product->price;
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

    public function detailsOrder(Request $request)
    {
        $order = Order::query()->with('orderProducts')->find($request->orderId);
        // dd($order);

        if ($order) {
            $orderProducts = $order->orderProducts->map(function ($orderProduct) {
                $variants = json_decode($orderProduct->variants, true);
                if ($variants != null) {
                    $name_product = $orderProduct->product_name . ' ' . '(' . implode('-', $variants) . ')';
                } else {
                    $name_product = $orderProduct->product_name;
                }

                return [
                    'name_product' => $name_product,
                    'qty_product' => $orderProduct->qty,
                    'sub_price' => number_format($orderProduct->unit_price * $orderProduct->qty),
                    'price_product' => number_format($orderProduct->unit_price),
                ];
            });
            $coupon = json_decode($order->coupon_method, true);
            $order->address = json_decode($order->order_address, true);
            $point = json_decode($order->point_method, true);
            if ($point) {
                $order->point = number_format($point['point_value']);
            }

            $order->sub_total_order = number_format($order->sub_total);
            $order->total_order = number_format($order->amount);
            $order->cod_order = number_format($order->cod);
            $order->discount_coupon = $coupon != null ? number_format(getOrderDiscount($coupon, $order->sub_total)) : 0;
            $order->status_payment = $order->payment_status == 1 ? '(Đã thanh toán)' : '(Chưa thanh toán)';
            $addressName = [];
            $addressName[] = Commune::query()->where('id', $order->address['commune_id'])->pluck('title')->first();
            $addressName[] = District::query()->where('id', $order->address['district_id'])->pluck('title')->first();
            $addressName[] = Province::query()->where('id', $order->address['province_id'])->pluck('title')->first();

            $order->addresses = implode(', ', $addressName);
            return response()->json([
                'status' => 'success',
                'orderProducts' => $orderProducts,
                'order' => $order,
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Đơn hàng không tồn tại',
        ]);
    }
}
