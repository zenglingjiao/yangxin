<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_banners_member', function (Blueprint $table) {
            $table->comment = '會員專區表';
            $table->increments('id');
            $table->string('name',50)->comment('名稱');
            $table->integer('up_time')->comment('上架時間');
            $table->integer('down_time')->comment('下架時間');
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
        Schema::dropIfExists('yx_banners_member');
    }
}
