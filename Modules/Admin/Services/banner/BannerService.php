<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\banner;


use Illuminate\Database\QueryException;
use Modules\Admin\Models\AuthAdmin;
use Modules\Admin\Models\BannerBelow;
use Modules\Admin\Models\BannerBelowData;
use Modules\Admin\Models\BannerBig;
use Modules\Admin\Models\BannerDividend;
use Modules\Admin\Models\BannerKayou;
use Modules\Admin\Models\BannerMember;
use Modules\Admin\Models\BannerMemberData;
use Modules\Admin\Models\BannerMiddle;
use Modules\Admin\Models\BannerMiddleActivity;
use Modules\Admin\Models\BannerMiddleCarousel;
use Modules\Admin\Models\BannerSales;
use Modules\Admin\Models\BannerTeamBuy;
use Modules\Admin\Services\BaseAdminService;
use Modules\Admin\Services\group\GroupService;

class BannerService extends BaseAdminService
{
    /**
     * @name 大banner列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.name String 名称
     * @param data.up_time Int 上架时间
     * @param data.down_time int 下架时间
     * @param data.status Int 狀態:0=关闭,1=啟用
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function get_big_page_list(array $data)
    {
        $model = BannerBig::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $up_time = mb_strlen(trim(isset($data['up_time']) ?: "")) == 0 ? "" : trim($data['up_time']);
        $down_time = mb_strlen(trim(isset($data['down_time']) ?: "")) == 0 ? "" : trim($data['down_time']);

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        if ($up_time != "") {
            $model = $model->where('up_time', '>=', $up_time);
        }

        if ($down_time != "") {
            $model = $model->where('down_time', '<=', $down_time);
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
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function bigAdd(array $data)
    {
        return $this->commonCreate(BannerBig::query(), $data);
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function bigEdit(int $id)
    {
        return BannerBig::find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param id int ID
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function bigUpdate(int $id, array $data)
    {
        return $this->commonUpdate(BannerBig::query(), $id, $data);

    }

    /**
     * @name 調整狀態
     * @description
     * @param data Array 調整數據
     * @param id Int id
     * @param data.status Int 狀態（0或1）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:06
     */
    public function bigStatus(int $id, array $data)
    {
        return $this->commonStatusUpdate(BannerBig::query(), $id, $data);
    }


