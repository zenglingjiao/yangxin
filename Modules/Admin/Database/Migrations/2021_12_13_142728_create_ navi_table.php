<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNaviTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_navi', function (Blueprint $table) {
            $table->comment = '導航欄表';
            $table->increments('id')->comment('ID');
            $table->string('type',50)->default('')->comment('類型');
            $table->string('name',50)->default('')->comment('名稱');
            $table->integer('jump_type')->default(0)->comment('操作類型');
            $table->string('jump_url')->nullable()->comment('跳轉URL');
            $table->integer('sort')->default(0)->comment('排序');
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
        Schema::dropIfExists('yx_navi');
    }
}
