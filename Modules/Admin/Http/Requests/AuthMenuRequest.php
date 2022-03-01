<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthMenuRequest extends FormRequest
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
            'parent' => 'required|integer',
            'name' => 'required|string',
            'guard_name' => 'required|string',
            'full_name' => 'required|string',
            'is_menu' => 'required|integer',
            'is_route' => 'required|integer',
           // 'route' => 'string',
           // 'ico' => 'nullable|string',
           // 'active' => 'nullable|string',
            'sort' => 'required',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}









