<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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
            'name' => 'required|unique:services,name',
            // 'email' => 'required',
            'category_id' => 'required'
            // 'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('This field is required'),
            'name.unique' => __('Service name already exists'),
            // 'email.required' => 'Vui lòng nhập email',
            'category_id.required' => __('Please select a category')
            // 'password.required' => 'Vui lòng nhập mật khẩu'
        ];
    }
}
