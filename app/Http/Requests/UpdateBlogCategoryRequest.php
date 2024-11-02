<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogCategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:blog_categories,name,' . $this->route('blog_categories'),
            // 'slug' => 'required|string',
            'status' => 'required|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên blog category là bắt buộc.',
            'name.max' => 'Tên blog category không được vượt quá 255 ký tự.',
            'name.unique' => 'Tên blog category này đã tồn tại.',
            'status.required' => 'Vui lòng chọn trạng thái blog category.',
        ];
    }
}
