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
use Modules\Admin\Services\EcAdvertising\EcAdvertisingService;


class EcAdvertisingController extends BaseAdminController
{

    public function index(int $id=0,EcAdvertisingService $service)
    {
        $title = __('admin::controller.ec_advertising');
        // $parent = $service->edit($id);


        return view('admin::ec_advertising.index',compact('title'));
    }


    public function edit(int $id=0,Request $request,EcAdvertisingService $service)
    {
        $title = __('admin::controller.ec_advertising_edit');
        $model = $service->edit($id);
        // var_dump($model);exit;

        return view('admin::ec_advertising.edit',compact('title','model'));
    }

    public function list(CommonPageRequest $request, EcAdvertisingService $service)
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
    public function update(Request $request, EcAdvertisingService $service)
    {
        // return;
        return $service->update($request->get('id'), $request->only([
            'name',
            'store_id',
            'imgs',
            'url',
            'ad_sort',
            'up_at',
            'status',

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
    public function status(Request $request, EcAdvertisingService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

    public function del(Request $request,EcAdvertisingService $service)
    {
        return $service->del($request->get('ids'));
    }

}
