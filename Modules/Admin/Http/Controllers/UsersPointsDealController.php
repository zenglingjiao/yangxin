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
use Modules\Admin\Services\UsersPointsDeal\UsersPointsDealService;


class UsersPointsDealController extends BaseAdminController
{

    public function index(UsersPointsDealService $service)
    {
        $title = __('admin::controller.users_points_deal');
        // $parent = $service->edit($id);

        return view('admin::users_points_deal.index',compact('title'));
    }

    public function list(CommonPageRequest $request, UsersPointsDealService $service)
    {

        return $service->list($request->only([
            'name',
            'limit',
        ]));
    }

     /**
     * @Name 調整狀態
     * @Interface status
     * @Notes
     * @param CommonStatusRequest $request
     * @return \Modules\Admin\Services\users_points_deal\JSON
      * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function status(Request $request, UsersPointsDealService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

}
