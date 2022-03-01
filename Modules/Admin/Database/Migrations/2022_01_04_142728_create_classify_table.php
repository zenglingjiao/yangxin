<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassifyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_classify', function (Blueprint $table) {
            $table->comment = '分类表';
            $table->increments('id')->comment('ID');
            $table->string('number')->comment('編號');
            $table->integer('pid')->default(0)->comment('父级ID');
            $table->tinyInteger('lv')->default(1)->comment('层级');
            $table->string('name')->default('')->comment('名称');
            $table->string('img')->default('')->comment('图片');
            $table->tinyInteger('status')->default(1)->comment('顯示狀態:0=关闭,1=顯示');
            $table->integer('sort')->default(1)->comment('排序');
            $table->text('brands')->nullable()->comment('品牌');
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
        Schema::dropIfExists('yx_classify');
    }
}
