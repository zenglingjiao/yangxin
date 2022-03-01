<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/22/022
 * Time: 16:10
 */

namespace Modules\Admin\Services\bank;



use Modules\Admin\Models\AnnexeHot;
use Modules\Admin\Models\AuthUser;
use Modules\Admin\Models\BankDividend;
use Modules\Admin\Models\Grade;
use Modules\Admin\Services\BaseAdminService;
use Cache;
use phpDocumentor\Reflection\DocBlock;

class BankDividendService extends BaseAdminService
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
        $list = BankDividend::orderBy('sort', 'asc')
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
        $user = Grade::find($id);

        return $user;
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

        if ($id >0){
            return $this->commonUpdate(BankDividend::query(),$id,$data);

        }else{
            return $this->commonCreate(BankDividend::query(),$data);
        }

    }
}