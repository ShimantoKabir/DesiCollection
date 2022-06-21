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
            $table->string("imageName");
            $table->tinyInteger("imageType");
            $table->boolean("isActive")->default(false);
            $table->integer("referenceId")
                ->comment("can be user id/ can be product id/ others");
            $table->string("ip")->nullable();
            $table->dateTime("createdAt");
            $table->dateTime("updatedAt")->nullable();
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
        Schema::dropIfExists('app_images');
    }
}
