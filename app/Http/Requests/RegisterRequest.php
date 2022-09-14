<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'name' => 'required',
            'email' => 'unique:users,email',
            'username' => 'unique:users,username'
            // 'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            // 'name.required' => 'Vui lòng nhập họ tên',
            'email.unique' => __('Email already in use'),
            'username.unique' => __('Username already exists')
            // 'password.required' => 'Vui lòng nhập mật khẩu'
        ];
    }
}
