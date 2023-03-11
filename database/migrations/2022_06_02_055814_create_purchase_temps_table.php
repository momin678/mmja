<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_temps', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->integer('po_list')->nullable();
            $table->integer('project_id');
            $table->integer('pr_id');
            $table->integer('supplier_id');
            $table->string('tax_invoice_no');
            $table->date('tax_invoice_date')->nullable();
            $table->string('purchase_no');
            $table->string('temp_purchase_no');
            $table->string('pay_mode');
            $table->integer('pay_term');
            $table->date('pay_date');
            $table->string('shipping_id');
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
        Schema::dropIfExists('purchase_temps');
    }
}
