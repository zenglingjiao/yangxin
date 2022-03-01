<?php
/**
 * @Name 權限組管理服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:24
 */

namespace Modules\Admin\Services\role;


use Modules\Admin\Services\auth\TokenService;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Modules\Admin\Services\BaseAdminService;

class RoleService extends BaseAdminService
{
    /**
     * @name 獲取所有角色
     */
    public function get_role_all_list()
    {
        return Role::orderBy('id', 'desc')->select('id', 'name', 'full_name', 'status')->where("id", ">", 1)->get()->toArray();
    }

    /**
     * @name 獲取權限組
     * @description
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:19
     */
    public function get_field_all_list()
    {
        return $this->webSuccess('', Role::orderBy('id', 'desc')->select('id', 'full_name')->where("id", ">", 1)->get()->toArray());
    }

    /**
     * @name 列表數據
     * @description
     * @param data Array 查詢相關參數
     * @param dtat.page Int 頁碼
     * @param dtat.limit Int 每頁顯示條數
     * @param dtat.name String 權限組名稱
     * @param dtat.status Int 狀態:0=禁用,1=啟用
     * @param dtat.created_at String 創建時間
     * @param dtat.updated_at String 更新時間
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/14 8:37
     */
    public function get_page_list(array $data)
    {
        $model = Role::query();
        $model = $this->queryCondition($model, $data, 'name');
        $list = $model
            ->where('id', '>', 1)
            ->select('id', 'name', 'full_name', 'status', 'created_at', 'updated_at')
            ->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();
        return $this->webSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    /**
     * @name 获取左侧栏
     **/
    public function get_menu()
    {
        $userInfo = (new TokenService())->my();
        //賦予權限
        //$userInfo->givePermissionTo(['index', 'amdin_manage', 'admin_list']);
        //撤銷權限
        //$userInfo->revokePermissionTo(['index', 'amdin_manage', 'admin_list', 'admin_edit', 'admin_delete']);
        //分配身份
        //$userInfo->assignRole('super_admin');

        $permission_list = Permission::orderBy('sort', 'asc')->get()->toArray();
        $has_permission_list = [];
        if (is_array($permission_list)) {
            foreach ($permission_list as $p) {
                if ($p["is_menu"] == 1 && ($userInfo->hasRole('super_admin') || $userInfo->hasPermissionTo($p["name"]))) {
                    $has_permission_list[] = $p;
                }
            }
        }
        $has_permission_list = $this->get_tree($has_permission_list, 0);
        return $this->apiSuccess('', $has_permission_list);
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

    /**
     * @Notes:
     * @Name 獲取角色權限樹
     * @Interface get_role_power
     * @param int $role_id
     * @return array
     * @author: Davi
     * @Time: 2021/12/07   23:52
     */
    public function get_role_power(int $role_id = 0)
    {
        $role = $role_id > 0 ? Role::findById($role_id, "auth_admin") : null;//$this->edit($role_id);
        $permission_list = Permission::orderBy('sort', 'asc')->where('id','!=',1)->get()->toArray();
        $has_permission_list = [];
        $have_permission_id_list = [];
        if (is_array($permission_list)) {
            foreach ($permission_list as $p) {
                if (is_object($role) && $role->hasPermissionTo($p["name"])) {
                    //$p["have"] = 1;
                    if (!$p["is_menu"] == 1) {
                        $have_permission_id_list[] = $p["id"];
                    } else if (!$this->has_children($p["id"], $permission_list) && $p["is_route"] == 1) {
                        $have_permission_id_list[] = $p["id"];
                    }
                } else {
                    //$p["have"] = 0;
                }
                $has_permission_list[] = $p;
            }
        }
        $has_permission_list = $this->get_tree($has_permission_list, 0);
        return [
            "all_permission_list" => $has_permission_list,
            "have_permission_id_list" => $have_permission_id_list
        ];
    }

    public function has_children($id, $power_list)
    {
        foreach ($power_list as $p) {
            if ($p["parent"] == $id) {
                return true;
            }
        }
        return false;
    }

    /**
     * @Notes:
     * @Name 給角色分配權限
     * @Interface set_role_power
     * @param $role_id
     * @param $power_list
     * @author: Davi
     * @Time: 2021/12/07   23:54
     */
    public function set_role_power($role_id, $power_list)
    {
        $role = Role::findById($role_id, "auth_admin");
        $role->syncPermissions($power_list);
    }

    /**
     * @name 添加
     * @description
     * @param data Array 添加數據
     * @param data.name String 權限組名稱
     * @param data.content String 描述
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     */
    public function add(array $data)
    {
        $role = Role::create($data);
        if ($id = $role->getKey()) {
            return $this->webSuccess(__('admin::admin.successfully_added'), ["insert_id" => $id]);
        } else {
            return $this->webError(__('admin::admin.failed_to_add'));
        }
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int 權限組id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function edit(int $id)
    {
        //return $this->apiSuccess('', Role::select('id', 'name')->find($id)->toArray());
        return Role::select('id', 'name')->find($id);
    }

    /**
     * @name 修改提交
     * @description
     * @param data Array 修改數據
     * @param id Int 權限組id
     * @param daya.name String 名稱
     * @param data.content String 描述
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function update(int $id, array $data)
    {
        return $this->commonUpdate(Role::query(), $id, $data);
    }

    /**
     * @name 調整狀態
     * @description
     * @param data Array 調整數據
     * @param id Int 管理員id
     * @param data.status Int 狀態（0或1）
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:06
     */
    public function status(int $id, array $data)
    {
        return $this->commonStatusUpdate(Role::query(), $id, $data);
    }

    /**
     * @Notes:
     * @Name 刪除角色
     * @Interface del
     * @param array $role_ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function del(array $role_ids)
    {
        foreach ($role_ids as $id) {
            $role = Role::findById($id, "auth_admin");
            $role->syncPermissions([]);
        }
        return $this->commonDestroy(Role::query(), $role_ids);
    }
}
