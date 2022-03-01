<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NaviRequest extends FormRequest
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
            'type' => 'required|string',
            'jump_type' => 'required|integer',
            'jump_url' => 'nullable|string',
            'sort' => 'required|integer',

        ];
    }

    public function messages()
    {
        return [
        ];
    }
}









