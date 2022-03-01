<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_areas', function (Blueprint $table) {
            $table->comment = '地區表';
            $table->increments('id')->comment('地區表ID');
            $table->integer('pid')->default(0)->comment('父級ID');
            $table->string('name',50)->default('')->comment('名稱');
            $table->string('short_name',50)->default('')->comment('簡稱');
            $table->tinyInteger('level_type')->default(1)->comment('級別');
            $table->integer('city_code')->nullable()->comment('區號');
            $table->integer('zip_code')->nullable()->comment('郵編');
            $table->string('lng',50)->nullable()->comment('經度');
            $table->string('lat',50)->nullable()->comment('緯度');
            $table->string('pinyin',50)->nullable()->comment('拼音');
            $table->tinyInteger('status')->default(1)->comment('顯示狀態:0=隱藏,1=顯示');
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
        Schema::dropIfExists('auth_areas');
    }
}
