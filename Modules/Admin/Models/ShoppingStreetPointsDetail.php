<?php

namespace Modules\Admin\Models;

use DateTimeInterface;

use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class ShoppingStreetPointsDetail extends BaseAdminModel
{
    protected $table = "yxds_shopping_street_points_detail";

    protected $hidden = [];



    /**
     * @ 時間格式傳喚
     * @description
     * @author 非比網絡
     * @date 2021/6/17 16:15
     **/
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function ShoppingStreetInfo(){
        return $this->hasOne(ShoppingStreet::class,'id','shopping_street_id');
    }

}
