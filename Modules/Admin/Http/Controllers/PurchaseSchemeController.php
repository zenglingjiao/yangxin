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
use Modules\Admin\Services\purchaseScheme\PurchaseSchemeService;


class PurchaseSchemeController extends BaseAdminController
{

    public function index(PurchaseSchemeService $service)
    {
        $title = __('admin::controller.purchase_scheme');
        // $parent = $service->edit($id);
        // dd(111);

        return view('admin::purchase_scheme.index',compact('title'));
    }


    public function edit(int $id=0,Request $request,PurchaseSchemeService $service)
    {
        $title = __('admin::controller.purchase_scheme');
        $model = $service->edit($id);
        // var_dump($model);exit;

        return view('admin::purchase_scheme.edit',compact('title','model'));
    }

    public function list(CommonPageRequest $request, PurchaseSchemeService $service)
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
    public function update(Request $request, PurchaseSchemeService $service)
    {
        // return;
        return $service->update($request->get('id'), $request->only([
            'scenario_name',
            'type',
            'points',
            'original_price',
            'special_offer',
            'scenario_sort',
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
    public function status(Request $request, PurchaseSchemeService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

    //分店
    public function branch(int $sid=0,PurchaseSchemeService $service)
    {
        $title = __('admin::controller.branch');
        // $parent = $service->edit($id);


        return view('admin::purchase_scheme.branch',compact('title','sid'));
    }


    public function branch_list(CommonPageRequest $request, PurchaseSchemeService $service)
    {

        return $service->branch_list($request->only([
            'sid',
            'name',
            'limit',
        ]));
    }

    public function branchedit(int $sid=0,int $id=0,Request $request,PurchaseSchemeService $service)
    {
        $title = __('admin::controller.branch_edit');
        $model = $service->branch_edit($id);
        // var_dump($model);return;
        // $parent = $service->edit($pid);

        return view('admin::purchase_scheme.branch_edit',compact('title','model','sid'));
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
    public function branch_update(Request $request, PurchaseSchemeService $service)
    {
        // return;
        return $service->branch_update($request->get('id'), $request->only([
            //基本资料
            'branch_business_hours',
            'branch_name',
            'tel',
            'branch_city',
            'branch_district',
            'branch_address',
            'status',
            'store_id',
        ]));
    }

     //產業類別
    public function industry_category(int $id=0,PurchaseSchemeService $service)
    {
        $title = __('admin::controller.branch');
        // $parent = $service->edit($id);


        return view('admin::store.industry_category',compact('title'));
    }


    public function industry_category_list(CommonPageRequest $request, PurchaseSchemeService $service)
    {

        return $service->industry_category_list($request->only([
            'name',
            'limit',
        ]));
    }

    public function industry_category_edit(int $id=0,Request $request,PurchaseSchemeService $service)
    {
        $title = __('admin::controller.industry_category_edit');
        $model = $service->industry_category_edit($id);
        // var_dump($model);return;
        // $parent = $service->edit($request->input('pid',0));

        return view('admin::store.industry_category_edit',compact('title','model'));
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
    public function industry_category_update(Request $request, PurchaseSchemeService $service)
    {
        // return;
        return $service->industry_category_update($request->get('id'), $request->only([
            'name',
            'status',
        ]));
    }

}
