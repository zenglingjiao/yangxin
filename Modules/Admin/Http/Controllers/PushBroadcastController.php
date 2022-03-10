<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/22/022
 * Time: 16:05
 */

namespace Modules\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Services\PushBroadcast\PushBroadcastService;


class PushBroadcastController extends BaseAdminController
{

    public function index(int $id = 0, PushBroadcastService $service)
    {
        $title = __('admin::controller.push_broadcast');
        // $parent = $service->edit($id);


        return view('admin::push_broadcast.index', compact('title'));
    }


    public function edit(int $id = 0, Request $request, PushBroadcastService $service)
    {
        $title = __('admin::controller.push_broadcast_edit');
        $model = $service->edit($id);
        $store = $service->store_list($model->receive_object??[]);

        //         var_dump($store);exit;

        return view('admin::push_broadcast.edit', compact('title', 'model', 'store'));
    }

    public function list(CommonPageRequest $request, PushBroadcastService $service)
    {
        return $service->list($request->only([
            'name',
            'limit',
        ]));
    }


    /**
     * @Name: 大Banner編輯
     * @Route: banner_big_edit
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:43
     * @param BannerBigUpdateRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function update(Request $request, PushBroadcastService $service)
    {
        // return;
        return $service->update($request->get('id'), $request->only([
            'title',
            'content',
            'push_object',
            'receive_object',
            'push_manner',
            'push_time',
        ]));
    }

    /**
     * @Name 調整狀態
     * @Interface status
     * @Notes
     * @param CommonStatusRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function status(Request $request, PushBroadcastService $service)
    {
        return $service->status($request->get('id'), $request->only(['status']));
    }

    public function del(Request $request, PushBroadcastService $service)
    {
        return $service->del($request->get('ids'));
    }

}
