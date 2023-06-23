<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckPaymentRequest extends FormRequest
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
            
            'phone' => 'required|regex:/^[0-9]{10,11}$/',
            'email' => 'required|email',
            'address' => 'required',   //|regex:/^(...??[都道府県])((?:旭川|伊達|石狩|盛岡|奥州|田村|南相馬|那須塩原|東村山|武蔵村山|羽村|十日町|上越|富山|野々市|大町|蒲郡|四日市|姫路|大和郡山|廿日市|下松|岩国|田川|大村)市|.+?郡(?:玉村|大町|.+?)[町村]|.+?市.+?区|.+?[市区町村])(.+)/',
            'pay' => 'required',
            'deli_time' => 'nullable',
            'back' => 'nullable',
            'name' => 'nullable',
            'quantity' => 'nullable',
            'price' => 'nullable',
            'id' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [    
            "phone.required" => "電話番号は入力必須です。",
            "phone.regex" => "電話番号は正しいでご入力ください。",
            "email.required" => "メールアドレスは入力必須です。",
            "email.email" => "メールアドレスは正しくご入力ください。",
            "address.required" => "住所は必須入力です。",
            // "address.regex" => "住所は正しいでご入力ください。",
            "pay.required" => "支払い方法は必須入力です。",
        ];
    }
}
