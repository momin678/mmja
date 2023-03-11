<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->integer('style_id')->nullable();
            $table->string('group_no')->nullable();
            $table->string('group_name')->nullable();
            $table->string('barcode');
            $table->string('item_name');
            $table->string('brand_id');
            $table->string('country');
            $table->string('unit');
            $table->string('description')->nullable();
            $table->decimal('sell_price', 10,3);
            $table->string('vat_rate');
            $table->decimal('vat_amount', 10,3);
            $table->decimal('total_amount', 10,3);
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
        Schema::dropIfExists('items');
    }
}
