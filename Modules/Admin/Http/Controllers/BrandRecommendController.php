<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Modules\Admin\Http\Requests\AdminAddRequest;
use Modules\Admin\Http\Requests\AdminUpdateRequest;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Http\Requests\GroupAddRequest;
use Modules\Admin\Http\Requests\GroupUpdateRequest;
use Modules\Admin\Http\Requests\NaviRequest;
use Modules\Admin\Http\Requests\RoleAddRequest;
use Modules\Admin\Http\Requests\RoleUpdateRequest;
use Modules\Admin\Http\Requests\UploadRequest;
use Modules\Admin\Services\admin\AdminService;
use Modules\Admin\Http\Requests\CommonStatusRequest;


use Modules\Admin\Services\banner\BannerService;
use Modules\Admin\Services\brand\BrandRecommendService;
use Modules\Admin\Services\group\GroupService;
use Modules\Admin\Services\navi\NaviService;
use Modules\Admin\Services\role\RoleService;
use Modules\Admin\Services\upload\UploadService;

class BrandRecommendController extends BaseAdminController
{



    public function index()
    {

        $title = __('admin::controller.brand_recommend');

        return view('admin::brand.brand_recommend_list', compact('title'));
    }

    public function list(Request $request,BrandRecommendService $service){

        return $service->list($request->only([
            'page',
            'limit',
            'name',
            'status',
        ]));
    }

    public function update(Request $request,BrandRecommendService $service){

        return $service->update($request->get('id'),$request->only(['brand_id','status','sort']));
    }

    public function del(DelIdRequest $request,BrandRecommendService $service){

        return $service->del($request->get('ids'));
    }

}
