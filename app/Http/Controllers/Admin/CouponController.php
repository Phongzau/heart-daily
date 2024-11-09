<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CouponDataTable;
use App\Events\CouponCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\User;
use App\Notifications\CouponCreatedNotification;
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
        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount = $request->discount;
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
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->quantity = $request->quantity;
        $coupon->max_use = $request->max_use;
        $coupon->start_date = $request->start_date;
        $coupon->end_date = $request->end_date;
        $coupon->discount_type = $request->discount_type;
        $coupon->discount = $request->discount;
        $coupon->min_order_value = $request->min_order_value;
        $coupon->status = $request->status;
        $coupon->save();

        toastr('Cập nhật thành công', 'success');
        return redirect()->route('admin.coupons.index');
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
