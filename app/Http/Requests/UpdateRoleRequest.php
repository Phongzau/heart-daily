<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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
        // Lấy id của vai trò từ URI để loại trừ chính nó khỏi quy tắc unique
        $id = $this->route('roles');

        return [
            // Quy tắc: bắt buộc, tối đa 100 ký tự, và duy nhất trong bảng roles (ngoại trừ id hiện tại)
            'name' => ['required', 'max:100', 'unique:roles,name,' . $id],

            // Quy tắc cho mô tả: không bắt buộc, tối đa 255 ký tự
            'description' => ['nullable', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            // Tùy chỉnh thông báo lỗi cho trường 'name'
            'name.required' => 'Tên vai trò là bắt buộc.',  // Thông báo khi 'name' bị bỏ trống
            'name.max' => 'Tên vai trò không được vượt quá 100 ký tự.',  // Thông báo khi 'name' quá dài
            'name.unique' => 'Tên vai trò đã tồn tại.',  // Thông báo khi 'name' đã tồn tại trong bảng roles

            // Tùy chỉnh thông báo lỗi cho trường 'description'
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',  // Thông báo khi mô tả quá dài
        ];
    }
}
