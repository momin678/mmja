<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_order_items', function (Blueprint $table) {
            $table->id();
            $table->string('sale_order_no');
            $table->string('sale_order_id');
            $table->string('item_id');
            $table->string('color_id');
            $table->string('size');
            $table->string('style_id');
            $table->integer('barcode');
            $table->integer('quantity');
            $table->decimal('cost_price',12,2);
            $table->decimal('net_amount',12,2);
            $table->string('vat_rate');
            $table->decimal('vat_amount',12,2);
            $table->string('unit');
            $table->decimal('unit_price',12,2);
            $table->decimal('total_unit_price',12,2);
            $table->softDeletes();

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
        Schema::dropIfExists('sale_order_items');
    }
}
