<?php

/**
 * @Name 購買方案
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\UsersPointsDeal;

use Modules\Admin\Models\Store;
use Modules\Admin\Models\UsersPointsDetail;
use Modules\Admin\Models\PurchaseScheme;
use Modules\Admin\Services\BaseAdminService;

class UsersPointsDealService extends BaseAdminService
{
    /**
     * @param array $data
     * @return \Modules\Common\Services\JSON
     */
    function list(array $data)
    {
        $model = UsersPointsDetail::query()->with([
            'storebranchInfo' => function ($query) {
                $query->select([
                    'id',
                    'branch_no',
                    'branch_name'
                ]);
            }
        ]);
        $name  = $this->getValidParameter($data, 'name');

        if ($name != "") {
            $model = $model->where('name', 'like', '%' . $name . '%');
        }

        $list = $model->orderBy('id', 'desc')->paginate($data['limit'])->toArray();


        return $this->apiSuccess('', [
            'list'  => $list['data'],
            'total' => $list['total'],
        ]);
    }

    /**
     * @ 用編號查找店家
     * @param array $data
     * @return \Modules\Common\Services\JSON
     */
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
        return $this->commonStatusUpdate(UsersPointsDeal::query(), $id, $data);
    }

}
