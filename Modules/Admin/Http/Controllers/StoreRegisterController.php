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
use Modules\Admin\Services\storeRegister\StoreRegisterService;


class StoreRegisterController extends BaseAdminController
{

    public function index(StoreRegisterService $service)
    {
        $title = __('admin::controller.store_register');
        // $parent = $service->edit($id);

        return view('admin::store_register.index',compact('title'));
    }


    public function edit(int $id=0,Request $request,StoreRegisterService $service)
    {
        $title = __('admin::controller.store_register');
        $model = $service->edit($id);
        $record = $service->record($id);
        $record_list = $service->record_list($id);
        // var_dump($model);exit;

        return view('admin::store_register.edit',compact('title','model','record','record_list'));
    }

    public function list(CommonPageRequest $request, StoreRegisterService $service)
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
     * @param StoreRegisterService $service
     * @return \Modules\Common\Services\JSON
     */
    public function update(Request $request, StoreRegisterService $service)
    {
        return $service->update($request->get('id'), $request->only([
            'id',
            'reply',
            'adjust_field',
            'register_audit_status',
        ]));
    }

     /**
     * @Name 調整狀態
     * @Interface status
     * @Notes
     * @param CommonStatusRequest $request
     * @return \Modules\Admin\Services\store_register\JSON
      * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function status(Request $request, StoreRegisterService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

}
