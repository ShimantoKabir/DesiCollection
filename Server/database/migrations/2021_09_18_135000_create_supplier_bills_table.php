<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_bills', function (Blueprint $table) {
            $table->id();
            $table->integer("supplierId");
            $table->string("billNumber");
            $table->date("billingDate");
            $table->bigInteger("debitAmount")->comment("Total price of cloth");
            $table->bigInteger("creditAmount")->nullable()->comment("Given amount/deposit amount");
            $table->integer("totalQuantity");
            $table->string("imageName")->nullable();
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
        Schema::dropIfExists('supplier_bills');
    }
}
