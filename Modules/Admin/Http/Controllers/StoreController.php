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
use Modules\Admin\Services\store\StoreService;


class StoreController extends BaseAdminController
{

    public function index(int $id=0,StoreService $service)
    {
        $title = __('admin::controller.store');
        // $parent = $service->edit($id);


        return view('admin::store.index',compact('title'));
    }


    public function edit(int $id=0,Request $request,StoreService $service)
    {
        $title = __('admin::controller.store_edit');
        $model = $service->edit($id);
        // var_dump($model);exit;
        $industry_category = $service->industry_category_all([]);

        return view('admin::store.edit',compact('title','model','industry_category'));
    }

    public function list(CommonPageRequest $request, StoreService $service)
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
    public function update(Request $request, StoreService $service)
    {
        // return;
        return $service->update($request->get('id'), $request->only([
            //基本资料
            'company_name',
            'tax_id',
            'reg_city',
            'reg_district',
            'reg_address',
            'same_reg',
            'corp_city',
            'corp_district',
            'corp_address',
            'company_websites',
            'people',
            'have_branch',
            'branch_num',
            'same_corp_name',
            'corporate_brand',
            'company_profile',
            'industry_category_id',
            //负责人资料
            'principal',
            'liaisons_name',
            'liaisons_tel',
            'company_tel',
            'liaisons_mail',
            'bank_code',
            'branch_bank',
            'bank_accounts',
            'bank_username',
            'store_logo',
            'bankbook',
            'identity_card_obverse',
            'identity_card_reverse',
            'business_registration_certificate',
            'business_hours',
            'buy_power',
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
    public function status(Request $request, StoreService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

    //分店
    public function branch(int $pid=0,StoreService $service)
    {
        $title = __('admin::controller.branch');
        // $parent = $service->edit($id);


        return view('admin::store.branch',compact('title','pid'));
    }


    public function branch_list(CommonPageRequest $request, StoreService $service)
    {

        return $service->branch_list($request->only([
            'pid',
            'name',
            'limit',
        ]));
    }

    public function branchedit(int $pid=0,int $id=0,Request $request,StoreService $service)
    {
        $title = __('admin::controller.branch_edit');
        $model = $service->branch_edit($id);
        // var_dump($model);return;
        $parent = $service->edit($pid);

        return view('admin::store.branch_edit',compact('title','model','pid','parent'));
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
    public function branch_update(Request $request, StoreService $service)
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
    public function industry_category(int $id=0,StoreService $service)
    {
        $title = __('admin::controller.branch');
        // $parent = $service->edit($id);


        return view('admin::store.industry_category',compact('title'));
    }


    public function industry_category_list(CommonPageRequest $request, StoreService $service)
    {

        return $service->industry_category_list($request->only([
            'name',
            'limit',
        ]));
    }

    public function industry_category_edit(int $id=0,Request $request,StoreService $service)
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
    public function industry_category_update(Request $request, StoreService $service)
    {
        // return;
        return $service->industry_category_update($request->get('id'), $request->only([
            'name',
            'status',
        ]));
    }

}
