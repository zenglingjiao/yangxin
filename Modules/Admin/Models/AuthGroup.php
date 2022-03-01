<?php

namespace Modules\Admin\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuthGroup extends Model
{
    use HasFactory;
    protected $table = 'groups';
    protected $guard = 'auth_admin';
    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Admin\Database\factories\AuthGroupFactory::new();
    }

    public function getRoleIdsAttribute()
    {
        return $this->role_list->pluck('id');
    }

    /**
     * @Name 獲取該組的所有管理員
     * @Interface admin_list
     * @Notes
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     * @method
     * @author: Davi
     * @Time: 2021/12/10   22:27
     */
    public function admin_list()
    {
        return $this->hasMany(AuthAdmin::class, 'group_id');
    }

    /**
     * 多對多
     * 組拥有的角色
     */
    public function role_list()
    {
        return $this->belongsToMany('Spatie\Permission\Models\Role', 'group_has_roles', 'group_id', 'role_id');
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
