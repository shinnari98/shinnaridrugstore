<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users;

class RegisterRequest extends FormRequest
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
            'name' => 'required|max:20',
            'nickname' => 'required|max:20',
            'email' => 'required|email',
            'phone' => 'nullable|regex:/^[0-9]{10,11}$/',
            'password' => 'required',
            'password_confir' => 'required|same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '氏名は入力必須です。',
            'name.max' => '氏名は10文字以内でご入力ください。',
            'nickname.required' => 'ニックネームは入力必須です。',
            'nickname.max' => 'ニックネームは10文字以内でご入力ください。',
            'email.required' => 'メールアドレスは入力必須です。',
            'email.email' => 'メールアドレスは正しくご入力ください。',
            "phone.regex" => "電話番号は正しいでご入力ください。",
            'password.required' => 'パスワードは必須入力です。',
            'password_confir.required' => 'パスワードの確認は必須です。',
            'password_confir.same' => 'パスワードと確認パスワードが一致しません。',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            $users = Users::all();

            foreach ($users as $user) {
                if ($user['email'] === $this->input('email')) {
                    $validator->errors()->add('email','メールアドレスはすでに登録されています。');
                }

                if ($user['nickname'] === $this->input('nickname')) {
                    $validator->errors()->add('nickname','ニックネームはすでに登録されています。');
                }
            }
        });
    }
}
