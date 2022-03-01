<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\welcomePage;


use Modules\Admin\Models\AuthAdmin;
use Modules\Admin\Models\BannerBelow;
use Modules\Admin\Models\BannerBig;
use Modules\Admin\Models\BannerMiddle;
use Modules\Admin\Models\BannerMiddleCarousel;
use Modules\Admin\Models\BannerSales;
use Modules\Admin\Models\WelcomePage;
use Modules\Admin\Services\BaseAdminService;
use Modules\Admin\Services\group\GroupService;
use phpDocumentor\Reflection\DocBlock;

class WelcomeService extends BaseAdminService
{
    /**
     * @name 歡迎頁列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.name String 名称
     * @param data.status Int 狀態:0=关闭,1=啟用
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function getAppList(array $data)
    {
        $model = WelcomePage::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);


        $model->where('type', 1);
        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    /**
     * @name 歡迎頁添加
     * @description
     * @param data Array 添加數據
     * @param data.name String 名稱
     * @param data.phone_img String 圖片
     * @param data.up_time String 上架時間
     * @param data.down_time String 下架時間
     * @param data.status int 狀態
     * @param data.type int 類型（1：歡迎頁  2：廣告）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function appAdd(array $data)
    {
        return $this->commonCreate(WelcomePage::query(), $data);
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int 管理員id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function appEdit(int $id)
    {
        return WelcomePage::find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param id int
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.phone_img String 圖片
     * @param data.up_time String 上架時間
     * @param data.down_time String 下架時間
     * @param data.status int 狀態
     * @param data.type int 類型（1：歡迎頁  2：廣告）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function appUpdate(int $id, array $data)
    {
        return $this->commonUpdate(WelcomePage::query(), $id, $data);

    }

    /**
     * @Notes:
     * @Name 刪除
     * @Interface del
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function appDel(array $ids)
    {

        return $this->commonDestroy(WelcomePage::query(), $ids);
    }

    /**
     * @name 廣告列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.name String 名称
     * @param data.status Int 狀態:0=关闭,1=啟用
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function getAdList(array $data)
    {
        $model = WelcomePage::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);

        $model->where('type', 2);
        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }


        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    /**
     * @name 添加
     * @description
     * @param data Array 添加數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖片
     * @param data.phone_img String 手機圖片
     * @param data.up_time String 上架時間
     * @param data.down_time String 下架時間
     * @param data.status int 狀態
     * @param data.jump_type int 操作
     * @param data.jump_url string 操作url
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function adAdd(array $data)
    {
        return $this->commonCreate(WelcomePage::query(), $data);
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function adEdit(int $id)
    {
        return WelcomePage::find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖片
     * @param data.phone_img String 手機圖片
     * @param data.up_time String 上架時間
     * @param data.down_time String 下架時間
     * @param data.status int 狀態
     * @param data.jump_type int 操作
     * @param data.jump_url string 操作url
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function adUpdate(int $id, array $data)
    {
        return $this->commonUpdate(WelcomePage::query(), $id, $data);

    }


    /**
     * @Notes:
     * @Name 刪除
     * @Interface del
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function adDel(array $ids)
    {

        return $this->commonDestroy(WelcomePage::query(), $ids);
    }


}
