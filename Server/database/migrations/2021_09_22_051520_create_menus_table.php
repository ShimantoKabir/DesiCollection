<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->integer('oid');
            $table->string('href')->nullable();
            $table->string('icon')->nullable();
            $table->integer('tree_id');
            $table->integer('for_whom')->comment("1 - admin, 2 - customer");
            $table->string('menu_name')->nullable();
            $table->integer("is_active")->default(1);
            $table->integer('parent_tree_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
