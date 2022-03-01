<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KeywordHintAddRequest extends FormRequest
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
            'keyword' => 'required',
            'weight' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'keyword.required' => __('admin::request.please_enter_keyword'),
            'weight.required' => __('admin::request.please_select_weight'),
        ];
    }
}









