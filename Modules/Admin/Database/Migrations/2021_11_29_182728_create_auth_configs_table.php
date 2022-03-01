<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_configs', function (Blueprint $table) {
            $table->comment = '系統配置表';
            $table->increments('id')->comment('系統配置ID');
            $table->string('name',100)->default('')->comment('站點名稱');
            $table->tinyInteger('image_status')->nullable()->comment('圖片儲存:1=本地,2=七牛雲');
            $table->integer('logo_id')->nullable()->comment('站點logo');
            $table->text('about_us')->nullable()->comment('關於我們');
            $table->timestamp('created_at')->nullable()->comment('創建時間');
            $table->timestamp('updated_at')->nullable()->comment('更新時間');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auth_configs');
    }
}
