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
use Modules\Admin\Services\PointsGrant\PointsGrantService;


class PointsGrantController extends BaseAdminController
{

    public function index(PointsGrantService $service)
    {
        $title = __('admin::controller.points_grant');
        // $parent = $service->edit($id);

        return view('admin::points_grant.index',compact('title'));
    }

    public function list(CommonPageRequest $request, PointsGrantService $service)
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
     * @return \Modules\Admin\Services\points_grant\JSON
      * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function status(Request $request, PointsGrantService $service)
    {
        return  $service->status($request->get('id'), $request->only(['status']));
    }

}
