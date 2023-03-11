<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempItemStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_item_stores', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_no');
            $table->integer('brand_id');
            $table->string('group_id');
            $table->integer('item_list_id');
            $table->string('shipping_id');
            $table->integer('purchase_rate');
            $table->integer('quantity');
            $table->string('unit');
            $table->string('vat_rate');
            $table->string('taxable_supplies');
            $table->integer('vat_amount');
            $table->integer('total_amount');
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
        Schema::dropIfExists('temp_item_stores');
    }
}
