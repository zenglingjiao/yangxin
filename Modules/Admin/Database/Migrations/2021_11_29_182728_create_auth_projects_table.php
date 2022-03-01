<?php

//use Illuminate\Support\Facades\Schema;
use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_projects', function (Blueprint $table) {
            $table->comment = '平臺項目表';
            $table->increments('id')->comment('項目ID');
            $table->string('name',100)->default('')->comment('項目名稱');
            $table->integer('logo_id')->nullable()->comment('站點logo');
            $table->integer('ico_id')->nullable()->comment('站點標識');
            $table->string('url',100)->default('')->comment('項目地址');
            $table->string('description')->default('')->comment('項目描述');
            $table->string('keywords')->default('')->comment('項目關鍵詞');
            $table->tinyInteger('status')->default(1)->comment('狀態:0=禁用,1=啟用');
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
        Schema::dropIfExists('auth_projects');
    }
}
