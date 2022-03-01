<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_keyword_history', function (Blueprint $table) {
            $table->comment = '搜尋歷史表';
            $table->increments('id');
            $table->string('keyword',120)->comment('搜尋詞');
            $table->integer('num')->default(0)->comment('搜尋次數');
            $table->timestamp('created_at')->nullable()->comment('創建時間');
            $table->timestamp('updated_at')->nullable()->comment('更新時間');
            $table->unique(['keyword']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('yx_keyword_history');
    }
}
