<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DelIdRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }
	public function rules()
    {
        return [
			'ids' => 'required',
        ];
    }
	public function messages(){
		return [
			'ids.required' 				=> __('admin::request.missing_parameter', ["p" => "（ids）"]),
		];
	}
}









