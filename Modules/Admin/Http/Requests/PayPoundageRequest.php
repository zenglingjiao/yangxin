<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayPoundageRequest extends FormRequest
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

            'id' => 'integer',
            'name' => 'required',
            'pay_id' => 'required|integer',
            'nper' => 'required|integer',
            'rate' => 'required|integer',
            'note' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'id.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（id）"]),
            'pay_id.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（pay_id）"]),
            'nper.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（nper）"]),
            'name.required' => __('admin::request.please_enter_a_name'),
            'rate.required' => __('admin::request.please_enter_a_name'),
            'note.required' => __('admin::request.please_enter_a_name'),

        ];
    }
}









