<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWelcomePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_welcome_page', function (Blueprint $table) {
            $table->comment = '歡迎頁表';
            $table->increments('id')->comment('ID');
            $table->tinyInteger('type')->default(0)->comment('類型 1：歡迎 2：廣告');
            $table->string('name',50)->default('')->comment('名稱');
            $table->string('pc_img',120)->default('')->comment('网页版缩图');
            $table->string('phone_img',120)->default('')->comment('手机版缩图');
            $table->tinyInteger('jump_type')->default(0)->comment('跳轉類型');
            $table->string('jump_url')->comment('跳轉URL');
            $table->integer('up_time')->default(0)->comment('上架时间');
            $table->integer('down_time')->default(0)->comment('下架时间');
            $table->tinyInteger('status')->default(1)->comment('顯示狀態:0=關閉,1=開啟');
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
        Schema::dropIfExists('yx_welcome_page');
    }
}
