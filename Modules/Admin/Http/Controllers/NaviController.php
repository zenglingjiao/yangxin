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
use Modules\Admin\Services\group\GroupService;
use Modules\Admin\Services\navi\NaviService;
use Modules\Admin\Services\role\RoleService;
use Modules\Admin\Services\upload\UploadService;

class NaviController extends BaseAdminController
{



    public function index()
    {

        $title = __('admin::controller.navi_list');


        return view('admin::navi.index', compact('title'));
    }

    public function list(NaviService $service){

        return $service->list();
    }

    public function update(NaviRequest $request,NaviService $service){

        return $service->update($request->get('id'),$request->only(['name','sort','type','jump_type','jump_url']));
    }

    public function del(DelIdRequest $request,NaviService $service){

        return $service->del($request->get('ids'));
    }

}
