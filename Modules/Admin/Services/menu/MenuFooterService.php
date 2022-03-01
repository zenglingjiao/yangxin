<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\menu;



use Modules\Admin\Models\Invoice;
use Modules\Admin\Models\Logistics;
use Modules\Admin\Models\MenuFooter;
use Modules\Admin\Services\BaseAdminService;


class MenuFooterService extends BaseAdminService
{
    /**
     * @name 管理員列表
     * @description
     * @param id int id  (0:大菜單 )
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function list(int $id,array $data)
    {
        $model = MenuFooter::query();

        $model->where('pid',$id);

        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();

        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    /**
     * @name 編輯/添加
     * @description
     * @param $id int
     * @param data Array 修改數據
     * @param daya.pid Int 上級ID
     * @param daya.name String 名稱
     * @param daya.type String 類型
     * @param daya.link String 鏈接
     * @param daya.status int 狀態
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function update(int $id, array $data)
    {
        if ($id > 0){
            return $this->commonUpdate(MenuFooter::query(), $id, $data);
        }
        return $this->commonCreate(MenuFooter::query(),$data);
    }


}
