<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            // Quy tắc: bắt buộc, tối đa 100 ký tự, và không được trùng tên khác trong bảng roles
            'name' => ['required', 'max:100', 'unique:roles,name'],
            // Quy tắc cho mô tả: không bắt buộc, tối đa 255 ký tự
            'description' => ['nullable', 'max:255']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên vai trò là bắt buộc.',  // Thông báo lỗi khi không nhập tên
            'name.max' => 'Tên vai trò không được vượt quá 100 ký tự.',  // Lỗi khi tên dài hơn 100 ký tự
            'name.unique' => 'Tên vai trò đã tồn tại.',  // Lỗi khi tên đã tồn tại trong cơ sở dữ liệu
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',  // Lỗi khi mô tả dài hơn 255 ký tự
        ];
    }
}
