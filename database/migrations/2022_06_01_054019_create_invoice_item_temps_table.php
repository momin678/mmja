<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_item_temps', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->string('item_id');
            $table->string('style_id');
            $table->string('color_id');
            $table->string('size');
            $table->integer('barcode');
            $table->integer('quantity');
            $table->decimal('cost_price',12,3);
            $table->decimal('net_amount',12,3);
            $table->string('vat_rate');
            $table->decimal('unit_price',12,3);
            $table->string('unit');
            $table->decimal('total_unit_price',12,3);
            $table->decimal('purchase_price',12,3);
            $table->decimal('vat_amount',12,3);
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
        Schema::dropIfExists('invoice_item_temps');
    }
}
