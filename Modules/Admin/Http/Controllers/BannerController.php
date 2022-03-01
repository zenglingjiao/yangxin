<?php

namespace Modules\Admin\Http\Controllers;


use Illuminate\Http\Request;
use Modules\Admin\Http\Requests\BannerBigAddRequest;
use Modules\Admin\Http\Requests\BannerBigUpdateRequest;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Services\banner\BannerService;

/*
 * @Description
 * */
class BannerController extends BaseAdminController
{

    /**
     * @Name: 大Banner試圖
     * @Route: banner_big_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:37
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function big_list()
    {
        $title = __('admin::controller.banner_big_list');

        return view('admin::banners.big_list',compact('title'));
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
    public function get_big_list(CommonPageRequest $request,BannerService $service)
    {

        return $service->get_big_page_list($request->only([
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
    public function big_edit(int $id = 0,BannerService $service)
    {

        $title = __('admin::controller.banner_big_edit');
        $model = $id > 0 ? $service->bigEdit($id) : null;


        return view('admin::banners.big_edit', compact('title', 'model'));
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
    public function big_add(BannerBigAddRequest $request,BannerService $service)
    {

        return $service->bigAdd($request->only([
            'name', 'pc_img', 'phone_img', 'up_time', 'down_time', 'status','sort', 'jump_type', 'jump_url']));
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
    public function big_update(BannerBigUpdateRequest $request,BannerService $service)
    {

        return $service->bigUpdate($request->get('id'), $request->only([
            'name', 'pc_img', 'phone_img', 'sort', 'status', 'up_time','down_time', 'jump_type', 'jump_url'
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
    public function big_del(DelIdRequest $request,BannerService $service)
    {
        return $service->bigDel($request->get('ids'));
    }


    /**
     * @Name: Banner下方視圖
     * @Route: banner_below_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:46
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function below_list()
    {
        $title = __('admin::controller.banner_below_list');

        return view('admin::banners.below_list',compact('title'));
    }

    /**
     * @Name: Banner下方列表
     * @Route: banner_get_below_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:47
     * @param CommonPageRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function get_below_list(CommonPageRequest $request,BannerService $service)
    {

        return $service->get_below_page_list($request->only([
            'page',
            'limit',
            'name',
            'status',
            'up_time',
            'down_time',
        ]));
    }


    /**
     * @Name: Banner下方編輯視圖
     * @Route: banner_below_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:48
     * @param int $id
     * @param BannerService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function below_edit(int $id = 0,BannerService $service)
    {

        $title = __('admin::controller.banner_below_edit');
        $model = $id > 0 ? $service->belowEdit($id) : null;


        return view('admin::banners.below_edit', compact('title', 'model'));
    }


    /**
     * @Name: Banner下方添加
     * @Route: banner_below_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:49
     * @param BannerBigAddRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function below_add(Request $request,BannerService $service)
    {

        return $service->belowAdd($request->only([
            'name', 'info', 'up_time', 'down_time', 'status']));
    }


    /**
     * @Name: Banner下方編輯
     * @Route: banner_below_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:49
     * @param BannerBigUpdateRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function below_update(Request $request,BannerService $service)
    {

        return $service->belowUpdate($request->get('id'), $request->only([
            'name', 'info', 'status', 'up_time','down_time'
        ]));
    }


    /**
     * @Name: Banner下方刪除
     * @Route: banner_below_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:50
     * @param DelIdRequest $request
     * @param BannerService $service
     * @return \Modules\Common\Services\JSON
     */
    public function below_del(DelIdRequest $request,BannerService $service)
    {
        return $service->belowDel($request->get('ids'));
    }

