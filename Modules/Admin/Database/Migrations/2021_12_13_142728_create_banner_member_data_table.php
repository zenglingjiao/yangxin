<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerMemberDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_banners_member_data', function (Blueprint $table) {
            $table->comment = '會員專區數據表';
            $table->increments('id');
            $table->integer('member_id')->comment('會員專區ID');
            $table->string('img')->comment('圖片');
            $table->tinyInteger('jump_type')->nullable()->comment('操作類型');
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
        Schema::dropIfExists('yx_banners_member_data');
    }
}
