<?php
/**
 * @Name 操作日誌模型
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/23 10:14
 */

namespace Modules\Admin\Models;

class AuthOperationLog extends BaseAdminModel
{
    /**
     * @name 關聯管理員
     * @description 多對一關系
     * @author 非比網絡
     * @date 2021/6/23 15:04
     * @return JSON
     **/
    public function admin_one()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthAdmin','admin_id','id');
    }
}
