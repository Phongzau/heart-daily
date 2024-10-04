<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'name' => ['required', 'max:100', 'unique:brands,name'],
            'description' => ['nullable', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'status' => ['required'],
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
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',
            'image.required' => 'Hình ảnh là bắt buộc cho thương hiệu.',
            'image.image' => 'Tập tin phải là một hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng: jpeg, png, jpg.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ];
    }
}
