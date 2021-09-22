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
            $table->integer("size_id");
            $table->integer("color_id");
            $table->integer("brand_id");
            $table->integer("quantity");
            $table->integer("fabric_id");
            $table->integer("bill_number");
            $table->integer("user_type_id");
            $table->integer("purchased_price");
            $table->integer("product_type_id");
            $table->integer("offer_percentage");
            $table->integer("profit_percentage");
            $table->integer("available_quantity");
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
        Schema::dropIfExists('products');
    }
}
