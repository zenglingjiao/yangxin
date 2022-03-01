<?php
/**
 * @Name  日誌記錄服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/23 10:18
 */

namespace Modules\Admin\Services\upload;



use Modules\Admin\Services\BaseAdminService;

class UploadService extends BaseAdminService
{

    /**
     * @Name: 圖片上傳
     * @Author: chenji
     * @Time: 2021/12/18/018 16:23
     * @param object $request
     * @return \Modules\Common\Services\JSON
     */
    public function upload(object $request)
    {
        $path = $request->file('file')->store('admin');
        $path = env("UPLOAD_DIR").$path;
        return $this->apiSuccess('',['path'=>$path,'field'=>$request->post('field')]);
    }


}
