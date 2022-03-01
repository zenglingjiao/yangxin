<?php
/**
 * Created by PhpStorm.
 * User: Feibi
 * Date: 2021/12/18/018
 * Time: 16:44
 */

namespace Modules\Admin\Services\admin;


use Spatie\Permission\Models\Permission;
use Modules\Admin\Services\BaseAdminService;
class MenuService extends BaseAdminService
{
    /**
     * @Name: 菜单列表
     * @Author: chenji
     * @Time: 2021/12/20/020 14:05
     * @return \Modules\Common\Services\JSON
     */
    public function list(){

        $has_permission_list = $this->get_menu( 0);
        return $this->apiSuccess('', $has_permission_list);

    }

    /**
     * @Name: 获取菜单选项
     * @Route:
     * @Method:
     * @Author: chenji
     * @Time: 2021/12/20/020 14:05
     * @return \Modules\Common\Services\JSON
     */
    public function get_menu_select(){

        $has_permission_list = $this->get_menu( 1);
        $data = [];
        foreach ($has_permission_list as $v){

            $arr = [
                "k" => $v['id'],
                "v" => $this->getSelect($v['level']) . $v['full_name'],
            ];
            $data[] = $arr;
            $children = $this->getChildren($v['children']);
            if (!empty($children)){
                $children =  $this->getChildren($v['children']);
            }else{
                $children = [];
            }
            $data =  array_merge($data,$children);

        }
        return $this->apiSuccess('', $data);

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
        if (empty($data['route'])){
            $data['route'] = "";
        }
        if (empty($data['active'])){
            $data['active'] = "";
        }
        if (empty($data['ico'])){
            $data['ico'] = "";
        }
        if ($id > 0){
            return $this->commonUpdate(Permission::query(),$id,$data);
        }

        if ($data['parent'] > 0){
            $parent = Permission::where('id',$data['parent'])->first();
            if (empty($parent)) {
                return $this->apiError("父级不存在");
            }

            if ($parent->is_menu != 1){
                return $this->apiError("父级不存在");
            }
            $level =$parent->level+1;
        }else{
            $level =1;
        }

        $data['level'] = $level;

        return $this->commonCreate(Permission::query(),$data);

    }

    public function del(array $ids){
        $res = Permission::query()->where('parent',$ids[0])->first();
        if ($res){
            return $this->apiError("请先删除子级");
        }
        return $this->commonDestroy(Permission::query(),$ids);
    }

    private function getChildren(array $arr){
        $data = [];
        if (empty($arr)) return $data;

        foreach ($arr as $v){
            $arr = [
                "k" => $v['id'],
                "v" => $this->getSelect($v['level']) . $v['full_name'],
            ];
            $data[] = $arr;
            if (!empty($v['children'])){
                $children =  $this->getChildren($v['children']);
            }else{
                $children =[];
            }

            $data =  array_merge($data,$children);
        }
        return $data;
    }

    private function getSelect(int $lv){
        $flag = "|--";
        if ($lv == 0){
            return $flag;
        }


        $space = "　";

        for ($i=0;$i<$lv;$i++){
            $space .= $space;
        }
        return $space.$flag;
    }

    protected function get_menu(int $is_menu=0){
        if ($is_menu == 1){
            $permission_list = Permission::where('is_menu',1)->where('id','!=',1)->orderBy('sort', 'asc')->get()->toArray();
        }else{
            $permission_list = Permission::orderBy('sort', 'asc')->where('id','!=',1)->get()->toArray();
        }


        $has_permission_list = [];
        if (is_array($permission_list)) {
            foreach ($permission_list as $p) {
                $has_permission_list[] = $p;
            }
        }

        $has_permission_list = $this->get_tree($has_permission_list, 0);

        return $has_permission_list;
    }


    /**
     * @利用遞歸法獲取無限極類別的樹狀數組
     */
    private function get_tree(array $menu = [], int $parent)
    {
        $tree = [];
        foreach ($menu as $k => $v) {
            if ($v['parent'] == $parent) {
                $v["children"] = $this->get_tree($menu, $v['id']);
                $tree[] = $v;
            }
        }
        return $tree;
    }

}