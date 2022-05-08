<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductUserAgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_user_ages', function (Blueprint $table) {
            $table->id();
            $table->integer("minAge")->nullable();
            $table->integer("maxAge")->nullable();
            $table->integer("fixedAge")->nullable();
            $table->string("ip")->nullable();
            $table->dateTime("createdAt");
            $table->dateTime("updatedAt");
            $table->integer("modifiedBy")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_user_ages');
    }
}
