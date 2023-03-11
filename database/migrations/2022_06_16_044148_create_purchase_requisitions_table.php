<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->id();
            $table->integer('project_id');
            $table->integer('supplier_id')->nullable();
            $table->string('tax_invoice_no')->nullable();
            $table->string('temp_purchase_no')->nullable();
            $table->date('tax_invoice_date')->nullable();
            $table->string('purchase_no');
            $table->string('pay_mode')->nullable();
            $table->integer('pay_term')->nullable();
            $table->date('pay_date')->nullable();
            $table->string('shipping_id')->nullable();
            $table->date('date');
            $table->tinyInteger('status')->default(0);
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
        Schema::dropIfExists('purchase_requisitions');
    }
}
