<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFifoInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fifo_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('fifo_id');
            $table->integer('invoice_id')->nullable();
            $table->integer('delivery_note_id')->nullable();
            $table->integer('item_id');
            $table->integer('quantity');
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
        Schema::dropIfExists('fifo_invoices');
    }
}
