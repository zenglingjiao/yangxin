<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersKayouTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_banners_kayou', function (Blueprint $table) {
            $table->comment = '卡友好康表';
            $table->increments('id');
            $table->string('name',50)->comment('名稱');
            $table->string('img')->nullable()->comment('圖片');
            $table->integer('up_time')->comment('上架時間');
            $table->integer('down_time')->comment('下架時間');
            $table->tinyInteger('jump_type')->default(0)->comment('操作類型');
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
        Schema::dropIfExists('yx_banners_kayou');
    }
}
