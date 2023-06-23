<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class makeProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required',
            'sale_off' => 'nullable|numeric|between:1,100',
            'description' => 'required',
            'producer_id' => 'nullable',
            // 'image' => 'required',
            'image' => 'required_if:create,true|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '氏名は入力必須です。',
            'category_id.required' => 'カテゴリーIDは入力必須です。',
            'price.required' => '価格は入力必須です。',
            'sale_off.numeric' => 'セールは数学です。',
            'sale_off.between' => 'セールは1-100%です。',
            'description.required' => '説明は入力必須です。',
            'image.required_if:create,true' => '写真は入力必須です。'
        ];
    }
}
