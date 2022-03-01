<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandRecommendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_brand_recommend', function (Blueprint $table) {
            $table->comment = '品牌推薦表';
            $table->increments('id')->comment('ID');
            $table->integer('brand_id')->comment('品牌ID');
            $table->tinyInteger('status')->default(1)->comment('狀態');
            $table->tinyInteger('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('yx_brand_recommend');
    }
}
