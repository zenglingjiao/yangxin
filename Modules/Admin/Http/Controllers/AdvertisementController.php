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


use Modules\Admin\Services\advertisement\AdvertisementService;
use Modules\Admin\Services\banner\BannerService;
use Modules\Admin\Services\brand\BrandService;
use Modules\Admin\Services\group\GroupService;
use Modules\Admin\Services\navi\NaviService;
use Modules\Admin\Services\role\RoleService;
use Modules\Admin\Services\upload\UploadService;

class AdvertisementController extends BaseAdminController
{


    public function index($type)
    {
        if (!in_array($type, ['up', 'down'])) {
            abort(404);
        }

        $title = __('admin::controller.advertisement');


        return view('admin::advertisement.index', compact('title', 'type'));
    }

    public function list(Request $request, AdvertisementService $service)
    {

        return $service->list($request->only([
            'page',
            'limit',
            'name',
            'type',
            'status',
            'up_time',
            'down_time',
        ]));
    }

    public function update(Request $request, AdvertisementService $service)
    {

        return $service->update($request->get('id'),
            $request->only(['name', 'type', 'pc_img', 'phone_img', 'up_time', 'down_time', 'jump_type', 'jump_url']));
    }

    public function del(DelIdRequest $request, AdvertisementService $service)
    {

        return $service->del($request->get('ids'));
    }


}
