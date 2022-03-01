<?php

namespace Modules\Admin\Models;
class AuthConfig extends BaseAdminModel
{
    /**
     * @name 關聯logo圖片
     * @description
     * @author 非比網絡
     * @date 2021/6/21 15:04
     * @return JSON
     **/
    public function logo_one()
    {
        return $this->hasOne('Modules\Admin\Models\AuthImage','id','logo_id');
    }

}
