<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_grade', function (Blueprint $table) {
            $table->comment = '等級設定表';
            $table->increments('id')->comment('ID');
            $table->string('name',50)->default('')->comment('名稱');
            $table->string('img',225)->default('')->comment('徽章');
            $table->tinyInteger('up_type')->default(1)->comment('升級類型');
            $table->integer('up_exp')->default(0)->comment('升級經驗');
            $table->tinyInteger('expiry_type')->default(0)->comment('會員資格類型');
            $table->integer('expiry_date')->default(0)->comment('會員資格日期');
            $table->integer('keep')->default(0)->comment('續等 %');
            $table->tinyInteger('exp_radio')->default(0)->comment('經驗值');
            $table->text('exp_data')->nullable()->comment('經驗值數據');
            $table->tinyInteger('point_radio')->default(0)->comment('點數回饋');
            $table->text('point_data')->nullable()->comment('點數回饋數據');
            $table->tinyInteger('freight_radio')->default(0)->comment('免運費');
            $table->text('freight_data')->nullable()->comment('免運費數據');
            $table->tinyInteger('discount_radio')->default(0)->comment('折扣券');
            $table->text('discount_data')->nullable()->comment('折扣券數據');
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
        Schema::dropIfExists('yx_grade');
    }
}
