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
            $table->integer('srl');
            $table->integer('org_id');
            $table->double('dr_amt')->nullable();
            $table->double('cr_amt')->nullable();
            $table->integer('chq_no')->nullable();
            $table->date('chq_date')->nullable();
            $table->string('narration')->nullable();
            $table->string('voucher_no');
            $table->tinyInteger('voucher_type')->comment("1 = cash payment, 2 = cash receive, 3 = bank payment, 4 = bank receive, 5 = journal receive");
            $table->date('voucher_date');
            $table->string('reference_number');
            $table->integer('chart_of_account_oid');
            $table->integer('chart_of_account_root_oid');
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
        Schema::dropIfExists('accounting_transactions');
    }
}