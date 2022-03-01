<?php
/**
 * @Name 後台權限驗證中間件
 */

namespace Modules\Admin\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Modules\Admin\Services\log\OperationLogService;
use Modules\Common\Exceptions\AdminException;
use Modules\Common\Exceptions\StatusData;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use JWTAuth;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        Auth::setDefaultDriver('auth_admin');
        //\Config::set('auth.defaults.guard', 'auth_admin');
        if ($request->has("isAlways") && $request->input("isAlways") == '1') {
            \Config::set('jwt.ttl', 60 * 24);
        } else {
            \Config::set('jwt.ttl', 120);
        }
        $route_data = $request->route();
        $url = str_replace($route_data->getAction()['prefix'] . '/', "", $route_data->uri);
        $url_arr = ['admin/login', 'admin/login_in', 'index/get_main', 'index/refresh_token'];
        // $api_key = $request->header('apikey');
        // if($api_key != config('admin.api_key')){
        //     throw new AdminException(['status'=>StatusData::TOKEN_ERROR_KEY,'message'=>MessageData::TOKEN_ERROR_KEY]);
        //     return $next();
        // }
        if (in_array($url, $url_arr)) {
            return $next($request);
        }
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {  //獲取到用戶數據，並賦值給$user   'msg' => '用戶不存在'
                throw new AdminException(['status' => StatusData::QUERY_EXCEPTION, 'message' => __('exceptions.TOKEN_ERROR_SET')]);
                return $next();
            }
        } catch (TokenBlacklistedException $e) {
            // 這個時候是老的token被拉到黑名單了
            throw new AdminException(['status' => StatusData::TOKEN_ERROR_BLACK, 'message' => __('exceptions.TOKEN_ERROR_BLACK')]);
            return $next();
        } catch (TokenExpiredException $e) {
            //token已過期
            throw new AdminException(['status' => StatusData::TOKEN_ERROR_EXPIRED, 'message' => __('exceptions.TOKEN_ERROR_EXPIRED')]);
            return $next();
        } catch (TokenInvalidException $e) {
            //token無效

            throw new AdminException(['status' => StatusData::TOKEN_ERROR_JWT, 'message' => __('exceptions.TOKEN_ERROR_JWT')]);

            return $next();
        } catch (JWTException $e) {
            //'缺少token'
            throw new AdminException(['status' => StatusData::TOKEN_ERROR_JTB, 'message' => __('exceptions.TOKEN_ERROR_JTB')]);
            return $next();
        }
        // 寫入日誌
        (new OperationLogService())->store($user['id']);


        //        if(!in_array($url,['auth/index/refresh','auth/index/logout'])){
        //            if($user['id'] != 1 && $id = AuthRuleModel::where(['href'=>$url])->value('id')){
        //                $rules = AuthGroupModel::where(['id'=>$user['group_id']])->value('rules');
        //                if(!in_array($id,explode('|',$rules))){
        //                    throw new ApiException(['code'=>6781,'msg'=>'您沒有權限！']);
        //                }
        //            }
        //        }

        return $next($request);
    }
}