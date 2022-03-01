<?php
/**
 * @Name  平臺用戶模型
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/29 14:27
 */

namespace Modules\Admin\Models;

use Cache;
use Hashids\Hashids;
class AuthUser extends BaseAdminModel
{
    protected $hidden = ['password'];

    const REGISTER_WAY_NAME = [
        1=> "一般會員",
        2=> "FB會員",
        3=> "GOOGLE會員",
        4=> "Line會員",
        5=> "APPLE會員",
    ];

    public function getUidAttribute()
    {
        return "M".str_pad($this->id,8,"0",STR_PAD_LEFT);
    }

    public function getRegisterWayNameAttribute()
    {
        return self::REGISTER_WAY_NAME[$this->register_way];
    }

    /**
     * @name 更新時間為null時返回
     * @description
     * @author 非比網絡
     * @date 2021/6/21 16:33
     * @param value String  $value
     * @return Boolean
     **/
    public function getUpdatedAtAttribute($value)
    {
        return $value?$value:'';
    }


    /**
     * @name  關聯省   多對一
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:12
     **/
    public function province_to()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthArea','province_id','id');
    }
    /**
     * @name  關聯市   多對一
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:12
     **/
    public function city_to()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthArea','city_id','id');
    }
    /**
     * @name  關聯區縣   多對一
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:12
     **/
    public function county_to()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthArea','county_id','id');
    }

    static public function createRecommendCode(){
      return  Cache::lock('create_recommend_code', 5)->block(3, function () {
            // 等待最多3秒后获取的锁...
          $id = AuthUser::max('id');
          $hashids = new Hashids('','8');
         return $hashids->encode($id,$id,$id);
        });
    }
}
