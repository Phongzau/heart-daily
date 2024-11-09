<?php

namespace App\Livewire;

use App\Events\CouponCreated;
use App\Models\Coupon;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class CouponCreate extends Component
{
    public $name, $code, $quantity, $max_use, $start_date, $end_date, $discount_type, $discount, $status = 1, $min_order_value = 0, $is_publish;

    protected $rules = [
        'name' => ['required', 'max:255'],
        'code' => ['required', 'unique:coupons,code'],
        'quantity' => ['required', 'integer', 'min:1'],
        'max_use' => ['required', 'integer', 'min:1'],
        'start_date' => ['required', 'date'],
        'end_date' => ['required', 'date', 'after:start_date'],
        'discount_type' => ['required'],
        'discount' => ['required', 'integer', 'min:1'],
        'min_order_value' => ['required', 'numeric', 'min:0'],
        'is_publish' => ['required'],
        'status' => ['required'],
    ];

    protected $message = [
        'name.required' => 'Tên mã giảm giá là bắt buộc.',
        'name.max' => 'Tên mã giảm giá không được vượt quá 255 ký tự.',
        'code.required' => 'Mã giảm giá là bắt buộc.',
        'code.unique' => 'Mã giảm giá này đã tồn tại.',
        'quantity.required' => 'Vui lòng nhập số lượng mã.',
        'quantity.integer' => 'Số lượng mã phải là một số nguyên.',
        'quantity.min' => 'Số lượng mã phải lớn hơn hoặc bằng 1.',
        'max_use.required' => 'Vui lòng nhập số lần sử dụng tối đa.',
        'max_use.integer' => 'Số lần sử dụng phải là một số nguyên.',
        'max_use.min' => 'Số lần sử dụng tối đa phải lớn hơn hoặc bằng 1.',
        'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
        'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
        'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
        'end_date.date' => 'Ngày kết thúc không hợp lệ.',
        'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        'discount_type.required' => 'Vui lòng chọn loại giảm giá.',
        'discount.required' => 'Vui lòng nhập giá trị giảm.',
        'discount.integer' => 'Giá trị giảm phải là số nguyên.',
        'discount.min' => 'Giá trị giảm phải lớn hơn hoặc bằng 1.',
        'min_order_value.required' => 'Vui lòng nhập giá trị đơn hàng tối thiểu.',
        'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là một số.',
        'min_order_value.min' => 'Giá trị đơn hàng tối thiểu không được nhỏ hơn 0.',
        'is_publish.required' => 'Is_Publish không được bỏ trống',
        'status.required' => 'Vui lòng chọn trạng thái mã giảm giá.',
    ];

    public function storeCoupon()
    {
        try {
            // Kiểm tra tính hợp lệ của dữ liệu
            $this->validate([
                'name' => ['required', 'max:255'],
                'code' => ['required', 'unique:coupons,code'],
                'quantity' => ['required', 'integer', 'min:1'],
                'max_use' => ['required', 'integer', 'min:1'],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after:start_date'],
                'discount_type' => ['required'],
                'discount' => ['required', 'integer', 'min:1'],
                'min_order_value' => ['required', 'numeric', 'min:0'],
                'status' => ['required'],
                'is_publish' => ['required'],
            ], [
                'name.required' => 'Tên mã giảm giá là bắt buộc.',
                'name.max' => 'Tên mã giảm giá không được vượt quá 255 ký tự.',
                'code.required' => 'Mã giảm giá là bắt buộc.',
                'code.unique' => 'Mã giảm giá này đã tồn tại.',
                'quantity.required' => 'Vui lòng nhập số lượng mã.',
                'quantity.integer' => 'Số lượng mã phải là một số nguyên.',
                'quantity.min' => 'Số lượng mã phải lớn hơn hoặc bằng 1.',
                'max_use.required' => 'Vui lòng nhập số lần sử dụng tối đa.',
                'max_use.integer' => 'Số lần sử dụng phải là một số nguyên.',
                'max_use.min' => 'Số lần sử dụng tối đa phải lớn hơn hoặc bằng 1.',
                'start_date.required' => 'Vui lòng chọn ngày bắt đầu.',
                'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
                'end_date.required' => 'Vui lòng chọn ngày kết thúc.',
                'end_date.date' => 'Ngày kết thúc không hợp lệ.',
                'end_date.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
                'discount_type.required' => 'Vui lòng chọn loại giảm giá.',
                'discount.required' => 'Vui lòng nhập giá trị giảm.',
                'discount.integer' => 'Giá trị giảm phải là số nguyên.',
                'discount.min' => 'Giá trị giảm phải lớn hơn hoặc bằng 1.',
                'min_order_value.required' => 'Vui lòng nhập giá trị đơn hàng tối thiểu.',
                'min_order_value.numeric' => 'Giá trị đơn hàng tối thiểu phải là một số.',
                'min_order_value.min' => 'Giá trị đơn hàng tối thiểu không được nhỏ hơn 0.',
                'is_publish.required' => 'Is_Publish không được bỏ trống',
                'status.required' => 'Vui lòng chọn trạng thái mã giảm giá.',
            ]);

            $coupon = new Coupon();
            $coupon->name = $this->name;
            $coupon->code = $this->code;
            $coupon->quantity = $this->quantity;
            $coupon->max_use = $this->max_use;
            $coupon->start_date = $this->start_date;
            $coupon->end_date = $this->end_date;
            $coupon->discount_type = $this->discount_type;
            $coupon->discount = $this->discount;
            $coupon->min_order_value = $this->min_order_value;
            $coupon->total_used = 0;
            $coupon->is_publish = $this->is_publish;
            $coupon->status = $this->status;
            $coupon->save();
            event(new CouponCreated($coupon));
            toastr('Thêm Coupon thành công', 'success');
            return redirect()->route('admin.coupons.index');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Lấy danh sách lỗi
            $errors = $e->errors();
            // Nếu có lỗi, phát sự kiện để hiển thị toastr error
            $this->dispatch('showToastrErrors', $errors);

            // Ngoài ra, bạn có thể trả lại lỗi để hiển thị nếu cần
            throw $e;
        }
    }

    public function render()
    {
        return view('livewire.coupon-create');
    }
}
