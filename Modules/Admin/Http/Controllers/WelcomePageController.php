<?php

namespace Modules\Admin\Http\Controllers;


use Modules\Admin\Http\Requests\BannerBigAddRequest;
use Modules\Admin\Http\Requests\BannerBigUpdateRequest;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Http\Requests\CommonStatusRequest;
use Modules\Admin\Http\Requests\WelcomeAdRequest;
use Modules\Admin\Http\Requests\WelcomeAppRequest;
use Modules\Admin\Services\banner\BannerService;
use Modules\Admin\Services\welcomePage\WelcomeService;


class WelcomePageController extends BaseAdminController
{

    /**
     * @Name: APP歡迎頁視圖
     * @Route: welcome_app_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:49
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function appList()
    {
        $title = __('admin::controller.welcome_app');

        return view('admin::welcome_page.app_list', compact('title'));
    }

    /**
     * @Name: APP歡迎頁列表
     * @Route: welcome_get_app_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:50
     * @param CommonPageRequest $request
     * @param WelcomeService $service
     * @return \Modules\Admin\Services\welcomePage\JSON
     */
    public function getAppList(CommonPageRequest $request, WelcomeService $service)
    {

        return $service->getAppList($request->only([
            'page',
            'limit',
            'name',
            'status',
        ]));
    }


    /**
     * @Name: 歡迎頁編輯視圖
     * @Route: welcome_app_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:50
     * @param int $id
     * @param WelcomeService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function appEdit(int $id = 0, WelcomeService $service)
    {

        $title = __('admin::controller.welcome_app');
        $model = $id > 0 ? $service->appEdit($id) : null;


        return view('admin::welcome_page.app_edit', compact('title', 'model'));
    }


    /**
     * @Name: 歡迎頁添加
     * @Route: welcome_app_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:51
     * @param WelcomeAppRequest $request
     * @param WelcomeService $service
     * @return \Modules\Admin\Services\welcomePage\JSON
     */
    public function appAdd(WelcomeAppRequest $request, WelcomeService $service)
    {

        return $service->appAdd($request->only([
            'name', 'phone_img', 'up_time', 'down_time', 'status', 'type']));
    }


    /**
     * @Name: 歡迎頁更新
     * @Route: welcome_app_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:52
     * @param WelcomeAppRequest $request
     * @param WelcomeService $service
     * @return \Modules\Admin\Services\welcomePage\JSON
     */
    public function appUpdate(WelcomeAppRequest $request, WelcomeService $service)
    {

        return $service->appUpdate($request->get('id'), $request->only([
            'name', 'phone_img', 'up_time', 'down_time', 'status'
        ]));
    }

    /**
     * @Name: 歡迎頁刪除
     * @Route: welcome_app_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:52
     * @param DelIdRequest $request
     * @param WelcomeService $service
     * @return \Modules\Common\Services\JSON
     */
    public function appDel(DelIdRequest $request, WelcomeService $service)
    {
        return $service->appDel($request->get('ids'));
    }


    /**
     * @Name: 廣告頁視圖
     * @Route: welcome_ad_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:53
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adList()
    {
        $title = __('admin::controller.welcome_ad');

        return view('admin::welcome_page.ad_list', compact('title'));
    }

    /**
     * @Name: 廣告頁列表
     * @Route: welcome_get_ad_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:53
     * @param CommonPageRequest $request
     * @param WelcomeService $service
     * @return \Modules\Admin\Services\welcomePage\JSON
     */
    public function getAdList(CommonPageRequest $request, WelcomeService $service)
    {

        return $service->getAdList($request->only([
            'page',
            'limit',
            'name',
            'status',
        ]));
    }


    /**
     * @Name: 廣告頁視圖
     * @Route: welcome_ad_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:54
     * @param int $id
     * @param WelcomeService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function adEdit(int $id = 0, WelcomeService $service)
    {

        $title = __('admin::controller.welcome_ad');
        $model = $id > 0 ? $service->adEdit($id) : null;


        return view('admin::welcome_page.ad_edit', compact('title', 'model'));
    }


    /**
     * @Name: 廣告頁添加
     * @Route: welcome_ad_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:55
     * @param WelcomeAdRequest $request
     * @param WelcomeService $service
     * @return \Modules\Admin\Services\welcomePage\JSON
     */
    public function adAdd(WelcomeAdRequest $request, WelcomeService $service)
    {

        return $service->adAdd($request->only([
            'name', 'pc_img', 'phone_img', 'up_time', 'down_time', 'status', 'jump_type','jump_url', 'type']));
    }


    /**
     * @Name: 廣告頁更新
     * @Route: welcome_ad_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:55
     * @param WelcomeAdRequest $request
     * @param WelcomeService $service
     * @return mixed
     */
    public function adUpdate(WelcomeAdRequest $request, WelcomeService $service)
    {

        return $service->belowUpdate($request->get('id'), $request->only([
            'name', 'pc_img', 'phone_img', 'jump_type', 'status', 'up_time', 'down_time'
        ]));
    }

    /**
     * @Name: 廣告頁刪除
     * @Route: welcome_ad_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:55
     * @param DelIdRequest $request
     * @param WelcomeService $service
     * @return \Modules\Common\Services\JSON
     */
    public function adDel(DelIdRequest $request, WelcomeService $service)
    {
        return $service->adDel($request->get('ids'));
    }

}
