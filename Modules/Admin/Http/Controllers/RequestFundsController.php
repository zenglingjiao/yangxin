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
use Modules\Admin\Services\requestFunds\RequestFundsService;


class RequestFundsController extends BaseAdminController
{

    public function index(RequestFundsService $service)
    {
        $title = __('admin::controller.request_funds');
        // $parent = $service->edit($id);

        return view('admin::request_funds.index',compact('title'));
    }


    public function edit(int $id=0,Request $request,RequestFundsService $service)
    {
        $title = __('admin::controller.request_funds');
        $model = $service->edit($id);
        // var_dump($model);exit;

        return view('admin::request_funds.edit',compact('title','model'));
    }

    public function list(CommonPageRequest $request, RequestFundsService $service)
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
     * @param RequestFundsService $service
     * @return \Modules\Common\Services\JSON
     */
    public function update(Request $request, RequestFundsService $service)
    {
        // return;
        return $service->update($request->get('id'), $request->only([
            'type',
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
     * @return \Modules\Admin\Services\request_funds\JSON
      * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function status(Request $request, RequestFundsService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

}