    /**
     * @Name: 促銷廣告視圖
     * @Route: banner_sales_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:52
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function sales_list()
    {
        $title = __('admin::controller.banner_sales_list');

        return view('admin::banners.sales_list',compact('title'));
    }

    /**
     * @Name: 促銷廣告列表
     * @Route: banner_sales_get_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:54
     * @param CommonPageRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function get_sales_list(CommonPageRequest $request,BannerService $service)
    {

        return $service->get_sales_page_list($request->only([
            'page',
            'limit',
            'name',
            'status',
            'up_time',
            'down_time',
        ]));
    }


    /**
     * @Name: 促銷廣告編輯視圖
     * @Route: banner_sales_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:56
     * @param int $id
     * @param BannerService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function sales_edit(int $id = 0,BannerService $service)
    {

        $title = __('admin::controller.banner_sales_edit');
        $model = $id > 0 ? $service->salesEdit($id) : null;


        return view('admin::banners.sales_edit', compact('title', 'model'));
    }


    /**
     * @Name: 促銷廣告添加
     * @Route: banner_sales_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:58
     * @param BannerBigAddRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function sales_add(BannerBigAddRequest $request,BannerService $service)
    {

        return $service->salesAdd($request->only([
            'name', 'pc_img', 'phone_img', 'up_time', 'down_time', 'status','sort', 'jump_type', 'jump_url']));
    }


    /**
     * @Name: 促銷廣告更新
     * @Route: banner_sales_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:00
     * @param BannerBigUpdateRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function sales_update(BannerBigUpdateRequest $request,BannerService $service)
    {

        return $service->salesUpdate($request->get('id'), $request->only([
            'name', 'pc_img', 'phone_img', 'sort', 'status', 'up_time','down_time', 'jump_type', 'jump_url'
        ]));
    }


    /**
     * @Name: 促銷廣告刪除
     * @Route: banner_sales_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:01
     * @param DelIdRequest $request
     * @param BannerService $service
     * @return \Modules\Common\Services\JSON
     */
    public function sales_del(DelIdRequest $request,BannerService $service)
    {
        return $service->salesDel($request->get('ids'));
    }

    /**
     * @Name: 中間廣告視圖
     * @Route: banner_middle_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:02
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function middle_list()
    {
        $title = __('admin::controller.banner_middle_list');

        return view('admin::banners.middle_list',compact('title'));
    }

    /**
     * @Name: 中間廣告列表
     * @Route: banner_get_middle_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:03
     * @param CommonPageRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function get_middle_list(CommonPageRequest $request,BannerService $service)
    {

        return $service->get_middle_page_list($request->only([
            'page',
            'limit',
            'name',
            'status',
            'up_time',
            'down_time',
        ]));
    }


    /**
     * @Name: 中間廣告編輯視圖
     * @Route: banner_middle_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:05
     * @param int $id
     * @param BannerService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function middle_edit(int $id = 0,BannerService $service)
    {

        $title = __('admin::controller.banner_middle_edit');
        $model = $id > 0 ? $service->middleEdit($id) : null;


        return view('admin::banners.middle_edit', compact('title', 'model'));
    }


    /**
     * @Name: 中間廣告添加
     * @Route: banner_middle_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:09
     * @param BannerBigAddRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function middle_add(BannerBigAddRequest $request,BannerService $service)
    {

        return $service->middleAdd($request->only([
            'name', 'pc_img', 'phone_img', 'up_time', 'down_time', 'status','sort', 'jump_type', 'jump_url']));
    }


    /**
     * @Name: 中間廣告更新
     * @Route: banner_middle_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:11
     * @param BannerBigUpdateRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function middle_update(BannerBigUpdateRequest $request,BannerService $service)
    {

        return $service->middleUpdate($request->get('id'), $request->only([
            'name', 'pc_img', 'phone_img', 'sort', 'status', 'up_time','down_time', 'jump_type', 'jump_url'
        ]));
    }


    /**
     * @Name: 中間廣告刪除
     * @Route: banner_middle_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:13
     * @param DelIdRequest $request
     * @param BannerService $service
     * @return \Modules\Common\Services\JSON
     */
    public function middle_del(DelIdRequest $request,BannerService $service)
    {
        return $service->middleDel($request->get('ids'));
    }

