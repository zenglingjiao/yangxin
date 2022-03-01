<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateRequest extends FormRequest
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
            'is_role' => 'required',
            'id' => 'required|is_positive_integer',
            'name' => 'required',
            'role_ids' => 'exclude_unless:is_role,1|required',
            'group_id' => 'exclude_unless:is_role,0|required',
            'username' => 'required|regex:/^[A-Za-z_\d]{5,18}$/|unique:auth_admins,username,' . $this->get('id'),
            'email' => 'required|regex:/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/|unique:auth_admins,email,' . $this->get('id'),
            'password' => 'nullable|regex:/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{8,18}$/',
        ];
    }

    public function messages()
    {
        return [
            'is_role.required' => __('admin::request.please_select_is_role'),
            'id.required' => __('admin::request.missing_parameter', ["p" => "（id）"]),
            'id.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（id）"]),
            'role_ids.required' => __('admin::request.please_select_identity'),
            'group_id.required' => __('admin::request.please_select_group'),
            'name.required' => __('admin::request.please_enter_a_name'),
            'username.required' => __('admin::request.please_enter_the_account_number'),
            'username.regex' => __('admin::request.account_number_characters', ["min" => 5, "max" => 18]),
            'username.unique' => __('admin::request.account_already_exists'),
            'email.required' => __('admin::request.please_enter_mailbox'),
            'email.unique' => __('admin::request.mailbox_already_exists'),
            'email.regex' => __('admin::request.please_enter_the_correct_mailbox'),
            'password.regex' => __('admin::request.password_regex', ["min" => 8, "max" => 18]),
        ];
    }
}









