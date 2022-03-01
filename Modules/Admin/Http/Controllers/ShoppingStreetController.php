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
use Modules\Admin\Services\shoppingStreet\ShoppingStreetService;


class ShoppingStreetController extends BaseAdminController
{

    public function index(ShoppingStreetService $service)
    {
        $title = __('admin::controller.shopping_street');
        // $parent = $service->edit($id);
        // dd(111);

        return view('admin::shopping_street.index',compact('title'));
    }


    public function edit(int $id=0,Request $request,ShoppingStreetService $service)
    {
        $title = __('admin::controller.shopping_street');
        $model = $service->edit($id);
        // var_dump($model);exit;

        return view('admin::shopping_street.edit',compact('title','model'));
    }

    public function list(CommonPageRequest $request, ShoppingStreetService $service)
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
    public function update(Request $request, ShoppingStreetService $service)
    {
        // return;
        return $service->update($request->get('id'), $request->only([
            //基本资料
            'shopping_street_name',
            'reg_city',
            'reg_district',
            'reg_address',
            'store_num',
            'sketch',
            //负责人资料
            'principal',
            'liaisons_name',
            'liaisons_tel',
            'shopping_street_tel',
            'liaisons_mail',
            'business_hours',
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
    public function status(Request $request, ShoppingStreetService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

    //分店
    public function branch(int $sid=0,ShoppingStreetService $service)
    {
        $title = __('admin::controller.branch');
        // $parent = $service->edit($id);


        return view('admin::shopping_street.branch',compact('title','sid'));
    }


    public function branch_list(CommonPageRequest $request, ShoppingStreetService $service)
    {

        return $service->branch_list($request->only([
            'sid',
            'name',
            'limit',
        ]));
    }

    public function branchedit(int $sid=0,int $id=0,Request $request,ShoppingStreetService $service)
    {
        $title = __('admin::controller.branch_edit');
        $model = $service->branch_edit($id);
        // var_dump($model);return;
        // $parent = $service->edit($pid);

        return view('admin::shopping_street.branch_edit',compact('title','model','sid'));
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
    public function branch_update(Request $request, ShoppingStreetService $service)
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
    public function industry_category(int $id=0,ShoppingStreetService $service)
    {
        $title = __('admin::controller.branch');
        // $parent = $service->edit($id);


        return view('admin::store.industry_category',compact('title'));
    }


    public function industry_category_list(CommonPageRequest $request, ShoppingStreetService $service)
    {

        return $service->industry_category_list($request->only([
            'name',
            'limit',
        ]));
    }

    public function industry_category_edit(int $id=0,Request $request,ShoppingStreetService $service)
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
    public function industry_category_update(Request $request, ShoppingStreetService $service)
    {
        // return;
        return $service->industry_category_update($request->get('id'), $request->only([
            'name',
            'status',
        ]));
    }

}
