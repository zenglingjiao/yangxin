<?php

namespace Modules\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\BannerBigAddRequest;
use Modules\Admin\Http\Requests\BannerBigUpdateRequest;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Http\Requests\CommonStatusRequest;
use Modules\Admin\Services\banner\BannerService;
use Modules\Admin\Services\website\WebsiteService;


class WebsiteController extends BaseAdminController
{

    /**
     * @Name: 網站設置視圖
     * @Route: website_index
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:47
     * @param $type
     * @param WebsiteService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index($type,WebsiteService $service)
    {

        if (!in_array($type,['basis','login','sms','email','member','privacy'])){
            abort(404);
        }
        $title = __('admin::controller.website_'.$type);
        $model =  $service->getByType($type);


        return view('admin::website.'.$type,compact('title','model'));
    }

    /**
     * @Name: 網站設置更新
     * @Route: website_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:48
     * @param Request $request
     * @param WebsiteService $service
     * @return \Modules\Admin\Services\website\JSON
     */
    public function update(Request $request,WebsiteService $service)
    {

        return $service->update($request->input());
    }



}
