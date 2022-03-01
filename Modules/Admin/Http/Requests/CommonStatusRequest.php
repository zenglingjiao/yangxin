<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonStatusRequest extends FormRequest
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
            'id' => 'required|is_positive_integer',
            'status' => 'required|is_status_integer',

        ];
    }

    public function messages()
    {
        return [
            'id.required' => __('admin::request.missing_parameter', ["p" => "（id）"]),
            'id.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（id）"]),
            'status.required' => __('admin::request.missing_parameter', ["p" => "（status）"]),
            'status.is_status_integer' => __('admin::request.parameter_error', ["p" => "（status）"]),
        ];
    }
}









