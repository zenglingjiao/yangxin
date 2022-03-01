<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Modules\Admin\Http\Requests\AdminAddRequest;
use Modules\Admin\Http\Requests\AdminUpdateRequest;
use Modules\Admin\Http\Requests\AuthMenuRequest;
use Modules\Admin\Http\Requests\CommonPageRequest;
use Modules\Admin\Http\Requests\DelIdRequest;
use Modules\Admin\Http\Requests\GroupAddRequest;
use Modules\Admin\Http\Requests\GroupUpdateRequest;
use Modules\Admin\Http\Requests\RoleAddRequest;
use Modules\Admin\Http\Requests\RoleUpdateRequest;
use Modules\Admin\Services\admin\AdminService;
use Modules\Admin\Http\Requests\CommonStatusRequest;

use Modules\Admin\Services\admin\MenuService;
use Modules\Admin\Services\group\GroupService;
use Modules\Admin\Services\role\RoleService;
use phpDocumentor\Reflection\DocBlock;

class AdminController extends BaseAdminController
{

    public function index()
    {
        return view('admin::index');
        //return view('admin::login');
    }

    public function test(Request $request)
    {
        exit;
        dd(__('exceptions.UPDATE_API_ERROR'));
        //\Cache::put('test', '1', 10);

        $xxx = \Cache::get('test');

        //Redis::set('test','fsdfsdf');
        $xxxx = Redis::get('test');
        echo(now()->addMinutes(10));

        //\Cache::put('user',"hahahahahha",now()->addMinutes(10));
        //throw new AdminException(['status' => 500, "message" => "cs"]);
        return "test";
    }

    /**
     * @Name 管理員視圖
     * @Interface admin_list
     * @Notes
     * @param
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\think\response\View
     * @author: Davi
     * @Time: 2021/12/10   16:19
     */
    public function admin_list()
    {
        $title = __('admin::controller.administrator_list');
        $role_list = (new RoleService())->get_role_all_list();
        $group_list = (new GroupService())->get_group_all_list();
        return view('admin::admin.admin_list', compact('title', 'role_list', 'group_list'));
    }

