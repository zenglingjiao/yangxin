<?php

namespace Modules\Admin\Models;

use DateTimeInterface;

use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles;

class UsersPointsAvailable extends BaseAdminModel
{
    protected $table = "yxds_users_points_available";

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

}
