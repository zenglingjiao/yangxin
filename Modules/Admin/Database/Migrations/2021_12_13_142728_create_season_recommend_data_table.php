<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeasonRecommendDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_season_recommend_data', function (Blueprint $table) {
            $table->comment = '強檔推薦數據表';
            $table->increments('id');
            $table->integer('recommend_id')->comment('強檔推薦ID');
            $table->string('img')->comment('圖片');
            $table->tinyInteger('activity_id')->nullable()->comment('活動ID');
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
        Schema::dropIfExists('yx_season_recommend_data');
    }
}
