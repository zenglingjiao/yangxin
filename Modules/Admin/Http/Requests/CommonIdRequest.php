<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonIdRequest extends FormRequest
{


    public function authorize()
    {
        return true;
    }
	public function rules()
    {
        return [
			'id' => 'required|is_positive_integer',
        ];
    }
	public function messages(){
		return [
			'id.required' 				=> __('admin::request.missing_parameter', ["p" => "（id）"]),
			'id.is_positive_integer' 	=> __('admin::request.parameter_error', ["p" => "（id）"]),
		];
	}
}









