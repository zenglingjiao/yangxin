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
use Modules\Admin\Services\user\UserService;

class UserController extends BaseAdminController
{
    /**
     * @Name: 大Banner試圖
     * @Route: banner_big_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:37
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(UserService $service)
    {
        $title = __('admin::controller.user');
        $register_way_list = $service->getRegisterWayList();
        $grade_id_list = $service->getGradeIdList();

        return view('admin::user.list',compact('title','register_way_list','grade_id_list'));
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
    public function list(CommonPageRequest $request, UserService $service)
    {

        return $service->list($request->only([
            'page',
            'limit',
            'name',
            'status',
            'start_time',
            'end_time',
            'is_yangxin',
            'register_way',
            'is_group_lord',
            'grade_id',
            'is_say',
            'is_epaper',
            'phone',
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
    public function edit(int $id = 0,Request $request, UserService $service)
    {

        $title = __('admin::controller.user_edit');
        $model = $id > 0 ? $service->edit($id) : null;
        $flag = $request->get('flag','1');

        return view('admin::user.edit', compact('title', 'model','flag'));
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
    public function add()
    {
        $title = __('admin::controller.user_add');
        return view('admin::user.add', compact('title'));
    }

    public function create(Request $request, UserService $service)
    {
        return $service->create($request->only([
            'name', 'phone', 'sex', 'birth', 'grade_id','member_expiry_date',
            'status','is_group_lord','is_say','remark']));
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
    public function update(Request $request, UserService $service)
    {

        return $service->update($request->get('id'), $request->only([
            'name', 'sex', 'birth','is_epaper','grade_id','member_expiry_date',
            'inviter_code','status','is_group_lord','is_say','remark'
        ]));
    }

    public function updatePhone(Request $request,UserService $service){
        return $service->updatePhone($request->get('id'),$request->only(['phone','code']));
    }

    public function updateEmail(Request $request,UserService $service){
        return $service->updateEmail($request->get('id'),$request->only(['email','code']));
    }

    public function updatePassword(Request $request,UserService $service){
        return $service->updatePassword($request->get('id'),$request->only(['password']));
    }




}