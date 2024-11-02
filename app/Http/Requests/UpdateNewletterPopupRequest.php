<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNewletterPopupRequest extends FormRequest
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
            'image' => ['nullable', 'max:4000', 'image'],
            'title' => ['required', 'max:255'],
            'description' => ['required', 'max:255'],
            'status' => ['required', 'in:0,1'],
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'Hình ảnh là bắt buộc.',
            'image.max' => 'Hình ảnh không được lớn hơn 4000 kilobytes.',
            'image.image' => 'Tệp đã tải lên phải là một hình ảnh hợp lệ.',

            'title.required' => 'URL là bắt buộc.',

            'description.required' => 'Mô tả là bắt buộc.',
            'description.max' => 'Mô tả không được vượt quá 255 ký tự.',

            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ];
    }
}
