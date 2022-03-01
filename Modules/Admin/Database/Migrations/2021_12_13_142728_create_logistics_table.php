<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_logistics', function (Blueprint $table) {
            $table->comment = '物流表';
            $table->increments('id');
            $table->string('name',120)->comment('名稱');
            $table->string('freight')->comment('運費');
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
        Schema::dropIfExists('yx_logistics');
    }
}
