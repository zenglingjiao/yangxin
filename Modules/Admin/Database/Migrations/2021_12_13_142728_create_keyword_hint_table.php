<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordHintTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yx_keyword_hint', function (Blueprint $table) {
            $table->comment = '搜尋提示詞表';
            $table->increments('id');
            $table->string('keyword',120)->comment('提示詞');
            $table->tinyInteger('weight')->default(0)->comment('權重 0：低 1：中 2：高');
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
        Schema::dropIfExists('yx_keyword_hint');
    }
}
