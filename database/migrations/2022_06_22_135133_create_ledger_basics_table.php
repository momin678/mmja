<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgerBasicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledger_basics', function (Blueprint $table) {
            $table->id();
            $table->string('journal_no');
            $table->string('ledger_acc_id');
            $table->decimal('ladger_debit_amount', 12,2);
            $table->decimal('ledger_credit_amount', 12,2);
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
        Schema::dropIfExists('ledger_basics');
    }
}
