<?php

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
            $table->string("zip_code")
                ->comment("1 = supplier, 2 -> delivery, 3 -> billing, 4 -> user");
            $table->tinyInteger("address_type");
            $table->bigInteger("link_up_id");
            $table->string("first_mobile_no");
            $table->string("second_mobile_no")->nullable();
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
        Schema::dropIfExists('addresses');
    }
}
