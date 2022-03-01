<?php

namespace Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerBigUpdateRequest extends FormRequest
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
            'pc_img' => 'required',
            'phone_img' => 'required',
            'up_time' => 'required|is_positive_integer',
            'down_time' => 'required|is_positive_integer',
            'status' => 'required|is_positive_integer',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => __('admin::request.missing_parameter', ["p" => "（id）"]),
            'id.is_positive_integer' => __('admin::request.parameter_error', ["p" => "（id）"]),
            'name.required' => __('admin::request.please_enter_a_name'),
            'pc_img.required' => __('admin::request.please_select_picture'),
            'phone_img.required' => __('admin::request.please_select_picture'),
            'up_time.required' => __('admin::request.please_enter_the_date'),
            'down_time.required' => __('admin::request.please_enter_the_date'),
            'status.required' => __('admin::request.please_select_a_status'),
        ];
    }
}









