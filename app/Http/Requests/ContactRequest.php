<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ContactRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'name' => 'required|max:20',
            'phone' => 'nullable|regex:/^[0-9]{10,11}$/',
            'email' => 'required|email',
            'content' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "氏名は入力必須です。",
            "name.max" => "氏名は20文字以内でご入力ください。",
            "phone.regex" => "電話番号は正しいでご入力ください。",
            "email.required" => "メールアドレスは入力必須です。",
            "email.email" => "メールアドレスは正しくご入力ください。",
            "content.required" => "お問い合わせ内容は必須入力です。",
        ];
    }
}
