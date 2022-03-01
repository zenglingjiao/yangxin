<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PwdRequest extends FormRequest
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
            'y_password' => 'required',
            'password' => 'required|confirmed|regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,18}$/'
            //password_confirmation
        ];
    }

    public function messages()
    {
        return [
            'y_password.required' => __('admin::request.please_enter_the_original_password'),
            'password.required' => __('admin::request.please_enter_the_password'),
            'password.confirmed' => __('admin::request.the_two_passwords_are_inconsistent'),
            'password.regex' => __('admin::request.password_regex', ["min" => 8, "max" => 18]),
        ];
    }
}









