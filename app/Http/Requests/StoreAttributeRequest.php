<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:attributes,slug',
            'category_attribute_id' => 'required|exists:category_attributes,id',
            'price_start' => 'nullable|numeric|min:0',
            'price_end' => 'nullable|numeric|min:0',
            'status' => 'required|boolean',
        ];
    }
}
