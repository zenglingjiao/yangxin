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
use Modules\Admin\Services\bank\ClassifyService;
use Modules\Admin\Services\grade\GradeService;
use Modules\Admin\Services\user\UserService;

class BankDividendController extends BaseAdminController
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
        $title = __('admin::controller.bank_dividend_list');


        return view('admin::bank.dividend_list',compact('title'));
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
    public function list(CommonPageRequest $request, ClassifyService $service)
    {

        return $service->list($request->only([
            'page',
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
    public function update(Request $request, ClassifyService $service)
    {

        return $service->update($request->get('id'), $request->only([
            'name', 'pc_name', 'phone_img','remark','sort','status',
        ]));
    }



}