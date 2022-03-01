<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupUpdateRequest extends FormRequest
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
            'name' => 'required',
            'role_ids' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => __('admin::request.missing_parameter', ["p" => "（id）"]),
            'id.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（id）"]),
            'role_ids.required' => __('admin::request.please_select_identity'),
            'name.required' => __('admin::request.please_enter_a_name'),
        ];
    }
}









