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

class MenuFooter extends BaseAdminModel
{

    protected $table = "yx_menu_footer";

    protected $hidden = ['created_at','updated_at'];


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