<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStockTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transections', function (Blueprint $table) {
            $table->id();
            // $table->string('stock_no')->unique();
            // $table->string('brand_no')->nullable();
            // $table->string('type');
            $table->string('item_id');
            $table->date('date')->nullable();
            $table->string('transection_id');
            $table->integer('quantity')->default(0);
            // $table->string('vat_amount');
            // $table->string('rate');
            // $table->decimal('taxable_suppliers',12,2);
            // $table->decimal('total_amount',12,2);
            // $table->integer('stock_balance')->default(0);
            // $table->integer('stock_value')->default(0);
            // $table->integer('cogs_rate')->default(0);
            $table->string('stock_effect');
            $table->string('tns_type_code')->nullable();
            $table->string('tns_description')->nullable();
            $table->decimal('cost_price',12,3)->nullable();
            $table->integer('cost_vat')->nullable();
            $table->string('consumed')->nullable();
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
        Schema::dropIfExists('stock_transections');
    }
}
