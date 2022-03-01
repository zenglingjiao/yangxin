<?php

namespace Modules\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Services\logistics\LogisticsService;


class LogisticsController extends BaseAdminController
{

    /**
     * @Name: 物流視圖
     * @Route: logistics
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:35
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $title = __('admin::controller.logistics');

        return view('admin::logistics.index',compact('title'));
    }

    /**
     * @Name: 物流列表
     * @Route: logistics_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:36
     * @param CommonPageRequest $request
     * @param LogisticsService $service
     * @return \Modules\Admin\Services\logistics\JSON
     */
    public function list(CommonPageRequest $request,LogisticsService $service)
    {

        return $service->list($request->only([
            'page',
            'limit',
        ]));
    }


    /**
     * @Name: 物流更新
     * @Route: logistics_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:36
     * @param Request $request
     * @param LogisticsService $service
     * @return \Modules\Admin\Services\logistics\JSON
     */
    public function update(Request $request,LogisticsService $service)
    {

        return $service->update($request->get('id'), $request->only([
            'freight','status'
        ]));
    }
}
