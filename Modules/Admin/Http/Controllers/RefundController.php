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
use Modules\Admin\Services\refund\RefundService;


class RefundController extends BaseAdminController
{

    public function index(RefundService $service)
    {
        $title = __('admin::controller.refund');
        // $parent = $service->edit($id);

        return view('admin::refund.index',compact('title'));
    }


    public function edit(int $id=0,Request $request,RefundService $service)
    {
        $title = __('admin::controller.refund');
        $model = $service->edit($id);
        // var_dump($model);exit;

        return view('admin::refund.edit',compact('title','model'));
    }

    public function list(CommonPageRequest $request, RefundService $service)
    {

        return $service->list($request->only([
            'name',
            'limit',
        ]));
    }

    public function findlist(CommonPageRequest $request, RefundService $service)
    {

        return $service->findlist($request->only([
            'name'
        ]));
    }

    /**
     * @Name: 編輯
     * @Route: banner_big_edit
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:43
     * @param BannerBigUpdateRequest $request
     * @param RefundService $service
     * @return \Modules\Common\Services\JSON
     */
    public function update(Request $request, RefundService $service)
    {
        // return;
        return $service->update($request->get('id'), $request->only([
            'store_id',
            'points',
            'remark',
            'status',
        ]));
    }

     /**
     * @Name 調整狀態
     * @Interface status
     * @Notes
     * @param CommonStatusRequest $request
     * @return \Modules\Admin\Services\refund\JSON
      * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function status(Request $request, RefundService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

}
