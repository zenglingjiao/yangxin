<?php

/**
 * @Name 管理員服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:07
 */

namespace Modules\Admin\Services\admin;


use Modules\Admin\Models\AuthAdmin;
use Modules\Admin\Services\BaseAdminService;
use Modules\Admin\Services\group\GroupService;

class AdminService extends BaseAdminService
{
    /**
     * @name 管理員列表
     * @description
     * @param data Array 查詢相關參數
     * @param data.page Int 頁碼
     * @param data.limit Int 每頁顯示條數
     * @param data.username String 賬號
     * @param data.group_id Int 權限組ID
     * @param data.project_id int 項目ID
     * @param data.status Int 狀態:0=禁用,1=啟用
     * @param data.created_at Array 創建時間
     * @param data.updated_at Array 更新時間
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:03
     */
    public function get_page_list(array $data)
    {
        $model = AuthAdmin::query();
        $model = $this->queryCondition($model, $data, 'username');
        $model = $model->where('id', '>', 1);
        $name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        $status = mb_strlen(trim(isset($data['status']) ?: "")) == 0 ? "" : trim($data['status']);
        $role_id = mb_strlen(trim(isset($data['role_id']) ?: "")) == 0 ? "" : trim($data['role_id']);
        $group = mb_strlen(trim(isset($data['group']) ?: "")) == 0 ? "" : trim($data['group']);
        if ($name != "") {
            $model = $model->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%')
                    ->orWhere('username', 'like', '%' . $name . '%');
            });
            //$model = $model->where('name', $name);
        }
        if ($status != "") {
            $model = $model->where('status', $status);
        }
        // if (isset($data['group_id']) && $data['group_id'] > 0) {
        //     $model = $model->where('group_id', $data['group_id']);
        // }
        // if (isset($data['project_id']) && $data['project_id'] > 0) {
        //     $model = $model->where('project_id', $data['project_id']);
        // }
        $model->with([
            'role_list' => function ($query) {
                $query->select('id', 'name');
            },
            'group' => function ($query) {
                $query->select('id', 'name');
            }
        ]);
        if ($role_id != "") {
            $model->whereHasIn('role_list', function ($q) use ($role_id) {
                $q->where('id', $role_id);
            });
        }
        if ($group != "") {
            $model->whereHas('group', function ($q) use ($group) {
                $q->where('id', $group);
            });
        }
        $list = $model->orderBy('id', 'desc')
            ->paginate($data['limit'])
            ->toArray();
        return $this->apiSuccess('', [
            'list' => $list['data'],
            'total' => $list['total']
        ]);
    }

    /**
     * @name 添加
     * @description
     * @param data Array 添加數據
     * @param data.username String 賬號
     * @param data.phone String 手機號
     * @param data.username String 賬號
     * @param data.password String 密碼
     * @param data.group_id int 權限組ID
     * @param data.project_id int 項目ID
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:29
     * @method  POST
     */
    public function add(array $data, array $ids = [])
    {
        \DB::beginTransaction();
        try {
            $is_role = true;
            $data['password'] = bcrypt($data['password']);
            if (!empty($data['group_id']) && $data['group_id'] > 0) {
                $is_role = false;
            } else {
                $data['group_id'] = null;
            }
            $res = $this->commonCreate(AuthAdmin::query(), $data);
            if ($res->getData()->status == 20000 && isset($res->getData()->data->insert_id)) {
                if ($is_role) {
                    if (isset($res->getData()->data->insert_id)) {
                        $this->edit($res->getData()->data->insert_id)->syncRoles($ids);
                    }
                } else {
                    $role_ids = (new GroupService())->edit($data['group_id'])->role_list()->pluck('id');
                    $this->edit($res->getData()->data->insert_id)->syncRoles($role_ids);
                }
            }
            \DB::commit();
            return $res;
        } catch (QueryException $exception) {
            \DB::rollback();
            $this->webError($exception->getMessage());
        }
    }

    /**
     * @name 修改頁面
     * @description
     * @param id Int 管理員id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:33
     */
    public function edit(int $id)
    {
        //return $this->apiSuccess('', AuthAdmin::select('id', 'name', 'group_id', 'phone', 'username', 'project_id')->find($id)->toArray());
        $a = AuthAdmin::select('id', 'name', 'phone', 'email', 'username', 'group_id', 'status')->with([
            'role_list' => function ($query) {
                $query->select('id', 'name', 'full_name');
            }
        ])->find($id);
        //$a->role_list_ = $a->role_list->pluck('id');
        $a->append("role_ids");
        return $a;
    }

    /**
     * @name 修改提交
     * @description
     * @param data Array 修改數據
     * @param daya.id Int 管理員id
     * @param daya.name String 名稱
     * @param daya.phone String 手機號
     * @param daya.username String 賬號
     * @param daya.group_id Int 權限組ID
     * @param data.project_id int 項目ID
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 4:03
     */
    public function update(int $id, array $data, array $ids = [])
    {
        \DB::beginTransaction();
        try {
            $is_role = true;
            if (!empty($data['password'])) {
                $data['password'] = bcrypt($data['password']);
            } else {
                unset($data["password"]);
            }
            if (!empty($data['group_id']) && $data['group_id'] > 0) {
                $is_role = false;
            } else {
                $data['group_id'] = null;
            }
            $res = $this->commonUpdate(AuthAdmin::query(), $id, $data);
            if ($res->getData()->status == 20000) {
                if ($is_role) {
                    $this->edit($id)->syncRoles($ids);
                } else {
                    $role_ids = (new GroupService())->edit($data['group_id'])->role_list()->pluck('id');
                    $this->edit($id)->syncRoles($role_ids);
                }
            }
            \DB::commit();
            return $res;
        } catch (QueryException $exception) {
            \DB::rollback();
            $this->webError($exception->getMessage());
        }
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
        return $this->commonStatusUpdate(AuthAdmin::query(), $id, $data);
    }

    /**
     * @name 初始化密碼
     * @description
     * @param id Int 管理員id
     * @return JSON
     **@author 非比網絡
     * @date 2021/6/12 3:51
     */
    public function updatePwd(int $id)
    {
        return $this->commonStatusUpdate(AuthAdmin::query(), $id, ['password' => bcrypt(config('admin.update_pwd'))], __('admin::admin.password_initialization_succeeded'), __('admin::admin.password_initialization_failed'));
    }

    /**
     * @Notes:
     * @Name 刪除管理員
     * @Interface del
     * @param array $role_ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function del(array $role_ids)
    {
        foreach ($role_ids as $id) {
            $user = $this->edit($id);
            $user->syncPermissions([]);
            $user->syncRoles([]);
        }
        return $this->commonDestroy(AuthAdmin::query(), $role_ids);
    }
}
