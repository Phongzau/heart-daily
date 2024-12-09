<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponDataTable;
use App\Events\CouponCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\User;
use App\Models\UserCoupon;
use App\Notifications\CouponCreatedNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CouponDataTable $dataTable)
    {
        return $dataTable->render('admin.page.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.page.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCouponRequest $request)
    {
        // dd($request->all());
        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount = $request->discount;
        $coupon->max_discount_percent = $request->max_discount_percent;
        $coupon->min_order_value = $request->min_order_value;
        $coupon->total_used = 0;
        $coupon->is_publish = $request->is_publish;
        $coupon->status = $request->status;
        $coupon->save();

        if ($coupon->is_publish == 1) {
            $users = User::query()->get();
            foreach ($users as $user) {
                event(new CouponCreated($coupon, $user));
                $user->notify(new CouponCreatedNotification($coupon));
            }
        }

        toastr('Thêm Coupon thành công', 'success');
        return redirect()->route('admin.coupons.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $coupon = Coupon::query()->findOrFail($id);
        return view('admin.page.coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCouponRequest $request, string $id)
    {
        $coupon = Coupon::query()->findOrFail($id);
        $statusCoupon = $coupon->is_publish;
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount = $request->discount;
        $coupon->max_discount_percent = $request->max_discount_percent;
        $coupon->min_order_value = $request->min_order_value;
        $coupon->is_publish = $request->is_publish;
        $coupon->status = $request->status;
        $coupon->save();

        if ($statusCoupon == 0) {
            $users = User::query()->get();
            foreach ($users as $user) {
                event(new CouponCreated($coupon, $user));
                $user->notify(new CouponCreatedNotification($coupon));
            }
        }

        toastr('Cập nhật thành công', 'success');
        return redirect()->route('admin.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function add()
    {
        $coupons = Coupon::query()
            ->where(['status' => 1, 'is_publish' => 0])
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>', Carbon::now())
            ->get();
        return view('admin.page.coupons.add-coupon', compact('coupons'));
    }

    public function addCoupon(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'customer_object' => 'required|string',
            'coupon_id' => 'required|exists:coupons,id',
        ]);

        // Lấy dữ liệu từ form
        $customerObject = $request->input('customer_object');
        $couponId = $request->input('coupon_id');
        $coupon = Coupon::query()->findOrFail($couponId);
        // Tùy theo đối tượng khách hàng, thêm logic xử lý
        switch ($customerObject) {
            case 'sinh_nhat':
                $customers = User::whereMonth('birth_date', now()->month)->get();
                break;

            case 'khach_hang_moi':
                $customers = User::where('created_at', '>=', now()->subMonth())->get();
                break;

            case 'khach_hang_mua_nhieu':
                // Khách hàng có hơn 10 đơn hàng đã giao hàng thành công
                $customers = User::whereHas('orders', function ($query) {
                    $query->where('order_status', 'delivered');
                })->withCount(['orders' => function ($query) {
                    $query->where('order_status', 'delivered');
                }])->having(
                    'orders_count',
                    '>',
                    10
                )->get();
                break;

            case 'khach_hang_mua_it':
                // Khách hàng có từ 3 đơn hàng trở xuống đã giao hàng thành công
                $customers = User::whereHas('orders', function ($query) {
                    $query->where('order_status', 'delivered');
                })->withCount(['orders' => function ($query) {
                    $query->where('order_status', 'delivered');
                }])->having('orders_count', '<=', 3)->get();
                break;

            case 'khach_hang_trung_thanh':
                $customers = User::where('created_at', '<', now()->subYear())->get();
                break;

            default:
                return redirect()->back()->withErrors('Đối tượng khách hàng không hợp lệ!');
        }

        if ($customers && !empty($customers)) {
            // Gán mã giảm giá cho danh sách khách hàng
            foreach ($customers as $customer) {
                $couponExiests = UserCoupon::query()
                    ->where('user_id', $customer->id)
                    ->where('coupon_id', $coupon->id)
                    ->first();
                if ($couponExiests) {
                    $couponExiests->increment('qty');
                    $couponExiests->save();
                } else {
                    UserCoupon::create([
                        'user_id' => $customer->id,
                        'coupon_id' => $couponId,
                        'qty' => 1,
                    ]);
                }
            }

            foreach ($customers as $user) {
                event(new CouponCreated($coupon, $user));
                $user->notify(new CouponCreatedNotification($coupon));
            }
        } else {
            toastr('Không có khách hàng nào phù hợp để áp dụng mã giảm giá', 'error');
            return redirect()->back();
        }

        toastr('Mã giảm giá đã được áp dụng cho các khách hàng được chọn!', 'success');
        return redirect()->back();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $coupon = Coupon::query()->findOrFail($id);
        $coupon->delete();

        return response([
            'status' => 'success',
            'message' => 'Xóa thành công !',
        ]);
    }

    public function changeStatus(Request $request)
    {
        $coupon = Coupon::query()->findOrFail($request->id);
        $coupon->status = $request->status == 'true' ? 1 : 0;
        $coupon->save();

        return response([
            'message' => 'Cập nhật trạng thái thành công !',
        ]);
    }
}
