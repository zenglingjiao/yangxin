<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/18/018
 * Time: 16:44
 */

namespace Modules\Admin\Services\navi;


use Modules\Admin\Models\Navi;
use Spatie\Permission\Models\Permission;
use Modules\Admin\Services\BaseAdminService;
class NaviService extends BaseAdminService
{
    /**
     * @Name: 菜单列表
     * @Author: chenji
     * @Time: 2021/12/20/020 14:05
     * @return \Modules\Common\Services\JSON
     */
    public function list(){

        $list = Navi::query()->where('type','pc')->orderBy('sort','asc')->get()->toArray();
        return $this->apiSuccess('', $list);

    }



    /**
     * @Name:  更新/添加菜单
     * @Author: chenji
     * @Time: 2021/12/20/020 14:06
     * @param int $id
     * @param array $data
     * @return \Modules\Common\Services\JSON
     * @throws \Modules\Common\Exceptions\AdminException
     */
    public function update(int $id,array $data){
        if ($id > 0){
            return $this->commonUpdate(Navi::query(),$id,$data);
        }

        return $this->commonCreate(Navi::query(),$data);

    }

    public function del(array $ids){

        return $this->commonDestroy(Navi::query(),$ids);
    }


}