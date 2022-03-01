<?php

//use Illuminate\Support\Facades\Schema;
use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\PermissionRegistrar;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('guard_name'); // For MySQL 8.0 use string('guard_name', 125);
            $table->tinyInteger('status')->default(1)->comment('狀態:0=禁用,1=啟用');
            $table->timestamps();
        });

        Schema::create('group_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger(PermissionRegistrar::$pivotRole);

            $table->string('model_type');
            $table->unsignedBigInteger('group_id');
            $table->index(['group_id', 'model_type'], 'group_has_roles_group_id_model_type_index');

            $table->foreign(PermissionRegistrar::$pivotRole)
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            $table->primary([PermissionRegistrar::$pivotRole, 'group_id', 'model_type'],
                'group_has_roles_role_model_type_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groups');
        Schema::dropIfExists('group_has_roles');
    }
}
