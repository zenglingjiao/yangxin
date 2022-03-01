<?php

namespace Modules\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Services\invoice\InvoiceService;
use Modules\Admin\Services\logistics\LogisticsService;


class InvoiceController extends BaseAdminController
{

    /**
     * @Name: 發票捐贈視圖
     * @Route: invoice
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:20
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $title = __('admin::controller.invoice');

        return view('admin::invoice.index',compact('title'));
    }

    /**
     * @Name: 發票捐贈列表
     * @Route: invoice_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:21
     * @param CommonPageRequest $request
     * @param InvoiceService $service
     * @return \Modules\Admin\Services\invoice\JSON
     */
    public function list(CommonPageRequest $request,InvoiceService $service)
    {

        return $service->list($request->only([
            'page',
            'limit',
        ]));
    }


    /**
     * @Name: 發票捐贈更新
     * @Route: invoice_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:22
     * @param Request $request
     * @param InvoiceService $service
     * @return \Modules\Admin\Services\invoice\JSON
     */
    public function update(Request $request,InvoiceService $service)
    {

        return $service->update($request->get('id'), $request->only([
            'name','code'
        ]));
    }

    /**
     * @Name: 發票捐贈刪除
     * @Route: invoice_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:22
     * @param DelIdRequest $request
     * @param InvoiceService $service
     * @return \Modules\Common\Services\JSON
     */
    public function del(DelIdRequest $request,InvoiceService $service)
    {

        return $service->del($request->get('ids'));
    }
}
