<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayPoundageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_pay_poundage', function (Blueprint $table) {
            $table->comment = '支付手續費表';
            $table->increments('id');
            $table->integer('pay_id')->comment('支付ID');
            $table->string('name',50)->comment('名称');
            $table->integer('nper')->comment('期數');
            $table->string('rate','5')->comment('手續費');
            $table->string('note')->comment('備註說明');
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
        Schema::dropIfExists('yx_pay_poundage');
    }
}
