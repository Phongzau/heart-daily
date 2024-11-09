<?php

namespace App\Livewire;

use App\Models\Coupon;
use Carbon\Carbon;
use Livewire\Component;

class CouponList extends Component
{
    public $listCoupon;

    public function mount()
    {
        $this->listCoupon = Coupon::query()
            ->where('status', 1)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>', Carbon::now())
            ->get();
    }

    protected $listeners = ['refreshCouponList'];

    public function refreshCouponList()
    {
        $this->listCoupon = Coupon::query()
            ->where('status', 1)
            ->whereDate('start_date', '<=', Carbon::now())
            ->whereDate('end_date', '>', Carbon::now())
            ->get(); // Lấy tất cả thông báo của người dùng hiện tại
    }

    public function render()
    {
        return view('livewire.coupon-list', [
            'listCoupon' => $this->listCoupon,
        ]);
    }
}
