<?php
/**
 * @Name  平臺公共相關接口
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/11 17:39
 */

namespace Modules\Admin\Http\Controllers;

use Carbon\Carbon;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Modules\Admin\Http\Requests\PwdRequest;
use Modules\Admin\Services\admin\UpdatePasswordService;
use Modules\Admin\Services\auth\ConfigService;
use Modules\Admin\Services\auth\TokenService;
use Modules\Admin\Services\role\RoleService;

class IndexController extends BaseAdminController
{
    public function index()
    {
        $title = __('admin::controller.admin_index');
        //return view("login", compact('title'));
        return view('admin::index', compact('title'));
    }

    /**
     * @Name 驗證碼
     * @Interface get_img_code
     * @Notes
     * @return array
     * @author: Davi
     * @Time: 2021/12/10   17:10
     */
    public function get_img_code()
    {
        $phrase = new PhraseBuilder(5, '0123456789');//new PhraseBuilder();
        // 设置验证码位数
        $code = $phrase->build(4);
        // 生成验证码图片的Builder对象，配置相应属性
        $builder = new CaptchaBuilder($code, $phrase);
        // 设置背景颜色25,25,112
        //$builder->setBackgroundColor(34, 0, 45);
        // 设置倾斜角度
        //$builder->setMaxAngle(20);
        // 设置验证码后面最大行数
        //$builder->setMaxBehindLines(8);
        // 设置验证码前面最大行数
        //$builder->setMaxFrontLines(8);
        // 设置验证码颜色
        $builder->setTextColor(230, 81, 175);
        // 可以设置图片宽高及字体
        $builder->build($width = 300, $height = 80, $font = null);
        // 获取验证码的内容
        $phrase = $builder->getPhrase();

        // 把内容存入 cache，10分钟后过期
        $client_id = md5(rand(1, 1000) . time());
        \Cache::put($client_id, $phrase, Carbon::now()->addMinutes(10));

        // 组装接口数据
        $data = [
            'client' => $client_id,
            'captcha' => $builder->inline(),
        ];
        return $data;
    }

    /**
     * @Name 獲取菜單
     * @Interface get_meun
     * @Notes
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/10   17:10
     */
    public function get_meun()
    {
        return (new RoleService())->get_menu();
    }

    /**
     * @Name 刷新token
     * @Interface refreshToken
     * @Notes
     * @return \Modules\Admin\Services\auth\JSON
     * @throws \Modules\Common\Exceptions\AdminException
     * @throws \Modules\Common\Exceptions\ApiException
     * @author: Davi
     * @Time: 2021/12/10   17:10
     */
    public function refreshToken()
    {
        return (new TokenService())->refreshToken();
    }

    /**
     * @Name 退出登錄
     * @Interface logout
     * @Notes
     * @return \Modules\Admin\Services\auth\JSON
     * @author: Davi
     * @Time: 2021/12/10   17:10
     */
    public function logout()
    {
        return (new TokenService())->logout();
    }

    /**
     * @Name 清除緩存
     * @Interface outCache
     * @Notes
     * @return \Modules\Admin\Services\auth\JSON
     * @author: Davi
     * @Time: 2021/12/10   17:10
     */
    public function outCache()
    {
        return (new ConfigService())->outCache();
    }

    /**
     * @Name 修改密碼
     * @Interface upadte_password
     * @Notes
     * @param PwdRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   17:11
     */
    public function upadte_password(PwdRequest $request)
    {
        return (new UpdatePasswordService())->upadte_pass_word($request->only(['y_password', 'password']));
    }

    /**
     * @Name 獲取管理員信息
     * @Interface info
     * @Notes
     * @return \Modules\Admin\Services\auth\JSON
     * @author: Davi
     * @Time: 2021/12/10   17:11
     */
    public function info()
    {
        return (new TokenService())->info();
    }

}
