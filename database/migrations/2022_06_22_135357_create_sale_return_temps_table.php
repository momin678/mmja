<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return_temps', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no');
            $table->string('item_id');
            $table->integer('barcode');
            $table->integer('quantity');
            $table->string('unit');
            $table->decimal('unit_price',12,2);
            $table->decimal('discount',12,2);
            $table->decimal('net_amount',12,2);
            $table->decimal('cost_price',12,2);
            $table->string('vat_rate');
            $table->string('vat_amount');
            $table->decimal('total_unit_price',12,2);
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
        Schema::dropIfExists('sale_return_temps');
    }
}
