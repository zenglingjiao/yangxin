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
use Modules\Admin\Http\Requests\RoleAddRequest;
use Modules\Admin\Http\Requests\RoleUpdateRequest;
use Modules\Admin\Http\Requests\UploadRequest;
use Modules\Admin\Services\admin\AdminService;
use Modules\Admin\Http\Requests\CommonStatusRequest;


use Modules\Admin\Services\banner\BannerService;
use Modules\Admin\Services\group\GroupService;
use Modules\Admin\Services\role\RoleService;
use Modules\Admin\Services\upload\UploadService;

class UploadController extends BaseAdminController
{


    /**
     * @Name: 圖片上傳
     * @Route: upload
     * @Method: POST
     * @Author: chenji
     * @Time: 2021/12/17/017 17:45
     * @param UploadRequest $request
     * @param UploadService $service
     * @return \Modules\Common\Services\JSON
     */
    public function upload(UploadRequest $request,UploadService $service)
    {

        return $service->upload($request);
    }

}
