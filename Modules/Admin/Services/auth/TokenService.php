<?php
/**
 * @Name 管理員信息服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/11 17:10
 */

namespace Modules\Admin\Services\auth;

use Modules\Admin\Services\BaseAdminService;
use Modules\Common\Exceptions\AdminException;
use Modules\Common\Exceptions\StatusData;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Facades\JWTAuth;

class TokenService extends BaseAdminService
{
    /**
     * @name 設置token 生成機製
     * @description
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 17:23
     */
    public function __construct()
    {
        //\Config::set('auth.defaults.guard', 'auth_admin');
        //\Config::set('jwt.ttl', 60);
    }

    /**
     * @name 設置token
     * @description
     * @param data  Array 用戶信息
     * @param data.username String 帳號
     * @param data.password String 密碼$
     * @return JSON | Array
     **@author 非比網絡
     * @date 2021/6/11 17:24
     */
    public function setToken($data)
    {
        if (!$token = JWTAuth::attempt($data)) {
            $this->webError(__('admin::admin.token_generation_failed'));
        }
        return $this->respondWithToken($token);
    }

    /**
     * @name 刷新token
     * @description
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 17:48
     */
    public function refreshToken()
    {
        try {
            $old_token = JWTAuth::getToken();
            $token = JWTAuth::refresh($old_token);
        } catch (TokenBlacklistedException $e) {
            // 這個時候是老的token被拉到黑名單了
            throw new AdminException(['status' => StatusData::TOKEN_ERROR_BLACK, 'message' => __('exceptions.TOKEN_ERROR_BLACK')]);
        }
        return $this->apiSuccess('', $this->respondWithToken($token));
    }

    /**
     * @name 管理員信息
     * @description
     * @return Array
     **@author 非比網絡
     * @date 2021/6/11 19:11
     */
    public function my(): Object
    {
        return JWTAuth::parseToken()->touser();
    }

    /**
     * @name
     * @description
     * @param
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/16 9:53
     * @method  GET
     */
    public function info()
    {
        $data = $this->my();
        return $this->apiSuccess('', ['username' => $data['username']]);
    }

    /**
     * @name 退出登錄
     * @description
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/11 19:12
     */
    public function logout()
    {
        JWTAuth::parseToken()->invalidate();
        return $this->webSuccess(__('admin::admin.exit_successful'));
    }

    /**
     * @name 組合token數據
     * @description
     * @return Array
     **@author 非比網絡
     * @date 2021/6/11 17:47
     */
    protected function respondWithToken($token): Array
    {
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
        ];
    }
}