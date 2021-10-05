<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuPermissionForRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_permission_for_roles', function (Blueprint $table) {
            $table->id();
            $table->integer('role_oid');
            $table->integer('menu_oid');
            $table->string("ip")->nullable();
            $table->timestamps();
            $table->integer("modified_by")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_permission_for_roles');
    }
}
