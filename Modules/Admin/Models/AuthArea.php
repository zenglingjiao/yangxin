<?php

namespace Modules\Admin\Models;

class AuthArea extends BaseAdminModel
{
    /**
     * @name 更新時間為null時返回
     * @description
     * @author 非比網絡
     * @date 2021/6/21 16:33
     * @param value int  $value
     * @return Boolean
     **/
    public function getUpdatedAtAttribute($value)
    {
        return $value?$value:'';
    }

}
