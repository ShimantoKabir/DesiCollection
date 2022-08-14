<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_infos', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('token')->nullable();
            $table->tinyInteger('for_whom')->comment("1 - admin, 2 - customer");  // not nullable
            $table->tinyInteger("role_oid")->nullable();
            $table->string('password'); // not nullable
            $table->string('last_name')->nullable();
            $table->string("op_access")->comment("C, R, U, D, CR, CU, CD, RU, RD, UD, CRU, CRD, CUD, RUD, CRUD"); // not nullable
            $table->string('user_name')->nullable();
            $table->tinyInteger('is_active')->default(0);
            $table->string('session_id')->nullable();
            $table->string('first_name')->nullable();
            $table->tinyInteger('is_approved')->default(0);
            $table->string('mobile_number')->nullable();
            $table->string('social_login_id')->nullable();
            $table->string("restricted_menu_oid")->nullable();
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
        Schema::dropIfExists('user_infos');
    }
}
