<?php

namespace Modules\Admin\Models;
class AuthRule extends BaseAdminModel
{
    /**
     * @name 更新時間為null時返回
     * @description
     * @author 非比網絡
     * @date 2021/6/14 9:33
     * @param  $value Int
     * @return Boolean
     **/
    public function getUpdatedAtAttribute($value)
    {
        return $value?$value:'';
    }
}
