<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'max:255',
            'image' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => __('Please enter a title'),
            'name.max' => __('255 characters limit'),
            'description.required' => __('255 characters limit'),
            'image.required' => __('Please select image')
        ];
    }
}
