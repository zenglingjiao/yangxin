<?php
//use Illuminate\Support\Facades\Schema;
use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAuthUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('auth_users', function (Blueprint $table) {
            /* $table->comment = '平臺用戶表';
             $table->increments('id')->comment('用戶ID');
             $table->string('name',100)->default('')->comment('姓名');
             $table->string('nickname',100)->default('')->comment('昵稱');
             $table->string('phone',100)->unique()->default('')->comment('手機號');
             $table->string('email',50)->unique()->default('')->comment('郵箱');
             $table->string('password')->default('')->comment('密碼');
             $table->integer('province_id')->nullable()->comment('省ID');
             $table->integer('city_id')->nullable()->comment('市ID');
             $table->integer('county_id')->nullable()->comment('區縣ID');
             $table->tinyInteger('status')->default(1)->comment('狀態:0=拉黑,1=正常');
             $table->tinyInteger('sex')->default(0)->comment('性別:0=未知,1=男，2=女');
             $table->string('birth',20)->default('')->comment('出生年月日');
             $table->timestamp('created_at')->nullable()->comment('創建時間');
             $table->timestamp('updated_at')->nullable()->comment('更新時間');*/
            $table->tinyInteger('is_yangxin')->default(0)->comment("陽信卡友 0否1是");
            $table->tinyInteger('register_way')->default(1)->comment("註冊方式");
            $table->tinyInteger('register_device')->default(0)->comment("註冊裝置 1 web 2app");
            $table->tinyInteger('is_group_lord')->default(0)->comment("團購主 0否1是");
            $table->tinyInteger('grade_id')->default(1)->comment("等級ID");
            $table->unsignedBigInteger('point')->default(0)->comment("點數");
            $table->timestamp('last_buy_time')->nullable()->comment('最後下單時間');
            $table->timestamp('last_login_time')->nullable()->comment('最後登錄時間');
            $table->tinyInteger('is_say')->default(1)->comment('發言狀態 0 禁止 1允許 ');
            $table->tinyInteger('is_epaper')->default(0)->comment('訂閱電子報 0 否 1 是 ');
            $table->string('recommend_code',10)->unique('recommend_code')->comment('我的推薦碼');
            $table->integer('exp')->default(0)->comment('經驗值');
            $table->string('member_expiry_date',10)->default('')->comment('會員到期日期');
            $table->integer('inviter_id')->default(0)->comment('邀請人ID');
            $table->string('inviter_code',10)->default('')->comment('邀請人推薦碼');
            $table->text('remark')->nullable()->comment('備註');
            $table->string('email',50)->nullable()->comment('郵箱')->change();;

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('auth_users', function (Blueprint $table) {
            $table->drop_column('is_yangxin');
        });
    }
}
