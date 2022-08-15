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
            $table->integer("typeId")->nullable();
            $table->integer("sizeId")->nullable();
            $table->integer("colorId")->nullable();
            $table->integer("brandId")->nullable();
            $table->integer("fabricId")->nullable();
            $table->integer("userAgeId")->nullable();
            $table->string("billNumber");
            $table->integer("userTypeId")->nullable();
            $table->integer("totalQuantity");
            $table->integer("vatPercentage")->default(0);
            $table->integer("availableQuantity");
            $table->integer("minOfferPercentage");
            $table->integer("minProfitPercentage");
            $table->integer("singlePurchasePrice");
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
