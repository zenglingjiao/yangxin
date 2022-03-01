<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnexeHotDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_annexe_hot_data', function (Blueprint $table) {
            $table->comment = '熱門館別數據表';
            $table->increments('id');
            $table->integer('hot_id')->comment('熱門館別ID');
            $table->string('pc_img')->comment('電腦圖片');
            $table->string('phone_img')->comment('手機圖片');
            $table->tinyInteger('annexe_id')->nullable()->comment('館別ID');
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
        Schema::dropIfExists('yx_annexe_hot_data');
    }
}
