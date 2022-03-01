<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/22/022
 * Time: 16:10
 */

namespace Modules\Admin\Services\grade;



use Modules\Admin\Models\AnnexeHot;
use Modules\Admin\Models\AuthUser;
use Modules\Admin\Models\Grade;
use Modules\Admin\Services\BaseAdminService;
use Cache;
use phpDocumentor\Reflection\DocBlock;

class GradeService extends BaseAdminService
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
    public function list()
    {
        $list = Grade::orderBy('id', 'desc')->get();
           // ->toArray();
        foreach ($list as $v){
            $v->lv = "LV".$v->id;

        }
        $list = $list->toArray();

        return $this->apiSuccess('', [
            'list' => $list,
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

        if ($data['up_type'] == 1){
            $data['up_exp'] = 0;
        }
        if ($data['expiry_type'] == 1){
            $data['expiry_date'] = 0;
        }
        $data['exp_data'] = json_encode($data['exp_data'],JSON_UNESCAPED_UNICODE);
        $data['point_data'] = json_encode($data['point_data'],JSON_UNESCAPED_UNICODE);
        $data['freight_data'] = json_encode($data['freight_data'],JSON_UNESCAPED_UNICODE);
        $data['discount_data'] = json_encode($data['discount_data'],JSON_UNESCAPED_UNICODE);

        return $this->commonUpdate(Grade::query(),$id,$data);

    }
}