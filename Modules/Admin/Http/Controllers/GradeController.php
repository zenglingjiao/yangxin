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
use Modules\Admin\Services\annexe\AnnexeHotService;
use Modules\Admin\Services\grade\GradeService;
use Modules\Admin\Services\user\UserService;

class GradeController extends BaseAdminController
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
        $title = __('admin::controller.grade');


        return view('admin::grade.list',compact('title'));
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
    public function list( GradeService $service)
    {

        return $service->list();
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
    public function edit(int $id = 0, GradeService $service)
    {

        $title = __('admin::controller.grade_edit');
        $model = $id > 0 ? $service->edit($id) : null;

        return view('admin::grade.edit', compact('title', 'model'));
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
    public function update(Request $request, GradeService $service)
    {

        return $service->update($request->get('id'), $request->only([
            'name', 'img', 'up_type','up_exp','expiry_type','expiry_date',
            'keep',
            'exp_radio','exp_data',
            'point_radio','point_data',
            'freight_radio','freight_data',
            'discount_radio','discount_data',
        ]));
    }



}