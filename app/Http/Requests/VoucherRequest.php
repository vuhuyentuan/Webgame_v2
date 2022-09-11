<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VoucherRequest extends FormRequest
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
            'code' => 'unique:vouchers,code',
            'max'=> 'gte:min'
        ];
    }
    public function messages()
    {
        return [
            'code.unique' => __('Code already exists'),
            'max.gte' => __('The maximum must be greater than the minimum')
        ];
    }
}
