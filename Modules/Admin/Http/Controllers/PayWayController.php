<?php

namespace Modules\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\CommonStatusRequest;
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Http\Requests\PayPoundageRequest;
use Modules\Admin\Services\invoice\InvoiceService;
use Modules\Admin\Services\logistics\LogisticsService;
use Modules\Admin\Services\menu\MenuFooterService;
use Modules\Admin\Services\payWay\PayWayService;
use phpDocumentor\Reflection\DocBlock;


class PayWayController extends BaseAdminController
{

    /**
     * @Name: 支付方式視圖
     * @Route: pay_way
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:41
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(int $id=0)
    {

        if($id== 0){
            $title = __('admin::controller.pay_way');

            return view('admin::pay_way.index',compact('title'));
        }else{
            $title = __('admin::controller.pay_way_set');

            return view('admin::pay_way.set',compact('title','id'));
        }
    }

    /**
     * @Name: 支付方式列表
     * @Route: pay_way_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:42
     * @param CommonPageRequest $request
     * @param PayWayService $service
     * @return \Modules\Admin\Services\payWay\JSON
     */
    public function list(CommonPageRequest $request,PayWayService $service)
    {

        return $service->list($request->only([
            'page',
            'limit',
        ]));
    }

    /**
     * @Name: 改變狀態
     * @Route: pay_way_status
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:42
     * @param CommonStatusRequest $request
     * @param PayWayService $service
     * @return \Modules\Admin\Services\payWay\JSON
     */
    public function status(CommonStatusRequest $request,PayWayService $service){
       return $service->status($request->get('id'), $request->only(['status']));
    }


    /**
     * @Name: 手續費列表
     * @Route: pay_poundage_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:43
     * @param int $id
     * @param CommonPageRequest $request
     * @param PayWayService $service
     * @return \Modules\Admin\Services\payWay\JSON
     */
    public function poundageList(int $id,CommonPageRequest $request,PayWayService $service)
    {

        return $service->poundageList($id,$request->only([
            'page',
            'limit',
        ]));
    }


    /**
     * @Name: 手續費更新
     * @Route: pay_poundage_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:44
     * @param PayPoundageRequest $request
     * @param PayWayService $service
     * @return \Modules\Admin\Services\payWay\JSON
     */
    public function poundageUpdate(PayPoundageRequest $request,PayWayService $service)
    {

        return $service->poundageUpdate($request->get('id'), $request->only([
            'pay_id','name','nper','rate','note'
        ]));
    }

    /**
     * @Name: 手續費刪除
     * @Route: pay_poundage_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:45
     * @param DelIdRequest $request
     * @param PayWayService $service
     * @return mixed
     */
    public function poundageDel(DelIdRequest $request,PayWayService $service)
    {

        return $service->del($request->get('ids'));
    }
}
