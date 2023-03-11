<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->string('sale_order_no')->unique();
            $table->date('date');
            $table->string('customer_name');
            $table->string('gl_code');
            $table->string('project_id');
            $table->string('trn_no');
            $table->string('pay_mode');
            $table->string('pay_terms');
            $table->string('due_date');
            $table->string('contact_no');
            $table->string('address');
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
        Schema::dropIfExists('sale_orders');
    }
}
