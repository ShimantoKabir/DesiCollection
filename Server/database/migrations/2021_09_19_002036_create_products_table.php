<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->integer("typeId");
            $table->integer("sizeId");
            $table->integer("colorId");
            $table->integer("brandId");
            $table->integer("fabricId");
            $table->integer("userAgeId");
            $table->integer("billNumber");
            $table->integer("userTypeId");
            $table->integer("totalQuantity");
            $table->integer("availableQuantity");
            $table->integer("maxOfferPercentage");
            $table->integer("maxProfitPercentage");
            $table->integer("singlePurchasePrice");
            $table->json("imageIds");
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
        Schema::dropIfExists('products');
    }
}
