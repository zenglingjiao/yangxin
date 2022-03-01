<?php

/**
 * @Name 購買方案
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\StoreChange;

use Modules\Admin\Models\StoreChange;
use Modules\Admin\Models\PurchaseScheme;
use Modules\Admin\Services\BaseAdminService;

class StoreChangeService extends BaseAdminService
{
    function list(array $data)
    {
        $model = StoreChange::query()->with([
            'storeInfo' => function ($query) {
                $query->with([
                    'industryInfo' => function ($querys) {
                        $querys->select([
                            'id',
                            'name',
                        ]);
                    }
                ])->select([
                    'id',
                    'store_no',
                    'company_name',
                    'tax_id',
                    'industry_category_id',
                    'corporate_brand'
                ]);
            }
        ]);

        $name = $this->getValidParameter($data, 'name');

        if ($name != "") {
            $model = $model->where('name', 'like', '%' . $name . '%');
        }

        $list = $model->orderBy('status', 'asc')->orderBy('id', 'desc')->paginate($data['limit'])->toArray();


        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total'],
        ]);
    }

    function findlist(array $data)
    {

        $model = Store::query();
        $name  = $this->getValidParameter($data, 'name');

        if ($name != "") {
            $model = $model->where('store_no', 'like', '%' . $name . '%');
        }

        $list = $model->orderBy('id', 'desc')->orderBy('status', 'asc')->limit(10)->get();


        return $this->apiSuccess('', [
            'list' => $list
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
        $info = StoreChange::with([
            'storeInfo' => function ($query) {
                $query->select(['*']);
            }
        ])->find($id);

        return $info;
    }

    /**
     * @Name: 編輯/添加
     * @Author: zd
     * @Time: 2021/12/18/018 16:09
     * @param int $id
     * @param array $data
     * @param data.name string 名稱
     * @param data.code string 代碼
     * @return \Modules\Common\Services\JSON
     */
    public function update(int $id, array $data)
    {
        if ($id > 0) {
            return $this->commonUpdate(StoreChange::query(), $id, $data);
        }
//        $data['apply_date'] = date('Y-m-d H:i:s');
        return $this->commonCreate(StoreChange::query(), $data);
    }

    /**
     * @Name: 刪除
     * @Author: zd
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
     * @return \Modules\Common\Services\JSON
     **@author 非比網絡
     * @date 2021/6/12 4:06
     */
    public function status(int $id, array $data)
    {
        return $this->commonStatusUpdate(StoreChange::query(), $id, $data);
    }

}
