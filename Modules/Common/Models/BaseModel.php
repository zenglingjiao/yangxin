<?php
/**
 * @Name
 * @Description
 * @Auther 非比網絡
 * @Date 2021/11/29 17:56
 */

namespace Modules\Common\Models;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class BaseModel extends EloquentModel
{
    /**
     * @name
     * @description
     * @author 非比網絡
     * @date 2021/6/11 10:44
     * @method  GET
     * @param
     * @return JSON
     **/
    protected $primaryKey = 'id';
    /**
     * @name id是否自增
     * @description
     * @author 非比網絡
     * @date 2021/6/11 12:25
     * @return Bool
     **/
    public $incrementing = false;
    /**
     * @name   表id是否為自增
     * @description
     * @author 非比網絡
     * @date 2021/6/11 12:26
     * @return String
     **/
    protected $keyType = 'int';
    /**
     * @name 指示是否自動維護時間戳
     * @description
     * @author 非比網絡
     * @date 2021/6/11 10:36
     * @return Bool
     **/
    public $timestamps = false;
    /**
     * @name 該字段可被批量賦值
     * @description
     * @author 非比網絡
     * @date 2021/6/11 10:40
     * @return Array
     **/
    protected $fillable = [];
    /**
     * @name 該字段不可被批量賦值
     * @description
     * @author 非比網絡
     * @date 2021/6/11 10:40
     * @return Array
     **/
    protected $guarded = [];

    /**
     * @name 時間格式傳喚
     * @description
     * @author 非比網絡
     * @date 2021/6/17 16:20
     **/
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}