<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
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
        $id = $this->route('brands');
        return [
            'name' => ['required', 'max:100', 'unique:brands,name,'. $id],
            'image' => ['nullable', 'max:4000', 'image'],
            'description' => ['required', 'max:255'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên thương hiệu là bắt buộc.',
            'name.max' => 'Tên thương hiệu không được vượt quá 100 ký tự.',
            'name.unique' => 'Tên thương hiệu này đã được sử dụng.',
            'image.image' => 'Tập tin tải lên phải là một hình ảnh.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 4MB.',
            'description.required' => 'Trường mô tả là bắt buộc.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
            'status.required' => 'Trường trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái phải là 0 (không hoạt động) hoặc 1 (hoạt động).',
        ];
    }
}
