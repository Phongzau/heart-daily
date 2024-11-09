<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
    }

    /**
     * Custom error messages for validation.
     */
    public function messages(): array
    {
        return [
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
            'status.required' => 'Vui lòng chọn trạng thái mã giảm giá.',
            'is_publish.required' => 'Is_Publish không được bỏ trống',
        ];
    }
}
