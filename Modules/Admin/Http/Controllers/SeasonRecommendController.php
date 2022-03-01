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
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Services\seasonRecommend\SeasonRecommendService;


class SeasonRecommendController extends BaseAdminController
{
    /**
     * @Name: 大Banner試圖
     * @Route: banner_big_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:37
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $title = __('admin::controller.season_recommend_list');

        return view('admin::season_recommend.list',compact('title'));
    }

    /**
     * @Name: 大Banner列表
     * @Route: banner_get_big_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:39
     * @param CommonPageRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function list(CommonPageRequest $request, SeasonRecommendService $service)
    {
        return $service->list($request->only([
            'page',
            'limit',
            'name',
            'status',
            'up_time',
            'down_time',
        ]));
    }


    /**
     * @Name: 大Banner編輯視圖
     * @Route: banner_big_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:40
     * @param int $id
     * @param BannerService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(int $id = 0, SeasonRecommendService $service)
    {

        $title = __('admin::controller.season_recommend_edit');
        $model = $id > 0 ? $service->edit($id) : null;


        return view('admin::season_recommend.edit', compact('title', 'model'));
    }


    /**
     * @Name: 大Banner添加
     * @Route: banner_big_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:41
     * @param BannerBigAddRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function add(Request $request, SeasonRecommendService $service)
    {
        return $service->add($request->only([
            'name', 'info', 'up_time', 'down_time', 'status',]));
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
    public function update(Request $request, SeasonRecommendService $service)
    {

        return $service->update($request->get('id'), $request->only([
            'name', 'info', 'status'
        ]));
    }


    /**
     * @Name: 大Banner刪除
     * @Route: banner_big_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:45
     * @param DelIdRequest $request
     * @param BannerService $service
     * @return \Modules\Common\Services\JSON
     */
    public function del(DelIdRequest $request, SeasonRecommendService $service)
    {
        return $service->del($request->get('ids'));
    }


}