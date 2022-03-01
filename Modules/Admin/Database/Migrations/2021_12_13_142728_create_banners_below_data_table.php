<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannersBelowDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_banners_below_data', function (Blueprint $table) {
            $table->comment = '大banner下方数据表';
            $table->increments('id')->comment('ID');
            $table->integer('below_id');
            $table->string('pc_img',120)->default('')->comment('网页版缩图');
            $table->string('phone_img',120)->default('')->comment('手机版缩图');
            $table->tinyInteger('jump_type')->default(0)->comment('操作類型');
            $table->string('jump_url')->nullable()->comment('跳轉URL');
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
        Schema::dropIfExists('yx_banners_below_data');
    }
}
