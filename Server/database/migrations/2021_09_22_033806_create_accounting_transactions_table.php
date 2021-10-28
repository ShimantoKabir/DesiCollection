<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountingTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounting_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('org_id');
            $table->double('dr_amt')->nullable();
            $table->double('cr_amt')->nullable();
            $table->integer('chq_no')->nullable();
            $table->date('chq_date')->nullable();
            $table->string('narration')->nullable();
            $table->string('voucher_no');
            $table->date('voucher_date');
            $table->tinyInteger('voucher_type_id');
            $table->string('reference_number')->nullable();
            $table->integer('chart_of_account_oid');
            $table->integer('chart_of_account_root_oid');
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
        Schema::dropIfExists('accounting_transactions');
    }
}
