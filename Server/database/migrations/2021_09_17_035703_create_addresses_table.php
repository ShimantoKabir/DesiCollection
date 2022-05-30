<?php

use App\Enums\AddressType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string("city");
            $table->string("email")->nullable();
            $table->string("detail");
            $table->string("country");
            $table->string("zipCode");
            $table->tinyInteger('addressType')->default(0);
            $table->bigInteger("linkUpId");
            $table->string("firstMobileNo");
            $table->string("secondMobileNo")->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
