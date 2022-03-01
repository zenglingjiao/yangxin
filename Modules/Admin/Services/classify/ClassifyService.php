<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/22/022
 * Time: 16:10
 */

namespace Modules\Admin\Services\classify;


use Modules\Admin\Models\AnnexeHot;
use Modules\Admin\Models\AuthUser;
use Modules\Admin\Models\BankDividend;
use Modules\Admin\Models\Brand;
use Modules\Admin\Models\Classify;
use Modules\Admin\Models\Grade;
use Modules\Admin\Services\BaseAdminService;
use Cache;
use phpDocumentor\Reflection\DocBlock;

class ClassifyService extends BaseAdminService
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
        // $pid = $this->getValidParameter($data, 'pid');
        // if (empty($pid)) {
        //     $pid = 0;
        // }
        $name = $this->getValidParameter($data, 'name');
        $start_time = $this->getValidParameter($data, 'start_time');
        $end_time = $this->getValidParameter($data, 'end_time');
        $status = $this->getValidParameter($data, 'status');

        $model = Classify::where('id', 1);
        // var_dump($model);exit();
        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%')->orWhere('number', 'like', '%' . $name . '%');
            });
        }

        if ($start_time != "") {
            $model = $model->where('created_at', ">=", $start_time);
        }
        if ($end_time != "") {
            $model = $model->where('created_at', ">=", $end_time);
        }

        if ($status != "") {
            $model = $model->where('status', "=", $status);
        }
        $list = $model->orderBy('sort', 'asc')
            ->paginate($data['limit'])
            ->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
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
        $info = Classify::find($id);

        if (!empty($info) && $info->brands){
            $info->brands = Brand::whereIn('id',explode(',',$info->brands))->get();
        }

        return $info;
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


        return $this->commonUpdate(Classify::query(), $id, $data);
    }

    public function add(array $data)
    {
        $pid = 0;
        $lv = 1;
        if ($data['pid'] > 0) {
            $info = Classify::find($data['pid']);
            if (empty($info)) {
                return $this->apiError('父級分類不存在');
            }
            $pid = $info->id;
            $lv = $info->lv + 1;
            $prefix = $info->number . "-";
        } else {
            $prefix = "CF";
        }
        $count = Classify::where('pid', $pid)->count();
        if ($count == 0) {
            $number = "001";
        } else {
            $number = str_pad($count+1, 3, "0", STR_PAD_LEFT);
        }

        $data['number'] = $prefix . $number;
        $data['lv'] = $lv;
        if (isset($data['brands']) && !empty($data['brands'])){
            $data['brands'] = implode(',',array_column($data['brands'],'id'));
        }

        return $this->commonCreate(Classify::query(), $data);


    }
}
