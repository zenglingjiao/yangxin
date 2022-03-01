<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WelcomeAppRequest extends FormRequest
{
    /**
     * php artisan module:make-request AdminRequest Admin
     */

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'phone_img' => 'required',
            'up_time' => 'required|is_positive_integer',
            'down_time' => 'required|is_positive_integer',
            'status' => 'required|is_positive_integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => __('admin::request.please_enter_a_name'),
            'phone_img.required' => __('admin::request.please_select_picture'),
            'up_time.required' => __('admin::request.please_enter_the_date'),
            'down_time.required' => __('admin::request.please_enter_the_date'),
            'status.required' => __('admin::request.please_select_a_status'),
        ];
    }
}









