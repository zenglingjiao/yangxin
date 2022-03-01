<?php

namespace Modules\Admin\Models;

use DateTimeInterface;

use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class RequestFunds extends BaseAdminModel
{
    protected $table = "yxds_request_funds_record";

    protected $hidden = ['updated_at'];

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

    public function storeInfo(){
        return $this->hasOne(Store::class,'id','store_id');
    }

//    public function shoppingInfo(){
//        return $this->hasOne(ShoppingStreet::class,'id','relation_id');
//    }
//
//    public function schemeInfo(){
//        return $this->hasOne(PurchaseScheme::class,'id','purchase_scheme_id');
//    }
}
