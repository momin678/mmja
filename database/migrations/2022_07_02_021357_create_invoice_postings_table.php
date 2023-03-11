<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicePostingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_postings', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_posting_no');
            $table->string('temp_invoice_posting_no');
            $table->string('goods_received_no');
            $table->string('po_no');
            $table->string('pr_no');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('delivery_note');
            $table->integer('is_paid')->default(0);
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
        Schema::dropIfExists('invoice_postings');
    }
}
