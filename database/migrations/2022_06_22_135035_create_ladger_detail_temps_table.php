<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLadgerDetailTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ladger_detail_temps', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->string('journal_no');
            $table->date('date');
            $table->date('txn_date')->nullable();
            $table->date('date_split')->nullable();
            $table->string('invoice_no');
            $table->string('ledger_acc_id');
            $table->decimal('ladger_debit_amount', 12,2);
            $table->decimal('ledger_credit_amount', 12,2);
            $table->string('narration');
            $table->decimal('ladger_blnc_debit_amount', 12,2);
            $table->decimal('ladger_blnc_credit_amount', 12,2);
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
        Schema::dropIfExists('ladger_detail_temps');
    }
}
