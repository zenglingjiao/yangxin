<?php

/**
 * @Name 購買方案
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\pointsSold;

use Modules\Admin\Models\PointsSold;
use Modules\Admin\Models\PurchaseScheme;
use Modules\Admin\Services\BaseAdminService;

class PointsSoldService extends BaseAdminService
{
    /**
     * @name 列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    function list(array $data) {
        $model = PointsSold::query()->with(['storeInfo'=>function($query){
            $query->select(['id','store_no','company_name']);
        },'shoppingInfo'=>function($query){
            $query->select(['id','shopping_street_no','shopping_street_name']);
        },'schemeInfo'=>function($query){
            $query->select(['id','scenario_name','points','original_price']);
        }]);

        $name = $this->getValidParameter($data, 'name');

        if ($name != "") {
            $model = $model->where('name', 'like', '%' . $name . '%');
        }

        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();


        return $this->apiSuccess('', [
            'list'  => $list['data'],
            'total' => $list['total'],
        ]);
    }

    /**
     * @name 獲取編輯內容
     * @description
     * @param id Int 表id
     * @return JSON
     **@author 非比網絡
     * @date 2022/1/13 16:46
     */
    public function edit(int $id)
    {
        $info = PointsSold::find($id);

        return $info;
    }
    /**
     * @Name: 編輯/添加
     * @Author: chenji
     * @Time: 2021/12/18/018 16:09
     * @param int $id
     * @param array $data
     * @param data.name string 名稱
     * @param data.code string 代碼
     * @return \Modules\Common\Services\JSON
     */
    public function update(int $id, array $data)
    {
        $data['relation_id'] = 1;
        if ($id > 0) {
            return $this->commonUpdate(PointsSold::query(), $id, $data);
        }
        return $this->commonCreate(PointsSold::query(), $data);
    }

    /**
     * @Name: 刪除
     * @Author: chenji
     * @Time: 2021/12/18/018 16:11
     * @param array $ids
     * @return \Modules\Common\Services\JSON
     */
    public function del(array $ids)
    {
        return $this->commonDestroy(Store::query(), $ids);
    }
    /**
     * @ 調整狀態
     * @description
     * @param data Array 調整數據
     * @param id Int 管理員id
     * @param data.status Int 狀態（0或1）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:06
     */
    public function status(int $id, array $data)
    {
        return $this->commonStatusUpdate(PointsSold::query(), $id, $data);
    }

    function purchase_scheme_list(array $data) {
        $model = PurchaseScheme::query();

        $name = $this->getValidParameter($data, 'name');

        if ($name != "") {
            $model = $model->where('name', 'like', '%' . $name . '%');
        }

        // $model = $model->where('id', 0);
        $list = $model->orderBy('id', 'desc')
            ->get()
            ->toArray();

        return $list;
    }

}
