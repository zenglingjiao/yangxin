<?php

namespace Modules\Admin\Models;
class AuthProject extends BaseAdminModel
{

    /**
     * @name   更新時間為null時返回
     * @param  int  $value
     * @return Boolean
     */
    public function getUpdatedAtAttribute($value)
    {
        return $value?$value:'';
    }
    /**
     * @name 關聯站點logo圖片
     * @description 多對一
     * @author 非比網絡
     * @date 2021/6/21 15:04
     * @return JSON
     **/
    public function logo_one()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthImage','logo_id','id');
    }
    /**
     * @name 站點標識
     * @description 多對一
     * @author 非比網絡
     * @date 2021/6/21 15:04
     * @return JSON
     **/
    public function ico_one()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthImage','ico_id','id');
    }

}
