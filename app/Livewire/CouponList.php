<?php

namespace App\Livewire;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CouponList extends Component
{
    public $listCoupon;

    public function mount()
    {
        if (Auth::check()) {
            $this->listCoupon = Coupon::query()
                ->where(['status' => 1, 'is_publish' => 1])
                ->whereDate('start_date', '<=', Carbon::now())
                ->whereDate('end_date', '>', Carbon::now())
                ->whereRaw(
                    '(
                SELECT COUNT(*)
                FROM orders
                WHERE JSON_CONTAINS(orders.coupon_method, JSON_OBJECT("coupon_code", coupons.code))
                AND orders.order_status != "canceled"
                ) < max_use'
                )
                ->orWhereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('user_coupons')
                        ->whereColumn('user_coupons.coupon_id', 'coupons.id')
                        ->where('user_coupons.user_id', Auth::user()->id)
                        ->whereDate('coupons.end_date', '>', Carbon::now())
                        ->whereDate('coupons.start_date', '<=', Carbon::now());
                })
                ->get();
        }
    }

    protected $listeners = ['refreshCouponList'];

    public function refreshCouponList()
    {
        $this->listCoupon = Coupon::query()
            ->where(['status' => 1, 'is_publish' => 1])
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>', Carbon::now())
            ->whereRaw(
                '(
                SELECT COUNT(*)
                FROM orders
                WHERE JSON_CONTAINS(orders.coupon_method, JSON_OBJECT("coupon_code", coupons.code))
                AND orders.order_status != "canceled"
                ) < max_use'
            )
            ->orWhereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('user_coupons')
                    ->whereColumn('user_coupons.coupon_id', 'coupons.id')
                    ->where('user_coupons.user_id', Auth::user()->id)
                    ->whereDate('coupons.end_date', '>', Carbon::now())
                    ->whereDate('coupons.start_date', '<=', Carbon::now());
            })
            ->get();
    }

    public function render()
    {
        return view('livewire.coupon-list', [
            'listCoupon' => $this->listCoupon,
        ]);
    }
}
