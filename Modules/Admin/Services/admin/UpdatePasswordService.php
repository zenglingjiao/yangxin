<?php
/**
 * @Name 管理員修改密碼服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/11 23:42
 */

namespace Modules\Admin\Services\admin;


use Modules\Admin\Models\AuthAdmin;
use Modules\Admin\Services\auth\TokenService;
use Modules\Admin\Services\BaseAdminService;

class UpdatePasswordService extends BaseAdminService
{
    /**
     * @name 修改密碼
     * @description
     * @param data  Array  用戶數據
     * @param data.y_password String 原密碼
     * @param data.password String 密碼
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 23:45
     */
    public function upadte_pass_word(array $data)
    {
        $user_info = (new TokenService())->my();
        if (true == \Auth::guard('auth_admin')->attempt(['username' => $user_info['username'], 'password' => $data['y_password']])) {
            if (AuthAdmin::where('id', $user_info['id'])->update(['password' => bcrypt($data['password'])])) {
                return $this->webSuccess(__('admin::admin.modified_successfully'));
            }
            return $this->webError(__('admin::admin.modification_failed'));
        }
        return $this->webError(__('admin::admin.original_password_error'));
    }
}
