<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_brand', function (Blueprint $table) {
            $table->comment = '品牌表';
            $table->increments('id')->comment('ID');
            $table->string('zh_name',50)->default('')->comment('中文名稱');
            $table->string('en_name',50)->default('')->comment('英文名稱名稱');
            $table->string('logo')->comment('LOGO');
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
        Schema::dropIfExists('yx_brand');
    }
}
