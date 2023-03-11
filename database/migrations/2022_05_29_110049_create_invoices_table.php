<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->string('sale_order_id')->nullable();
            $table->string('delivery_note_id')->nullable();
            $table->date('date');
            $table->string('customer_name');
            $table->string('gl_code')->nullable();
            $table->string('project_id');
            $table->string('trn_no')->nullable();
            $table->string('pay_mode');
            $table->string('pay_terms');
            $table->string('due_date');
            $table->string('contact_no')->nullable();
            $table->string('address')->nullable();
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
        Schema::dropIfExists('invoices');
    }
}