    /**
     * @Name: 中間輪播廣告視圖
     * @Route: banner_middle_carousel_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:02
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function middle_carousel_list()
    {
        $title = __('admin::controller.banner_middle_carousel_list');

        return view('admin::banners.middle_carousel_list',compact('title'));
    }

    /**
     * @Name: 中間輪播廣告列表
     * @Route: banner_get_middle_carousel_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:03
     * @param CommonPageRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function get_middle_carousel_list(CommonPageRequest $request,BannerService $service)
    {

        return $service->get_middle_carousel_page_list($request->only([
            'page',
            'limit',
            'name',
            'status',
            'up_time',
            'down_time',
        ]));
    }


    /**
     * @Name: 中間輪播廣告編輯視圖
     * @Route: banner_middle_carousel_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 17:05
     * @param int $id
     * @param BannerService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function middle_carousel_edit(int $id = 0,BannerService $service)
    {

        $title = __('admin::controller.banner_middle_carousel_edit');
        $model = $id > 0 ? $service->middle_carouselEdit($id) : null;


        return view('admin::banners.middle_carousel_edit', compact('title', 'model'));
    }


    /**
     * @Name: 中間輪播廣告添加
     * @Route: banner_middle_carousel_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:09
     * @param BannerBigAddRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function middle_carousel_add(BannerBigAddRequest $request,BannerService $service)
    {

        return $service->middle_carouselAdd($request->only([
            'name', 'pc_img', 'phone_img', 'up_time', 'down_time', 'status','sort', 'jump_type', 'jump_url']));
    }


    /**
     * @Name: 中間輪播廣告更新
     * @Route: banner_middle_carousel_update
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:11
     * @param BannerBigUpdateRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function middle_carousel_update(BannerBigUpdateRequest $request,BannerService $service)
    {

        return $service->middle_carouselUpdate($request->get('id'), $request->only([
            'name', 'pc_img', 'phone_img', 'sort', 'status', 'up_time','down_time', 'jump_type', 'jump_url'
        ]));
    }



    /**
     * @Name: 中間輪播廣告刪除
     * @Route: banner_middle_carousel_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:13
     * @param DelIdRequest $request
     * @param BannerService $service
     * @return \Modules\Common\Services\JSON
     */
    public function middle_carousel_del(DelIdRequest $request,BannerService $service)
    {
        return $service->middle_carouselDel($request->get('ids'));
    }

    /**
     * @Name: 團購Banner視圖
     * @Route: banner_team_buy_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:37
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function team_buy_list()
    {
        $title = __('admin::controller.banner_team_buy_list');

        return view('admin::banners.team_buy_list',compact('title'));
    }

    /**
     * @Name: 團購Banner列表
     * @Route: banner_get_team_buy_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:39
     * @param CommonPageRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function get_team_buy_list(CommonPageRequest $request,BannerService $service)
    {

        return $service->get_team_buy_page_list($request->only([
            'page',
            'limit',
            'name',
            'status',
        ]));
    }


    /**
     * @Name: 團購Banner編輯視圖
     * @Route: banner_team_buy_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:40
     * @param int $id
     * @param BannerService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function team_buy_edit(int $id = 0,BannerService $service)
    {

        $title = __('admin::controller.banner_team_buy_edit');
        $model = $id > 0 ? $service->team_buyEdit($id) : null;


        return view('admin::banners.team_buy_edit', compact('title', 'model'));
    }


    /**
     * @Name: 團購Banner添加
     * @Route: banner_big_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:41
     * @param BannerBigAddRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function team_buy_add(BannerBigAddRequest $request,BannerService $service)
    {

        return $service->team_buyAdd($request->only([
            'name', 'pc_img', 'phone_img', 'up_time', 'down_time', 'status','sort', 'jump_type', 'jump_url']));
    }


    /**
     * @Name: 團購Banner編輯
     * @Route: banner_team_buy_edit
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:43
     * @param BannerBigUpdateRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function team_buy_update(BannerBigUpdateRequest $request,BannerService $service)
    {

        return $service->team_buyUpdate($request->get('id'), $request->only([
            'name', 'pc_img', 'phone_img', 'sort', 'status', 'up_time','down_time', 'jump_type', 'jump_url'
        ]));
    }


    /**
     * @Name: 團購Banner刪除
     * @Route: banner_team_buy_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:45
     * @param DelIdRequest $request
     * @param BannerService $service
     * @return \Modules\Common\Services\JSON
     */
    public function team_buy_del(DelIdRequest $request,BannerService $service)
    {
        return $service->team_buyDel($request->get('ids'));
    }


