<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/22/022
 * Time: 16:10
 */

namespace Modules\Admin\Services\annexe;


use Modules\Admin\Models\AnnexeHot;
use Modules\Admin\Models\AnnexeHotData;
use Modules\Admin\Services\BaseAdminService;

class AnnexeHotService extends BaseAdminService
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
    public function list(array $data)
    {
        $model = AnnexeHot::query();

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
    public function add(array $data)
    {
        \DB::beginTransaction();
        try{
            $info = $data['info'];
            unset($data['info']);
            $data['created_at'] = date('Y-m-d H:i:s');
            $id = AnnexeHot::query()->insertGetId($data);
            foreach ($info as &$v){
                unset($v['id']);
                $v['hot_id'] = $id;
                $v['created_at'] = date('Y-m-d H:i:s');
            }
            AnnexeHotData::query()->insert($info);
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
    public function edit(int $id)
    {
        return AnnexeHot::with('info')->find($id);
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
    public function update(int $id, array $data)
    {
        \DB::beginTransaction();
        try{
            $info = $data['info'];
            unset($data['info']);
            $data['updated_at'] = date('Y-m-d H:i:s');
            AnnexeHot::query()->where('id',$id)->update($data);
            foreach ($info as $v){
                $id = $v['id'];
                unset($v['id']);
                $data['updated_at'] = date('Y-m-d H:i:s');
                AnnexeHotData::query()->where('id',$id)->update($v);
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
    public function del(array $ids)
    {

        $res = $this->commonDestroy(AnnexeHot::query(), $ids);
        AnnexeHotData::where('hot_id', $ids[0])->delete();
        return $res;

    }

}