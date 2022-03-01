<?php
/**
 * @Name
 * @Description
 * @Auther 非比網絡
 * @Date 2021/11/29 19:27
 */

namespace Modules\Admin\Http\Controllers;

use Modules\Admin\Http\Requests\LoginRequest;
use Modules\Admin\Services\auth\LoginService;

class LoginController extends BaseAdminController
{

    public function login()
    {
        $title = "後台登入";
        //return view("login", compact('title'));
        return view('admin::login', compact('title'));
    }

    public function login_in(LoginRequest $request)
    {
        //取出验证码是否一致
        $captcha = \Cache::get($request->get("client"));
        if (strtolower($request->get("code")) != strtolower($captcha)) {
            return (new LoginService())->webError(__('admin::controller.verification_code_error'));
        }
        return (new LoginService())->login($request->only(['username', 'password']));
    }

}