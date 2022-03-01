<?php

//use Illuminate\Support\Facades\Schema;
use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthsTable extends Migration
{
    /**
     *所需命令行   php artisan module:make DistributionApi
     *1.創建遷移文件：php artisan module:make-migration  create_auths_table Admin
     *php artisan make:migration add_images_to_articles_table --table=articles
     *2.執行遷移文件：php artisan module:migrate Admin
     *3.修改表字段：php artisan module:make-migration update_moments_table
     *4.重新執行遷移文件：php artisan module:migrate-refresh Admin
     *5.創建數據填充文件：php artisan module:make-seed  auths_table_seeder AuthAdmin
     *6.執行數據填充文件：php artisan module:seed AuthAdmin
     */
    public function up()
    {
        /**
         * 管理員表
         */
        Schema::create('auth_admins', function (Blueprint $table) {
            $table->comment = '管理員表';
            $table->increments('id')->comment('管理員ID');
            $table->string('name',100)->default('')->comment('名稱');
            $table->string('phone',100)->default('')->comment('手機號');
            $table->string('email',125)->unique()->default('')->comment('郵箱');
            $table->string('username',50)->unique()->default('')->comment('帳號');
            $table->string('password')->default('')->comment('密碼');
            $table->integer('group_id')->nullable()->comment('組ID');
            $table->integer('project_id')->nullable()->comment('項目ID');
            $table->tinyInteger('status')->default(1)->comment('狀態:0=禁用,1=啟用');
            $table->timestamp('last_login')->nullable()->comment('最後登入時間');
            $table->timestamp('created_at')->nullable()->comment('創建時間');
            $table->timestamp('updated_at')->nullable()->comment('更新時間');
        });

        /**
         * 權限組表
         */
        // Schema::create('auth_groups', function (Blueprint $table) {
        //     $table->comment = '權限組表';
        //     $table->increments('id')->comment('權限組ID');
        //     $table->string('name',100)->unique()->default('')->comment('權限組名稱');
        //     $table->string('content',100)->nullable()->default('')->comment('描述');
        //     $table->tinyInteger('status')->default(1)->comment('狀態:0=禁用,1=啟用');
        //     $table->longtext('rules')->nullable()->comment('權限規則多個用|隔開');
        //     $table->timestamp('created_at')->nullable()->comment('創建時間');
        //     $table->timestamp('updated_at')->nullable()->comment('更新時間');
        // });
        /**
         * 權限列表
         */
        // Schema::create('auth_rules', function (Blueprint $table) {
        //     $table->comment = '權限表';
        //     $table->increments('id')->comment('權限列表ID');
        //     $table->string('path',100)->nullable()->default('')->comment('標識');
        //     $table->string('url',100)->nullable()->default('')->comment('路由文件');
        //     $table->string('redirect',100)->nullable()->default('')->comment('重定向路徑');
        //     $table->string('name',100)->default('')->comment('權限名稱');
        //     $table->tinyInteger('type')->default(1)->comment('菜單類型:1=模塊,2=目錄,3=菜單');
        //     $table->tinyInteger('status')->default(1)->comment('側邊欄顯示狀態:0=隱藏,1=顯示');
        //     $table->tinyInteger('auth_open')->default(1)->comment('是否驗證權限:0=否,1=是');
        //     $table->tinyInteger('level')->default(1)->comment('級別');
        //     $table->tinyInteger('affix')->default(0)->comment('是否固定面板:0=否,1=是');
        //     $table->string('icon',50)->nullable()->default('')->comment('圖標名稱');
        //     $table->integer('pid')->default(0)->comment('父級ID');
        //     $table->integer('sort')->default(1)->comment('排序');
        //     $table->timestamp('created_at')->nullable()->comment('創建時間');
        //     $table->timestamp('updated_at')->nullable()->comment('更新時間');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_admins');
        //Schema::dropIfExists('auth_groups');
        //Schema::dropIfExists('auth_rules');
    }
}
