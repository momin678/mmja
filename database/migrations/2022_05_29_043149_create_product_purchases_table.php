<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('po_list')->nullable();
            $table->integer('project_id');
            $table->date('tax_invoice_date');
            $table->string('serial_no');
            $table->integer('supplier_id');
            $table->string('trn');
            $table->string('pay_mode');
            $table->integer('pay_term');
            $table->date('pay_date');
            $table->string('tax_invoice_no');
            $table->integer('grand_total');
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
        Schema::dropIfExists('product_purchases');
    }
}