    /**
     * @Name: 紅利Banner視圖
     * @Route: banner_dividend_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:37
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function dividend_list()
    {
        $title = __('admin::controller.banner_dividend_list');

        return view('admin::banners.dividend_list',compact('title'));
    }

    /**
     * @Name: 紅利Banner列表
     * @Route: banner_get_dividend_list
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:39
     * @param CommonPageRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function get_dividend_list(CommonPageRequest $request,BannerService $service)
    {

        return $service->get_dividend_page_list($request->only([
            'page',
            'limit',
            'name',
            'status',
        ]));
    }


    /**
     * @Name: 紅利Banner編輯視圖
     * @Route: banner_dividend_edit
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:40
     * @param int $id
     * @param BannerService $service
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function dividend_edit(int $id = 0,BannerService $service)
    {

        $title = __('admin::controller.banner_dividend_edit');
        $model = $id > 0 ? $service->dividendEdit($id) : null;


        return view('admin::banners.dividend_edit', compact('title', 'model'));
    }


    /**
     * @Name: 紅利Banner添加
     * @Route: banner_big_add
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:41
     * @param BannerBigAddRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function dividend_add(BannerBigAddRequest $request,BannerService $service)
    {

        return $service->dividendAdd($request->only([
            'name', 'pc_img', 'phone_img', 'up_time', 'down_time', 'status','sort', 'jump_type', 'jump_url']));
    }


    /**
     * @Name: 紅利Banner編輯
     * @Route: banner_dividend_edit
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:43
     * @param BannerBigUpdateRequest $request
     * @param BannerService $service
     * @return \Modules\Admin\Services\banner\JSON
     */
    public function dividend_update(BannerBigUpdateRequest $request,BannerService $service)
    {

        return $service->dividendUpdate($request->get('id'), $request->only([
            'name', 'pc_img', 'phone_img', 'sort', 'status', 'up_time','down_time', 'jump_type', 'jump_url'
        ]));
    }


    /**
     * @Name: 紅利Banner刪除
     * @Route: banner_dividend_del
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 16:45
     * @param DelIdRequest $request
     * @param BannerService $service
     * @return \Modules\Common\Services\JSON
     */
    public function dividend_del(DelIdRequest $request,BannerService $service)
    {
        return $service->dividendDel($request->get('ids'));
    }

    public function kayou()
    {


        $title = __('admin::controller.banner_kayou');


        return view('admin::banners.kayou_list', compact('title'));
    }

    public function kayouList(Request $request, BannerService $service)
    {

        return $service->kayouList($request->only([
            'page',
            'limit',
            'name',
            'type',
            'status',
            'up_time',
            'down_time',
        ]));
    }

    public function kayouUpdate(Request $request, BannerService $service)
    {

        return $service->kayouUpdate($request->get('id'),
            $request->only(['name', 'pc_img', 'phone_img', 'up_time', 'down_time', 'jump_type', 'jump_url']));
    }

    public function kayouDel(DelIdRequest $request, BannerService $service)
    {

        return $service->kayouDel($request->get('ids'));
    }

    public function middle_activity()
    {


        $title = __('admin::controller.banner_middle_activity');


        return view('admin::banners.middle_activity_list', compact('title'));
    }

    public function middle_activityList(Request $request, BannerService $service)
    {

        return $service->middle_activityList($request->only([
            'page',
            'limit',
            'name',
            'status',
            'up_time',
            'down_time',
        ]));
    }

    public function middle_activityUpdate(Request $request, BannerService $service)
    {

        return $service->middle_activityUpdate($request->get('id'),
            $request->only(['name', 'pc_img', 'phone_img', 'up_time', 'down_time', 'jump_type', 'jump_url']));
    }

    public function middle_activityDel(DelIdRequest $request, BannerService $service)
    {

        return $service->middle_activityDel($request->get('ids'));
    }

    /**
     * @Name: 大Banner試圖
     * @Route: banner_big_list
     * @Method: GET
     * @Author: chenji
     * @Time: 2021/12/17/017 16:37
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function member()
    {
        $title = __('admin::controller.banner_member_list');

        return view('admin::banners.member_list',compact('title'));
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
    public function memberList(CommonPageRequest $request,BannerService $service)
    {

        return $service->memberList($request->only([
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
    public function memberEdit(int $id = 0,BannerService $service)
    {

        $title = __('admin::controller.banner_member_edit');
        $model = $id > 0 ? $service->memberEdit($id) : null;


        return view('admin::banners.member_edit', compact('title', 'model'));
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
    public function memberAdd(Request $request,BannerService $service)
    {
        return $service->memberAdd($request->only([
            'name', 'info', 'up_time', 'down_time', 'status', 'jump_type', 'jump_url']));
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
    public function memberUpdate(Request $request,BannerService $service)
    {

        return $service->memberUpdate($request->get('id'), $request->only([
            'name', 'pc_img', 'phone_img', 'sort', 'status', 'up_time','down_time', 'jump_type', 'jump_url'
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
    public function memberDel(DelIdRequest $request,BannerService $service)
    {
        return $service->memberDel($request->get('ids'));
    }







}