    /**
     * @Notes:
     * @Name 刪除管理員
     * @Interface del
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function bigDel(array $ids)
    {

        return $this->commonDestroy(BannerBig::query(), $ids);
    }

    /**
     * @name banner下方列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.name String 名称
     * @param data.up_time Int 上架时间
     * @param data.down_time int 下架时间
     * @param data.status Int 狀態:0=关闭,1=啟用
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function get_below_page_list(array $data)
    {
        $model = BannerBelow::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $up_time = mb_strlen(trim(isset($data['up_time']) ?: "")) == 0 ? "" : trim($data['up_time']);
        $down_time = mb_strlen(trim(isset($data['down_time']) ?: "")) == 0 ? "" : trim($data['down_time']);

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        if ($up_time != "") {
            $model = $model->where('up_time', '>=', $up_time);
        }

        if ($down_time != "") {
            $model = $model->where('down_time', '<=', $down_time);
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
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function belowAdd(array $data)
    {
        \DB::beginTransaction();
        try{
            $info = $data['info'];
            unset($data['info']);
            $data['created_at'] = date('Y-m-d H:i:s');
            $id = BannerBelow::query()->insertGetId($data);
            foreach ($info as &$v){
                unset($v['id']);
                $v['below_id'] = $id;
                $v['created_at'] = date('Y-m-d H:i:s');
            }
            BannerBelowData::query()->insert($info);
            \DB::commit();
        }catch (QueryException $exception) {
            \DB::rollback();
            $this->webError($exception->getMessage());
        }

        return $this->apiSuccess();
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function belowEdit(int $id)
    {
        return BannerBelow::with('info')->find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param $id int ID
     * @param $data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function belowUpdate(int $id, array $data)
    {
        \DB::beginTransaction();
        try{
            $info = $data['info'];
            unset($data['info']);
            $data['updated_at'] = date('Y-m-d H:i:s');
            BannerBelow::query()->where('id',$id)->update($data);
            foreach ($info as $v){
                $id = $v['id'];
                unset($v['id']);
                $data['updated_at'] = date('Y-m-d H:i:s');
                BannerBelowData::query()->where('id',$id)->update($v);
            }
            \DB::commit();
        }catch (\Exception $exception){
            \DB::rollback();
            $this->webError($exception->getMessage());
        }
        return $this->apiSuccess();

    }

    /**
     * @name 調整狀態
     * @description
     * @param data Array 調整數據
     * @param id Int id
     * @param data.status Int 狀態（0或1）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:06
     */
    public function belowStatus(int $id, array $data)
    {
        return $this->commonStatusUpdate(BannerBelow::query(), $id, $data);
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
    public function belowDel(array $ids)
    {

        return $this->commonDestroy(BannerBelow::query(), $ids);
    }

    /**
     * @name 促銷廣告列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.name String 名称
     * @param data.up_time Int 上架时间
     * @param data.down_time int 下架时间
     * @param data.status Int 狀態:0=关闭,1=啟用
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function get_sales_page_list(array $data)
    {
        $model = BannerSales::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $up_time = mb_strlen(trim(isset($data['up_time']) ?: "")) == 0 ? "" : trim($data['up_time']);
        $down_time = mb_strlen(trim(isset($data['down_time']) ?: "")) == 0 ? "" : trim($data['down_time']);

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        if ($up_time != "") {
            $model = $model->where('up_time', '>=', $up_time);
        }

        if ($down_time != "") {
            $model = $model->where('down_time', '<=', $down_time);
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
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function salesAdd(array $data)
    {
        return $this->commonCreate(BannerSales::query(), $data);
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function salesEdit(int $id)
    {
        return BannerSales::find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function salesUpdate(int $id, array $data)
    {
        return $this->commonUpdate(BannerSales::query(), $id, $data);

    }

    /**
     * @name 調整狀態
     * @description
     * @param data Array 調整數據
     * @param id Int id
     * @param data.status Int 狀態（0或1）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:06
     */
    public function salesStatus(int $id, array $data)
    {
        return $this->commonStatusUpdate(BannerSales::query(), $id, $data);
    }


    /**
     * @Notes:
     * @Name 刪除促銷廣告
     * @Interface del
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function salesDel(array $ids)
    {

        return $this->commonDestroy(BannerSales::query(), $ids);
    }

    /**
     * @name 中間廣告列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.name String 名称
     * @param data.up_time Int 上架时间
     * @param data.down_time int 下架时间
     * @param data.status Int 狀態:0=关闭,1=啟用
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function get_middle_page_list(array $data)
    {
        $model = BannerMiddle::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $up_time = mb_strlen(trim(isset($data['up_time']) ?: "")) == 0 ? "" : trim($data['up_time']);
        $down_time = mb_strlen(trim(isset($data['down_time']) ?: "")) == 0 ? "" : trim($data['down_time']);

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        if ($up_time != "") {
            $model = $model->where('up_time', '>=', $up_time);
        }

        if ($down_time != "") {
            $model = $model->where('down_time', '<=', $down_time);
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
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function middleAdd(array $data)
    {
        return $this->commonCreate(BannerMiddle::query(), $data);
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function middleEdit(int $id)
    {
        return BannerMiddle::find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function middleUpdate(int $id, array $data)
    {
        return $this->commonUpdate(BannerMiddle::query(), $id, $data);

    }

    /**
     * @name 調整狀態
     * @description
     * @param data Array 調整數據
     * @param id Int id
     * @param data.status Int 狀態（0或1）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:06
     */
    public function middleStatus(int $id, array $data)
    {
        return $this->commonStatusUpdate(BannerMiddle::query(), $id, $data);
    }


    /**
     * @Notes:
     * @Name 刪除中間廣告
     * @Interface del
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function middleDel(array $ids)
    {

        return $this->commonDestroy(BannerMiddle::query(), $ids);
    }

    /**
     * @name 中間輪播廣告列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.name String 名称
     * @param data.up_time Int 上架时间
     * @param data.down_time int 下架时间
     * @param data.status Int 狀態:0=关闭,1=啟用
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function get_middle_carousel_page_list(array $data)
    {
        $model = BannerMiddleCarousel::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $up_time = mb_strlen(trim(isset($data['up_time']) ?: "")) == 0 ? "" : trim($data['up_time']);
        $down_time = mb_strlen(trim(isset($data['down_time']) ?: "")) == 0 ? "" : trim($data['down_time']);

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        if ($up_time != "") {
            $model = $model->where('up_time', '>=', $up_time);
        }

        if ($down_time != "") {
            $model = $model->where('down_time', '<=', $down_time);
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
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function middle_carouselAdd(array $data)
    {
        return $this->commonCreate(BannerMiddleCarousel::query(), $data);
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function middle_carouselEdit(int $id)
    {
        return BannerMiddleCarousel::find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function middle_carouselUpdate(int $id, array $data)
    {
        return $this->commonUpdate(BannerMiddleCarousel::query(), $id, $data);

    }

    /**
     * @name 調整狀態
     * @description
     * @param data Array 調整數據
     * @param id Int id
     * @param data.status Int 狀態（0或1）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:06
     */
    public function middle_carouselStatus(int $id, array $data)
    {
        return $this->commonStatusUpdate(BannerMiddleCarousel::query(), $id, $data);
    }


    /**
     * @Notes:
     * @Name 刪除中間輪播廣
     * @Interface del
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function middle_carouselDel(array $ids)
    {

        return $this->commonDestroy(BannerMiddleCarousel::query(), $ids);
    }

    /**
     * @name 團購banner列表
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
    public function get_team_buy_page_list(array $data)
    {
        $model = BannerTeamBuy::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);

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
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function team_buyAdd(array $data)
    {
        return $this->commonCreate(BannerTeamBuy::query(), $data);
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function team_buyEdit(int $id)
    {
        return BannerTeamBuy::find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param id int ID
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function team_buyUpdate(int $id, array $data)
    {
        return $this->commonUpdate(BannerTeamBuy::query(), $id, $data);

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
    public function team_buyDel(array $ids)
    {

        return $this->commonDestroy(BannerTeamBuy::query(), $ids);
    }

    /**
     * @name 紅利banner列表
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
    public function get_dividend_page_list(array $data)
    {
        $model = BannerDividend::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);

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
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function dividendAdd(array $data)
    {
        return $this->commonCreate(BannerDividend::query(), $data);
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function dividendEdit(int $id)
    {
        return BannerDividend::find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param id int ID
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function dividendUpdate(int $id, array $data)
    {
        return $this->commonUpdate(BannerDividend::query(), $id, $data);

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
    public function dividendDel(array $ids)
    {

        return $this->commonDestroy(BannerDividend::query(), $ids);
    }

    /**
     * @Name: 菜单列表
     * @Author: chenji
     * @Time: 2021/12/20/020 14:05
     * @return \Modules\Common\Services\JSON
     */
    public function kayouList(array $data)
    {

        $model = BannerKayou::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $up_time = mb_strlen(trim(isset($data['up_time']) ?: "")) == 0 ? "" : trim($data['up_time']);
        $down_time = mb_strlen(trim(isset($data['down_time']) ?: "")) == 0 ? "" : trim($data['down_time']);

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        if ($up_time != "") {
            $model = $model->where('up_time', '>=', $up_time);
        }

        if ($down_time != "") {
            $model = $model->where('down_time', '<=', $down_time);
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
     * @Name:  更新/添加菜单
     * @Author: chenji
     * @Time: 2021/12/20/020 14:06
     * @param int $id
     * @param array $data
     * @return \Modules\Common\Services\JSON
     * @throws \Modules\Common\Exceptions\AdminException
     */
    public function kayouUpdate(int $id,array $data){
        if ($id > 0){
            return $this->commonUpdate(BannerKayou::query(),$id,$data);
        }

        return $this->commonCreate(BannerKayou::query(),$data);

    }

    public function kayouDel(array $ids){

        return $this->commonDestroy(BannerKayou::query(),$ids);
    }

    /**
     * @Name: 菜单列表
     * @Author: chenji
     * @Time: 2021/12/20/020 14:05
     * @return \Modules\Common\Services\JSON
     */
    public function middle_activityList(array $data)
    {

        $model = BannerMiddleActivity::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $up_time = mb_strlen(trim(isset($data['up_time']) ?: "")) == 0 ? "" : trim($data['up_time']);
        $down_time = mb_strlen(trim(isset($data['down_time']) ?: "")) == 0 ? "" : trim($data['down_time']);

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        if ($up_time != "") {
            $model = $model->where('up_time', '>=', $up_time);
        }

        if ($down_time != "") {
            $model = $model->where('down_time', '<=', $down_time);
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
     * @Name:  更新/添加菜单
     * @Author: chenji
     * @Time: 2021/12/20/020 14:06
     * @param int $id
     * @param array $data
     * @return \Modules\Common\Services\JSON
     * @throws \Modules\Common\Exceptions\AdminException
     */
    public function middle_activityUpdate(int $id,array $data){
        if ($id > 0){
            return $this->commonUpdate(BannerMiddleActivity::query(),$id,$data);
        }

        return $this->commonCreate(BannerMiddleActivity::query(),$data);

    }

    public function middle_activityDel(array $ids){

        return $this->commonDestroy(BannerMiddleActivity::query(),$ids);
    }

    /**
     * @name 大banner列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.name String 名称
     * @param data.up_time Int 上架时间
     * @param data.down_time int 下架时间
     * @param data.status Int 狀態:0=关闭,1=啟用
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function memberList(array $data)
    {
        $model = BannerMember::query();

        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $up_time = mb_strlen(trim(isset($data['up_time']) ?: "")) == 0 ? "" : trim($data['up_time']);
        $down_time = mb_strlen(trim(isset($data['down_time']) ?: "")) == 0 ? "" : trim($data['down_time']);

        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            });

        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }

        if ($up_time != "") {
            $model = $model->where('up_time', '>=', $up_time);
        }

        if ($down_time != "") {
            $model = $model->where('down_time', '<=', $down_time);
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
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function memberAdd(array $data)
    {
        \DB::beginTransaction();
        try{
            $info = $data['info'];
            unset($data['info']);
            $id = BannerMember::query()->insertGetId($data);
            foreach ($info as &$v){
                unset($v['id']);
                $v['member_id'] = $id;
            }
            BannerMemberData::query()->insert($info);
            \DB::commit();
        }catch (QueryException $exception) {
            \DB::rollback();
            $this->webError($exception->getMessage());
        }

        return $this->apiSuccess();
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function memberEdit(int $id)
    {
        return BannerMember::with('info')->find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param id int ID
     * @param data Array 修改數據
     * @param data.name String 名稱
     * @param data.pc_img String 電腦圖
     * @param data.phone_img String 手機圖
     * @param data.up_time int 上架時間
     * @param data.down_time int 下架時間
     * @param data.status int 狀態
     * @param data.sort int 排序
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function memberUpdate(int $id, array $data)
    {
        \DB::beginTransaction();
        try{
            $info = $data['info'];
            unset($data['info']);
            $data['updated_at11'] = date('Y-m-d H:i:s');
            BannerMember::query()->where('id',$id)->update($data);
            foreach ($info as $v){
                $id = $v['id'];
                unset($v['id']);
                $data['updated_at'] = date('Y-m-d H:i:s');
                BannerMemberData::query()->where('id',$id)->update($v);
            }
            \DB::commit();
        }catch (\Exception $exception){
            \DB::rollback();
            $this->webError($exception->getMessage());
        }
        return $this->apiSuccess();

    }



    /**
     * @Notes:
     * @Name 刪除管理員
     * @Interface del
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function memberDel(array $ids)
    {

        $res = $this->commonDestroy(BannerMember::query(), $ids);
        BannerMemberData::where('member_id', $ids[0])->delete();
        return $res;

    }




}
