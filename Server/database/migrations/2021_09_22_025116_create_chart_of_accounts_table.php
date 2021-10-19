<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChartOfAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chart_of_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer("oid");
            $table->string("path");
            $table->integer("org_id");
            $table->integer("tree_id");
            $table->tinyInteger("is_ledger")->comment("0 - no, 1 - yes");
            $table->tinyInteger("is_editable")->comment("0 - no, 1 - yes");
            $table->string("account_name");
            $table->integer("parent_tree_id");
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
        Schema::dropIfExists('chart_of_accounts');
    }
}