    /**
     * @Name 管理員列表
     * @Interface get_admin_list
     * @Notes
     * @param CommonPageRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:20
     */
    public function get_admin_list(CommonPageRequest $request)
    {
        //創建角色
        //$role = Role::create(['name' => 'admin', 'guard_name' => 'auth_admin']);
        // $xx = \Auth::guard('auth_admin')->user();
        //\Auth::guard('auth_admin')->user()->assignRole("admin");
        //\Auth::guard('auth_admin')->user()->givePermissionTo(['amdin_manage', 'admin_list', 'admin_edit', 'admin_delete', 'group_list', 'group_edit', 'group_delete']);
        return (new AdminService())->get_page_list($request->only([
            'page',
            'limit',
            'name',
            'username',
            'role_id',
            'group',
            'project_id',
            'status',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * @Name 管理員編輯
     * @Interface admin_edit
     * @Notes
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\think\response\View
     * @author: Davi
     * @Time: 2021/12/10   16:20
     */
    public function admin_edit(int $id = 0)
    {
        // if ($id === null) {
        //     return redirect()->route("admin_list");
        // }
        $title = __('admin::controller.administrator_edit');
        $model = $id > 0 ? (new AdminService())->edit($id) : null;
        $role_list = (new RoleService())->get_role_all_list();
        $group_list = (new GroupService())->get_group_all_list();
        $active = "admin_list";
        return view('admin::admin.admin_edit', compact('title', 'active', 'model', 'role_list', 'group_list'));
    }

    /**
     * @Name 新增管理員
     * @Interface admin_add
     * @Notes
     * @param AdminAddRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:20
     */
    public function admin_add(AdminAddRequest $request)
    {
        $admin_service = new AdminService();
        return $admin_service->add($request->only(['name', 'email', 'username', 'status', 'password', 'group_id']), $request->get('role_ids')??[]);
    }

    /**
     * @Name 更新管理員
     * @Interface admin_update
     * @Notes
     * @param AdminUpdateRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function admin_update(AdminUpdateRequest $request)
    {
        $admin_service = new AdminService();
        return $admin_service->update($request->get('id'), $request->only(['name', 'email', 'password', 'username', 'status', 'group_id']), $request->get('role_ids')??[]);
    }

    /**
     * @Name 調整狀態
     * @Interface status
     * @Notes
     * @param CommonStatusRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function status(CommonStatusRequest $request)
    {
        return (new AdminService())->status($request->get('id'), $request->only(['status']));
    }

    /**
     * @Name 刪除管理員
     * @Interface admin_del
     * @Notes
     * @param DelIdRequest $request
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function admin_del(DelIdRequest $request)
    {
        return (new AdminService())->del($request->get('ids'));
    }

    /**
     * @Name 管理員身份視圖
     * @Interface role_list
     * @Notes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\think\response\View
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function role_list()
    {
        $title = __('admin::controller.role_list');
        return view('admin::admin.role_list', compact('title'));
    }

    /**
     * @Name 管理員身份列表
     * @Interface get_role_list
     * @Notes
     * @param CommonPageRequest $request
     * @return \Modules\Admin\Services\role\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function get_role_list(CommonPageRequest $request)
    {
        //創建角色
        //$role = Role::create(['name' => 'admin', 'guard_name' => 'auth_admin']);
        // $xx = \Auth::guard('auth_admin')->user();
        //\Auth::guard('auth_admin')->user()->assignRole("admin");
        return (new RoleService())->get_page_list($request->only([
            'page',
            'limit',
            'name',
            'status',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * @Name 管理員身份編輯
     * @Interface role_edit
     * @Notes
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\think\response\View
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function role_edit(int $id = 0)
    {
        // if ($id === null) {
        //     return redirect()->route("admin_list");
        // }
        $title = __('admin::controller.role_edit');
        $model = $id > 0 ? (new RoleService())->edit($id) : null;
        $power_list = (new RoleService())->get_role_power($id);
        $active = "role_list";
        return view('admin::admin.role_edit', compact('title', 'active', 'model', 'power_list'));
    }

    /**
     * @Name 管理員身份新增
     * @Interface role_add
     * @Notes
     * @param RoleAddRequest $request
     * @return \Modules\Admin\Services\role\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:22
     */
    public function role_add(RoleAddRequest $request)
    {
        $role_service = new RoleService();
        $res = $role_service->add($request->only(['name']));
        if ($res->getData()->status == 20000) {
            if (isset($res->getData()->data->insert_id) && $request->has('has_power')) {
                $role_service->set_role_power($res->getData()->data->insert_id, $request->get('has_power'));
            }
        }
        return $res;
    }

    /**
     * @Name 管理員身份修改
     * @Interface role_update
     * @Notes
     * @param RoleUpdateRequest $request
     * @return \Modules\Admin\Services\role\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:22
     */
    public function role_update(RoleUpdateRequest $request)
    {
        $role_service = new RoleService();
        $res = $role_service->update($request->get('id'), $request->only(['name']));
        if ($res->getData()->status == 20000) {
            if ($request->has('has_power')) {
                $role_service->set_role_power($request->get('id'), $request->get('has_power'));
            }
        }
        return $res;
    }

    /**
     * @Name 管理員身份狀態
     * @Interface role_status
     * @Notes
     * @param CommonStatusRequest $request
     * @return \Modules\Admin\Services\role\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:22
     */
    public function role_status(CommonStatusRequest $request)
    {
        return (new RoleService())->status($request->get('id'), $request->only(['status']));
    }

    /**
     * @Name 刪除角色
     * @Interface role_del
     * @Notes
     * @param DelIdRequest $request
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:23
     */
    public function role_del(DelIdRequest $request)
    {
        return (new RoleService())->del($request->get('ids'));
    }

    /**
     * @Name 群組視圖
     * @Interface group_list
     * @Notes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\think\response\View
     * @method
     * @author: Davi
     * @Time: 2021/12/10   20:29
     */
    public function group_list()
    {
        $title = __('admin::controller.group_list');
        $role_list = (new RoleService())->get_role_all_list();
        return view('admin::admin.group_list', compact('title', 'role_list'));
    }

    /**
     * @Name 群組列表
     * @Interface get_admin_list
     * @Notes
     * @param CommonPageRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:20
     */
    public function get_group_list(CommonPageRequest $request)
    {
        //創建角色
        //$role = Role::create(['name' => 'admin', 'guard_name' => 'auth_admin']);
        // $xx = \Auth::guard('auth_admin')->user();
        //\Auth::guard('auth_admin')->user()->assignRole("admin");
        //\Auth::guard('auth_admin')->user()->givePermissionTo(['amdin_manage', 'admin_list', 'admin_edit', 'admin_delete', 'group_list', 'group_edit', 'group_delete']);
        return (new GroupService())->get_page_list($request->only([
            'page',
            'limit',
            'name',
            'role_id',
            'status',
            'created_at',
            'updated_at',
        ]));
    }

    /**
     * @Name 編輯群組
     * @Interface admin_edit
     * @Notes
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\think\response\View
     * @author: Davi
     * @Time: 2021/12/10   16:20
     */
    public function group_edit(int $id = 0)
    {
        // if ($id === null) {
        //     return redirect()->route("admin_list");
        // }
        $title = __('admin::controller.group_edit');
        $model = $id > 0 ? (new GroupService())->edit($id) : null;
        $role_list = (new RoleService())->get_role_all_list();
        $active = "group_list";
        return view('admin::admin.group_edit', compact('title', 'active', 'model', 'role_list'));
    }

    /**
     * @Name 新增群組
     * @Interface group_add
     * @Notes
     * @param GroupAddRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:20
     */
    public function group_add(GroupAddRequest $request)
    {
        $group_service = new GroupService();
        return $group_service->add($request->only(['name']), $request->get('role_ids'));
    }

    /**
     * @Name 更新群組
     * @Interface group_update
     * @Notes
     * @param GroupUpdateRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function group_update(GroupUpdateRequest $request)
    {
        $group_service = new GroupService();
        return $group_service->update($request->get('id'), $request->only(['name']), $request->get('role_ids'));
    }

    /**
     * @Name 調整群組狀態
     * @Interface status
     * @Notes
     * @param CommonStatusRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function group_status(CommonStatusRequest $request)
    {
        return (new GroupService())->status($request->get('id'), $request->only(['status']));
    }

    /**
     * @Name 刪除群組
     * @Interface admin_del
     * @Notes
     * @param DelIdRequest $request
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function group_del(DelIdRequest $request)
    {
        return (new GroupService())->del($request->get('ids'));
    }

    /**
     * @Name 菜單權限視圖
     * @Interface menu_list
     * @Notes
     * @param
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\think\response\View
     * @author: Davi
     * @Time: 2021/12/10   16:19
     */
    public function menu_list()
    {
        $title = __('admin::controller.menu_list');


        return view('admin::admin.menu_list', compact('title'));
    }

    /**
     * @Name 群組列表
     * @Interface get_admin_list
     * @Notes
     * @param CommonPageRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:20
     */
    public function get_menu_list(MenuService $service)
    {
                return $service->list();
    }

    /**
     * @Name 获取菜单选项
     * @Interface get_admin_select
     * @Notes
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:20
     */
    public function get_menu_select(MenuService $service)
    {
        return $service->get_menu_select();
    }

    /**
     * @Name 更新/添加菜单
     * @Interface group_update
     * @Notes
     * @param AuthMenuRequest $request
     * @return \Modules\Admin\Services\admin\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function menu_update(AuthMenuRequest $request,MenuService $service)
    {
        return $service->update($request->get('id'),
            $request->only([
                'parent',
                'name' ,
                'guard_name' ,
                'full_name' ,
                'is_menu' ,
                'is_route' ,
                'route' ,
                'active' ,
                'ico' ,
                'sort',
            ]));
    }

    /**
     * @Name 刪除群組
     * @Interface admin_del
     * @Notes
     * @param DelIdRequest $request
     * @return \Modules\Common\Services\JSON
     * @author: Davi
     * @Time: 2021/12/10   16:21
     */
    public function menu_del(DelIdRequest $request,MenuService $service)
    {
        return $service->del($request->get('ids'));
    }






}
