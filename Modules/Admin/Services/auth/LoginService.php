<?php
/**
 * @Name
 * @Description
 * @Auther 非比網絡
 * @Date 2021/11/29 19:03
 */

namespace Modules\Admin\Services\auth;

use Modules\Admin\Events\AdminLogin;
use Modules\Admin\Services\BaseAdminService;
use Modules\Admin\Models\AuthAdmin;

class LoginService extends BaseAdminService
{
    /**
     * @name 用戶登錄
     * @description
     * @param data  Array 用戶信息
     * @param data.username String 帳號
     * @param data.password String 密碼
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 16:53
     */
    public function login(array $data)
    {
        if (true == \Auth::guard('auth_admin')->attempt($data)) {
            $userInfo = AuthAdmin::where(['username' => $data['username']])
                ->select('id', 'username', 'name', 'status')->first();
            if ($userInfo) {
                if ($userInfo->status != 1) {
                    return $this->webError(__('admin::admin.account_disabled'));
                }
                $user_info = $userInfo->toArray();
                $user_info['password'] = $data['password'];
                $token = (new TokenService())->setToken($user_info);
                $token["user_info"] = $userInfo;
                event(new AdminLogin("auth_admin", \Auth::guard('auth_admin')->user()));
                return $this->webSuccess(__('admin::admin.login_successful'), $token);
            }
        }
        return $this->webError(__('admin::admin.wrong_account_or_password'));
    }
}