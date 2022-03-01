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
use Modules\Admin\Services\storeChange\StoreChangeService;


class StoreChangeController extends BaseAdminController
{

    public function index(StoreChangeService $service)
    {
        $title = __('admin::controller.store_change');
        // $parent = $service->edit($id);

        return view('admin::store_change.index',compact('title'));
    }


    public function edit(int $id=0,Request $request,StoreChangeService $service)
    {
        $title = __('admin::controller.store_change');
        $model = $service->edit($id);
        // var_dump($model);exit;

        return view('admin::store_change.edit',compact('title','model'));
    }

    public function list(CommonPageRequest $request, StoreChangeService $service)
    {

        return $service->list($request->only([
            'name',
            'limit',
        ]));
    }
    /**
     * @Name: 編輯
     * @Route: banner_big_edit
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:43
     * @param BannerBigUpdateRequest $request
     * @param StoreChangeService $service
     * @return \Modules\Common\Services\JSON
     */
    public function update(Request $request, StoreChangeService $service)
    {
//         return;
        return $service->update($request->get('id'), $request->only([
            'reply',
            'store_id',
            'adjust_field',
            'status',
        ]));
    }

     /**
     * @Name 調整狀態
     * @Interface status
     * @Notes
     * @param CommonStatusRequest $request
     * @return \Modules\Admin\Services\store_change\JSON
      * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function status(Request $request, StoreChangeService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

}
