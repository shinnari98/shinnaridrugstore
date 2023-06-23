<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class updateProfileRequest extends FormRequest
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
            'oldPassword' => 'nullable',
            'newPassword' => 'nullable',
            'passConfirm' => 'nullable|same:newPassword'
        ];/* required_with:changePass__box,true */
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
            'passConfirm.same' => '新パスワードと確認パスワードが一致しません。',
        ];
    }

    public function withValidator($validator)
    {
        $user = session()->get('user');
        $oldPassword = $this->input('oldPassword');
        $validator->after(function ($validator) use ($user,$oldPassword) {
            $users = User::where('id', '!=', $user->id)->get();
            // dd(Hash::check($oldPassword, $user->password));
            if (Hash::check($oldPassword, $user->password) & $oldPassword != null) {
                $validator->errors()->add('oldPassword', '前パスワードは正しくありません。');
            }
            foreach ($users as $user) {
                if ($user['email'] === $this->input('email')) {
                    $validator->errors()->add('email', 'メールアドレスはすでに登録されています。');
                }

                if ($user['nickname'] === $this->input('nickname')) {
                    $validator->errors()->add('nickname', 'ニックネームはすでに登録されています。');
                }
            }
        });

        // dd($validator->errors(), 'request');
    }
}
