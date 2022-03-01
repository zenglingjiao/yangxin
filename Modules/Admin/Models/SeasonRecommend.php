<?php
/**
 * @Name 管理員模型
 * @Description
 * @Auther 非比網絡
 * @Date 2021/11/29 18:55
 */

namespace Modules\Admin\Models;

use DateTimeInterface;

use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class SeasonRecommend extends BaseAdminModel
{

    protected $table = "yx_season_recommend";

    protected $hidden = ['created_at','updated_at'];

    public function info(){
        return $this->hasMany(SeasonRecommendData::class,'recommend_id','id');
    }




    /**
     * @name 更新時間為null時返回
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:11
     **/
    public function getUpdatedAtAttribute($value)
    {
        return $value ? $value : '';
    }

    /**
     * @name 時間格式傳喚
     * @description
     * @author 非比網絡
     * @date 2021/6/17 16:15
     **/
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}