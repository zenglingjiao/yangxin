<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuFooterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_menu_footer', function (Blueprint $table) {
            $table->comment = '頁腳菜單表';
            $table->increments('id');
            $table->integer('pid')->default(0);
            $table->string('name',50)->comment('名稱');
            $table->tinyInteger('type')->default(0)->comment('類型');
            $table->string('link')->default('')->comment('鏈接');
            $table->tinyInteger('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('狀態');
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
        Schema::dropIfExists('yx_menu_footer');
    }
}
