<?php

namespace Modules\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Services\invoice\InvoiceService;
use Modules\Admin\Services\logistics\LogisticsService;
use Modules\Admin\Services\menu\MenuFooterService;
use phpDocumentor\Reflection\DocBlock;


class MenuFooterController extends BaseAdminController
{

    /**
     * @Name: 底部菜單視圖
     * @Route: menu_footer
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:37
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(int $id=0)
    {

        if($id== 0){
            $title = __('admin::controller.menu_footer');

            return view('admin::menu_footer.index',compact('title'));
        }else{
            $title = __('admin::controller.menu_footer_small');

            return view('admin::menu_footer.small',compact('title','id'));
        }
    }

    /**
     * @Name: 底部菜單列表
     * @Route: menu_footer_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:38
     * @param int $id
     * @param CommonPageRequest $request
     * @param MenuFooterService $service
     * @return \Modules\Admin\Services\menu\JSON
     */
    public function list(int $id=0,CommonPageRequest $request,MenuFooterService $service)
    {

        return $service->list($id,$request->only([
            'page',
            'limit',
        ]));
    }


    /**
     * @Name: 底部菜單更新
     * @Route: menu_footer_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:39
     * @param Request $request
     * @param MenuFooterService $service
     * @return \Modules\Admin\Services\menu\JSON
     */
    public function update(Request $request,MenuFooterService $service)
    {

        return $service->update($request->get('id'), $request->only([
            'name','type','link','status','pid'
        ]));
    }

    /**
     * @Name: 底部菜單刪除
     * @Route: menu_footer_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:40
     * @param DelIdRequest $request
     * @param InvoiceService $service
     * @return \Modules\Common\Services\JSON
     */
    public function del(DelIdRequest $request,InvoiceService $service)
    {

        return $service->del($request->get('ids'));
    }
}
