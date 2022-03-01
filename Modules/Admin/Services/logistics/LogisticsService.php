<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\logistics;



use Modules\Admin\Models\Logistics;
use Modules\Admin\Services\BaseAdminService;


class LogisticsService extends BaseAdminService
{
    /**
     * @name 管理員列表
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
        $model = Logistics::query();

        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    /**
     * @name 修改提交
     * @description
     * @param data Array 修改數據
     * @param daya.id Int 管理員id
     * @param daya.name String 名稱
     * @param daya.phone String 手機號
     * @param daya.username String 賬號
     * @param daya.group_id Int 權限組ID
     * @param data.project_id int 項目ID
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function update(int $id, array $data)
    {
            return $this->commonUpdate(Logistics::query(), $id, $data);

    }



}
