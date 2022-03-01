<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GroupAddRequest extends FormRequest
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
            'role_ids' => 'required',
            //'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'role_ids.required' => __('admin::request.please_select_identity'),
            'name.required' => __('admin::request.please_enter_a_name'),
            //'status.required' => __('admin::request.please_select_a_status'),
        ];
    }
}









