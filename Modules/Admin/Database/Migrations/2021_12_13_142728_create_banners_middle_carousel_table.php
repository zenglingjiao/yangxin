<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersMiddleCarouselTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_banners_middle_carousel', function (Blueprint $table) {
            $table->comment = '中間輪播廣告表';
            $table->increments('id')->comment('banner大图ID');
            $table->string('name',50)->default('')->comment('名稱');
            $table->string('pc_img',120)->default('')->comment('网页版缩图');
            $table->string('phone_img',120)->default('')->comment('手机版缩图');
            $table->integer('up_time')->default(0)->comment('上架时间');
            $table->integer('down_time')->default(0)->comment('下架时间');
            $table->tinyInteger('jump_type')->default(0)->comment('操作類型');
            $table->string('jump_url')->nullable()->comment('跳轉URL');

            $table->tinyInteger('status')->default(1)->comment('顯示狀態:0=关闭,1=顯示');
            $table->integer('sort')->default(1)->comment('排序');
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
        Schema::dropIfExists('yx_banners_middle_carousel');
    }
}
