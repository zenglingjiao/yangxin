<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdvertisementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_advertisement', function (Blueprint $table) {
            $table->comment = '廣告表';
            $table->increments('id');
            $table->string('name',50)->comment('名稱');
            $table->string('type',10)->comment('類型 up：上 down：下');
            $table->string('pc_img')->nullable()->comment('電腦圖片');
            $table->string('phone_img')->nullable()->comment('手機圖片');
            $table->integer('up_time')->comment('上架時間');
            $table->integer('down_time')->comment('下架時間');
            $table->tinyInteger('jump_type')->nullable()->comment('操作類型');
            $table->string('jump_url')->nullable()->comment('跳轉URL');
            $table->integer('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('yx_advertisement');
    }
}
