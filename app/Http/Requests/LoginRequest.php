<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'メールアドレスは入力必須です。',
            'email.email' => 'メールアドレスは正しくご入力ください。',
            'password.required' => 'パスワードは必須入力です。',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            $email = $this->input('email');
            $password = $this->input('password');
            $user = Users::where('email', $email)->first();

            if (!$user) {
                $validator->errors()->add('email', 'メールアドレスは存在しません。');
            } else {
                if (!Hash::check($password, $user->password)) {
                    $validator->errors()->add('password', 'パスワードは正しくありません。');
                }
            }
        });
    }
}
