<?php
/**
 * @Name 權限組管理服務
 * @Description
 * @Auther 非比網絡
 * @Date 2021/6/12 03:24
 */

namespace Modules\Admin\Services\group;

use Illuminate\Database\QueryException;
use Modules\Admin\Models\AuthGroup;
use Modules\Admin\Services\BaseAdminService;
use Spatie\Permission\Guard;

class GroupService extends BaseAdminService
{
    /**
     * @name 獲取所有群組
     */
    public function get_group_all_list()
    {
        return AuthGroup::orderBy('id', 'desc')->select('id', 'name', 'status')->get()->toArray();
    }

    /**
     * @name 群組列表
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
        $model = AuthGroup::query();
        $model = $this->queryCondition($model, $data, 'name');
        $role_id = mb_strlen(trim(isset($data['role_id']) ?: "")) == 0 ? "" : trim($data['role_id']);
        //$name = mb_strlen(trim(isset($data['name']) ?: "")) == 0 ? "" : trim($data['name']);
        // if ($name != "") {
        //     $model = $model->where(function ($query) use ($name) {
        //         $query->where('name', 'like', '%' . $name . '%')
        //             ->orWhere('username', 'like', '%' . $name . '%');
        //     });
        //     //$model = $model->where('name', $name);
        // }
        // if ($status != "") {
        //     $model = $model->where('status', $status);
        // }

        $model->with([
            'role_list' => function ($query) {
                $query->select('id', 'name');
            },
            // 'auth_projects' => function ($query) {
            //     $query->select('id', 'name');
            // }
        ]);
        if ($role_id != "") {
            $model->whereHasIn('role_list', function ($q) use ($role_id) {
                $q->where('id', $role_id);
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
    public function add(array $data, array $role_ids = [])
    {
        \DB::beginTransaction();
        try {
            $data["status"] = 1;
            $data["guard_name"] = Guard::getDefaultName(static::class);
            $res = $this->commonCreate(AuthGroup::query(), $data);
            if ($res->getData()->status == 20000) {
                if (isset($res->getData()->data->insert_id)) {
                    $this->sync_roles($this->edit($res->getData()->data->insert_id), $role_ids);
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
        //return $this->apiSuccess('', AuthAdminModel::select('id', 'name', 'group_id', 'phone', 'username', 'project_id')->find($id)->toArray());
        $a = AuthGroup::select('id', 'name', 'status')->with([
            'role_list' => function ($query) {
                $query->select('id', 'name');
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
    public function update(int $id, array $data, array $role_ids = [])
    {
        \DB::beginTransaction();
        try {
            $res = $this->commonUpdate(AuthGroup::query(), $id, $data);
            if ($res->getData()->status == 20000) {
                $this->sync_roles($this->edit($id), $role_ids);
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
        return $this->commonStatusUpdate(AuthGroup::query(), $id, $data);
    }

    /**
     * @Notes:
     * @Name 刪除
     * @Interface del
     * @param array $role_ids
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/08   1:23
     */
    public function del(array $role_ids)
    {
        \DB::beginTransaction();
        try {
            foreach ($role_ids as $id) {
                $group = AuthGroup::query()->find($id);
                $group->role_list()->sync([]);
                $admin_list = $group->admin_list;
                foreach ($admin_list as $admin) {
                    $admin->syncRoles([]);
                    $admin->group()->dissociate();
                    $admin->save();
                }
            }
            $res = $this->commonDestroy(AuthGroup::query(), $role_ids);
            \DB::commit();
            return $res;
        } catch (QueryException $exception) {
            \DB::rollback();
            $this->webError($exception->getMessage());
        }
    }

    public function sync_roles(AuthGroup $group, array $data)
    {
        $sync_data = [];
        foreach ($data as $k => $v) {
            $sync_data[$v] = ["model_type" => (new \ReflectionClass(AuthGroup::class))->getName()];
        }
        //分配當前群組身份
        $group->role_list()->sync($sync_data);
        $admin_list = $group->admin_list;
        foreach ($admin_list as $admin) {
            $admin->syncRoles($data);
        }
    }
}
