<?php

namespace Modules\Admin\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_id = DB::table('roles')->insertGetId([
            'name' => 'super_admin',
            'full_name' => '超級管理員',
            'guard_name' => 'auth_admin',
            'status' => 1
        ]);
        DB::table('model_has_roles')->insertGetId([
            'role_id' => $role_id,
            'model_id' => 1,
            'model_type' => 'Modules\Admin\Models\AuthAdmin',
        ]);

        $sql = file_get_contents(base_path('Modules/Admin/Database/Seeders/permissions.sql'));
        DB::unprepared($sql);
        return;

        // for($i=1;$i<8;$i++){
        //     $j = rand(10,99);
        //     for($x=0;$x<$j;$x++){
        //         DB::table('auth_operation_logs')->insert([
        //             'content' => '測試log',
        //             'url' => 'log',
        //             'method' => 'GET',
        //             'ip' => '127.0.0.1',
        //             'admin_id'=>1,
        //             'created_at'=>date('Y-m-d H:i:s',strtotime("-{$i} day"))
        //         ]);
        //     }
        // }

        //權限
        //第一級 菜單管理
        $sort = 0;
        $parent = DB::table('permissions')->insertGetId([
            'level' => 1,
            'parent' => 0,
            'name' => 'menu_list',
            'guard_name' => 'auth_admin',
            'full_name' => '菜單管理',
            'is_menu' => 1,
            'is_route' => 1,
            'route' => 'admin/menu_list',
            'active' => 'menu_list',
            'sort' => $sort,
            'ico' => 'lni lni-list',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第二級 菜單管理 編輯，刪除權限
        foreach ([['menu_update', '編輯', 'admin/menu_update'], ['menu_del', '刪除', 'admin/menu_del']] as $k => $v) {
            DB::table('permissions')->insertGetId([
                'level' => 2,
                'parent' => $parent,
                'name' => $v[0],
                'guard_name' => 'auth_admin',
                'full_name' => $v[1],
                'is_menu' => 0,
                'is_route' => 1,
                'route' => $v[2],
                'active' => '',
                'sort' => $k + 1,
                'ico' => '',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        //第一級 首頁 頁面
        $sort++;
        $parent = DB::table('permissions')->insertGetId([
            'level' => 1,
            'parent' => 0,
            'name' => 'index',
            'guard_name' => 'auth_admin',
            'full_name' => '首頁',
            'is_menu' => 1,
            'is_route' => 1,
            'route' => 'admin/index',
            'active' => 'index',
            'sort' => $sort,
            'ico' => 'fadeIn animated bx bx-home-alt',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第一級 權限管理 選單
        $sort++;
        $parent = DB::table('permissions')->insertGetId([
            'level' => 1,
            'parent' => 0,
            'name' => 'amdin_manage',
            'guard_name' => 'auth_admin',
            'full_name' => '權限管理',
            'is_menu' => 1,
            'is_route' => 0,
            'route' => '',
            'active' => '',
            'sort' => $sort,
            'ico' => 'lni lni-list',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第二級 管理員管理 頁面 查看權限
        $sort++;
        $parent2 = DB::table('permissions')->insertGetId([
            'level' => 2,
            'parent' => $parent,
            'name' => 'admin_list',
            'guard_name' => 'auth_admin',
            'full_name' => '管理員管理',
            'is_menu' => 1,
            'is_route' => 1,
            'route' => 'admin/admin_list',
            'active' => 'admin_list',
            'sort' => $sort,
            'ico' => 'fadeIn animated bx bx-group',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第二級 管理員管理 編輯，刪除權限
        foreach ([['admin_edit', '編輯', 'admin/admin_edit'], ['admin_delete', '刪除', 'admin/admin_delete']] as $k => $v) {
            DB::table('permissions')->insertGetId([
                'level' => 3,
                'parent' => $parent2,
                'name' => $v[0],
                'guard_name' => 'auth_admin',
                'full_name' => $v[1],
                'is_menu' => 0,
                'is_route' => 1,
                'route' => $v[2],
                'active' => '',
                'sort' => $k + 1,
                'ico' => '',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        //第二級 管理員身份 頁面 查看權限
        $sort++;
        $parent2 = DB::table('permissions')->insertGetId([
            'level' => 2,
            'parent' => $parent,
            'name' => 'role_list',
            'guard_name' => 'auth_admin',
            'full_name' => '管理員身份',
            'is_menu' => 1,
            'is_route' => 1,
            'route' => 'admin/role_list',
            'active' => 'role_list',
            'sort' => $sort,
            'ico' => 'fadeIn animated bx bx-user-circle',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第二級 管理員身份 編輯，刪除權限
        foreach ([['role_edit', '編輯', 'admin/role_edit'], ['role_delete', '刪除', 'admin/role_delete']] as $k => $v) {
            DB::table('permissions')->insertGetId([
                'level' => 3,
                'parent' => $parent2,
                'name' => $v[0],
                'guard_name' => 'auth_admin',
                'full_name' => $v[1],
                'is_menu' => 0,
                'is_route' => 1,
                'route' => $v[2],
                'active' => '',
                'sort' => $k + 1,
                'ico' => '',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        //第二級 群組管理 頁面 查看權限
        $sort++;
        $parent2 = DB::table('permissions')->insertGetId([
            'level' => 2,
            'parent' => $parent,
            'name' => 'group_list',
            'guard_name' => 'auth_admin',
            'full_name' => '群組管理',
            'is_menu' => 1,
            'is_route' => 1,
            'route' => 'admin/group_list',
            'active' => 'group_list',
            'sort' => $sort,
            'ico' => 'lni lni-network',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第二級 管理員身份 編輯，刪除權限
        foreach ([['group_edit', '編輯', 'admin/group_edit'], ['group_delete', '刪除', 'admin/group_delete']] as $k => $v) {
            DB::table('permissions')->insertGetId([
                'level' => 3,
                'parent' => $parent2,
                'name' => $v[0],
                'guard_name' => 'auth_admin',
                'full_name' => $v[1],
                'is_menu' => 0,
                'is_route' => 1,
                'route' => $v[2],
                'active' => '',
                'sort' => $k + 1,
                'ico' => '',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        /*
        //第一級 基礎設定 選單
        $sort++;
        $parent = DB::table('permissions')->insertGetId([
            'level' => 1,
            'parent' => 0,
            'name' => 'basic_setting',
            'guard_name' => 'auth_admin',
            'full_name' => '基礎設定',
            'is_menu' => 1,
            'is_route' => 0,
            'route' => '',
            'active' => '',
            'sort' => $sort,
            'ico' => 'lni lni-list',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第二級 首頁設定 選單
        $sort++;
        $parent2 = DB::table('permissions')->insertGetId([
            'level' => 2,
            'parent' => $parent,
            'name' => 'index_setting',
            'guard_name' => 'auth_admin',
            'full_name' => '首頁設定',
            'is_menu' => 1,
            'is_route' => 0,
            'route' => '',
            'active' => '',
            'sort' => $sort,
            'ico' => 'bx bx-right-arrow-alt',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第三級 PC/APP首頁設定 選單
        $sort++;
        $parent3 = DB::table('permissions')->insertGetId([
            'level' => 3,
            'parent' => $parent2,
            'name' => 'pc_app_index_setting',
            'guard_name' => 'auth_admin',
            'full_name' => 'PC/APP首頁設定',
            'is_menu' => 1,
            'is_route' => 0,
            'route' => '',
            'active' => '',
            'sort' => $sort,
            'ico' => 'bx bx-right-arrow-alt',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第四級 Banner設定 選單
        $sort++;
        $parent4 = DB::table('permissions')->insertGetId([
            'level' => 4,
            'parent' => $parent3,
            'name' => 'banner_setting',
            'guard_name' => 'auth_admin',
            'full_name' => 'Banner設定',
            'is_menu' => 1,
            'is_route' => 0,
            'route' => '',
            'active' => '',
            'sort' => $sort,
            'ico' => 'bx bx-right-arrow-alt',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第五級 大Banner 頁面 查看權限
        $sort++;
        $parent5 = DB::table('permissions')->insertGetId([
            'level' => 5,
            'parent' => $parent4,
            'name' => 'pc_app_banner_list',
            'guard_name' => 'auth_admin',
            'full_name' => '大Banner',
            'is_menu' => 1,
            'is_route' => 1,
            'route' => 'admin/pc_app_banner_list',
            'active' => 'pc_app_banner_list',
            'sort' => $sort,
            'ico' => 'lni lni-image',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        //第六級 大Banner 編輯，刪除權限
        $p_list = [
            ['pc_app_banner_edit', '編輯', 'admin/pc_app_banner_edit'],
            ['pc_app_banner_delete', '刪除', 'admin/pc_app_banner_delete']
        ];
        foreach ($p_list as $k => $v) {
            DB::table('permissions')->insertGetId([
                'level' => 6,
                'parent' => $parent5,
                'name' => $v[0],
                'guard_name' => 'auth_admin',
                'full_name' => $v[1],
                'is_menu' => 0,
                'is_route' => 1,
                'route' => $v[2],
                'active' => '',
                'sort' => $k + 1,
                'ico' => '',
                'created_at' => date('Y-m-d H:i:s')
            ]);
        }

        */





    }
}
