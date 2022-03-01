<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\store;

use Modules\Admin\Models\Store;
use Modules\Admin\Models\StoreBranch;
use Modules\Admin\Models\IndustryCategory;
use Modules\Admin\Services\BaseAdminService;

class StoreService extends BaseAdminService
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
        $model = Store::query()->with(['industryInfo'=>function($query){
            $query->select(['id','name']);
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
        $info = Store::find($id);

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

        \DB::beginTransaction();
        try{
            $data['business_hours'] = isset($data['business_hours']) ? json_encode($data['business_hours']) : '';
            $data['have_branch'] = $this->getValidParameter($data, 'have_branch');
            $branch_data = [
                "branch_name" => $this->getValidParameter($data, 'company_name'),
                "branch_city" => $this->getValidParameter($data, 'reg_city'),
                "branch_district" => $this->getValidParameter($data, 'reg_district'),
                "branch_address" => $this->getValidParameter($data, 'reg_address'),
                "branch_business_hours" => $data['business_hours'],
            ];
            if ($id > 0) {
                $this->commonUpdate(Store::query(), $id, $data);

                $branch_data['updated_at'] = date('Y-m-d H:i:s');
                StoreBranch::query()->where('store_id',$id)->update($branch_data);

            }else{
                $id = Store::query()->insertGetId($data);

                if($data['have_branch'] != 1){
                    $branch_data['store_id'] = $id;
                    $branch_data['type'] = 1;
                    $branch_data['created_at'] = date('Y-m-d H:i:s');
                    StoreBranch::query()->insert($branch_data);
                }


            }
            \DB::commit();
        }catch (\Exception $exception){
            \DB::rollback();
            return $this->webError($exception->getMessage());
        }
        return $this->apiSuccess();

        // $data['business_hours'] = json_encode($data['business_hours']);
        // if ($id > 0) {
        //     return $this->commonUpdate(Store::query(), $id, $data);
        // }
        // return $this->commonCreate(Store::query(), $data);
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
        return $this->commonStatusUpdate(Store::query(), $id, $data);
    }

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
    function branch_list(array $data) {
        $model = StoreBranch::query();

        $name = $this->getValidParameter($data, 'name');
        $pid = $this->getValidParameter($data, 'pid');

        if ($name != "") {
            $model = $model->where('name', 'like', '%' . $name . '%');
        }
        if ($pid != "") {
            $model = $model->where('store_id', $pid);
        }
        // $model = $model->where('id', 0);
        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();
        // var_dump($list);

        return $this->apiSuccess('', [
            'list'  => $list['data'],
            'total' => $list['total'],
        ]);
    }

    /**
     * @Name: 編輯/添加
     * @Author: zlj
     * @Time: 2021/12/18/018 16:09
     * @param int $id
     * @param array $data
     * @param data.name string 名稱
     * @param data.code string 代碼
     * @return \Modules\Common\Services\JSON
     */
    public function branch_update(int $id, array $data)
    {
        // var_dump($id);return;
        $data['branch_business_hours'] = json_encode($data['branch_business_hours']);
        if ($id > 0) {
            return $this->commonUpdate(StoreBranch::query(), $id, $data);
        }
        return $this->commonCreate(StoreBranch::query(), $data);
    }

    /**
     * @name 獲取編輯內容
     * @description
     * @param id Int 表id
     * @return JSON
     **@author 非比網絡
     * @date 2022/1/13 16:46
     */
    public function branch_edit(int $id)
    {
        $info = StoreBranch::find($id);

        return $info;
    }

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
    function industry_category_list(array $data) {
        $model = IndustryCategory::query();

        $name = $this->getValidParameter($data, 'name');

        if ($name != "") {
            $model = $model->where('name', 'like', '%' . $name . '%');
        }

        // $model = $model->where('id', 0);
        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();
        // var_dump($list);

        return $this->apiSuccess('', [
            'list'  => $list['data'],
            'total' => $list['total'],
        ]);
    }

    /**
     * @Name: 編輯/添加
     * @Author: zlj
     * @Time: 2021/12/18/018 16:09
     * @param int $id
     * @param array $data
     * @param data.name string 名稱
     * @param data.code string 代碼
     * @return \Modules\Common\Services\JSON
     */
    public function industry_category_update(int $id, array $data)
    {
        // var_dump($id);return;
        if ($id > 0) {
            return $this->commonUpdate(IndustryCategory::query(), $id, $data);
        }
        return $this->commonCreate(IndustryCategory::query(), $data);
    }

    /**
     * @name 獲取編輯內容
     * @description
     * @param id Int 表id
     * @return JSON
     **@author 非比網絡
     * @date 2022/1/13 16:46
     */
    public function industry_category_edit(int $id)
    {
        $info = IndustryCategory::find($id);

        return $info;
    }

    function industry_category_all(array $data) {
        $model = IndustryCategory::query();

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
