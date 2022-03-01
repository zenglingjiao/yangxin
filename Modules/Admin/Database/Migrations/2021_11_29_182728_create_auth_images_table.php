<?php
use Jialeo\LaravelSchemaExtend\Schema;
//use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auth_images', function (Blueprint $table) {
            $table->comment = '圖片表';
            $table->increments('id')->comment('圖片ID');
            $table->string('url',150)->default('')->comment('圖片路徑');
            $table->tinyInteger('status')->default(1)->comment('狀態:0=已刪除,1=應用中');
            $table->tinyInteger('open')->default(1)->comment('類型:1=本地,2=七牛雲');
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
        Schema::dropIfExists('auth_images');
    }
}
