<?php
/**
 * @Name
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 02:48
 */

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonPageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'page' => 'required|is_positive_integer',
            'limit' => 'required|is_positive_integer',
        ];
    }

    public function messages()
    {
        return [
            'page.required' => __('admin::request.missing_parameter', ["p" => "（page）"]),
            'page.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（page）"]),
            'limit.required' => __('admin::request.missing_parameter', ["p" => "（limit）"]),
            'limit.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（limit）"]),
        ];
    }
}
