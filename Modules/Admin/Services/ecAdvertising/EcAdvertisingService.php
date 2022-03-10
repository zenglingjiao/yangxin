<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\EcAdvertising;

use Modules\Admin\Models\EcAdvertising;
use Modules\Admin\Services\BaseAdminService;

class EcAdvertisingService extends BaseAdminService
{
    /**
     * @name 發票捐贈列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    function list(array $data) {
        $model = EcAdvertising::query()->with([
            'storeInfo' => function ($query) {
                $query->select([
                    'id',
                    'store_no',
                    'company_name',
                    'tax_id',
                    'corporate_brand'
                ]);
            }
        ]);

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
        $info = EcAdvertising::with([
            'storeInfo' => function ($query) {
                $query->select([
                    'id',
                    'store_no',
                    'company_name',
                    'tax_id',
                    'bank_code',
                    'branch_bank',
                    'bank_accounts',
                    'bank_username'
                ]);
            }
        ])->find($id);

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
         $data['up_at'] = json_encode($data['up_at']);
         if ($id > 0) {
             return $this->commonUpdate(EcAdvertising::query(), $id, $data);
         }
         return $this->commonCreate(EcAdvertising::query(), $data);
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
        return $this->commonDestroy(EcAdvertising::query(), $ids);
    }
    /**
     * @name 調整狀態
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
        return $this->commonStatusUpdate(EcAdvertising::query(), $id, $data);
    }



}
