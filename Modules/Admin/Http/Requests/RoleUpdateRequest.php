<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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
            'name' => 'required|min:2|max:20|unique:roles,name,' . $this->id
        ];
    }

    public function messages()
    {
        return [
            'id.required' => __('admin::request.missing_parameter', ["p" => "（id）"]),
            'id.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（id）"]),
            'name.required' => __('admin::request.please_enter_the_identity_name'),
            'name.unique' => __('admin::request.identity_name_already_exists'),
            'name.min' => __('admin::request.identity_name_characters', ["min" => 2, "max" => 20]),
            'name.max' => __('admin::request.identity_name_characters', ["min" => 2, "max" => 20]),
        ];
    }
}









