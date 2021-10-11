<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_images', function (Blueprint $table) {
            $table->id();
            $table->string("image_url");
            $table->boolean("is_active")->default(false);
            $table->integer("reference_id")->comment("can be user id/ can be product id/ others");
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
        Schema::dropIfExists('app_images');
    }
}
