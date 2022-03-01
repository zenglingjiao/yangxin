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
use Modules\Admin\Services\classify\ClassifyService;


class ClassifyController extends BaseAdminController
{

    public function index(int $id=0,ClassifyService $service)
    {
        $title = __('admin::controller.classify');
        $parent = $service->edit($id);


        return view('admin::classify.index',compact('title','parent'));
    }


    public function add(Request $request,ClassifyService $service)
    {
        $title = __('admin::controller.classify_edit');
        $parent = $service->edit($request->input('pid',0));

        return view('admin::classify.add',compact('title','parent'));
    }

    public function edit(int $id=0,Request $request,ClassifyService $service)
    {
        $title = __('admin::controller.classify_edit');
        $model = $service->edit($id);
        $parent = $service->edit($request->input('pid',0));

        return view('admin::classify.edit',compact('title','model','parent'));
    }

    public function list(CommonPageRequest $request, ClassifyService $service)
    {

        return $service->list($request->only([
            'page',
            'limit',
            'status',
            'start_time',
            'end_time',
            'pid',
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
    public function update(Request $request, ClassifyService $service)
    {
        return $service->update($request->get('id'), $request->only([
            'name', 'img','sort','status',
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
    public function create(Request $request, ClassifyService $service)
    {
        return $service->add($request->only([
            'name', 'img','sort','status','pid','brands'
        ]));
    }



}