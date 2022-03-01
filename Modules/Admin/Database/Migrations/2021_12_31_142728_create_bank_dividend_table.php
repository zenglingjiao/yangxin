<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankDividendTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_bank_dividend', function (Blueprint $table) {
            $table->comment = '銀行紅利表';
            $table->increments('id')->comment('ID');
            $table->string('name',50)->default('')->comment('名稱');
            $table->string('pc_img',120)->default('')->comment('网页版缩图');
            $table->string('phone_img',120)->default('')->comment('手机版缩图');
            $table->text('remark')->nullable()->comment('備註說明');
            $table->tinyInteger('status')->default(1)->comment('顯示狀態:0=关闭,1=顯示');
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
        Schema::dropIfExists('yx_bank_dividend');
    }
}
