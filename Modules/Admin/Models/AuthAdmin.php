<?php
/**
 * @Name 管理員模型
 * @Description
 * @Auther 非比網絡
 * @Date 2021/11/29 18:55
 */

namespace Modules\Admin\Models;

use DateTimeInterface;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class AuthAdmin extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use HasRoles;
    protected $guard = 'auth_admin';
    protected $hidden = [
        'password'
    ];

    /**
     * @name jwt標識
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:11
     **/
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * @name jwt自定義聲明
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:11
     **/
    public function getJWTCustomClaims()
    {
        return [];
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
     * @name  關聯權限組表   多對一
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:12
     **/
    public function group()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthGroup','group_id');
    }

    public function getRoleIdsAttribute()
    {
        return $this->role_list->pluck('id');
    }

    /**
     * 多對多
     * 用户拥有的角色
     */
    public function role_list()
    {
        return $this->belongsToMany('Spatie\Permission\Models\Role', 'model_has_roles', 'model_id', 'role_id');
    }

    /**
     * @name  關聯平臺項目表   多對一
     * @description
     * @author 非比網絡
     * @date 2021/6/12 3:12
     **/
    public function auth_projects()
    {
        return $this->belongsTo('Modules\Admin\Models\AuthProject', 'project_id', 'id');
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