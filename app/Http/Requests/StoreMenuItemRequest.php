<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuItemRequest extends FormRequest
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
            'title' => ['required'],
            'parent_id' => ['required'],
            'order' => ['required'],
            'url' => 'required',
            'slug' => [''],
            'menu_id' => ['required'],
            'status' => ['required', 'in:0,1'],
            'userid_created' => [''],
            'userid_updated' => [''],

        ];
    }
}
