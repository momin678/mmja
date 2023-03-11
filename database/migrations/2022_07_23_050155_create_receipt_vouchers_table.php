<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipt_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string("temp_rv_no");
            $table->string("rv_no");
            $table->integer("tax_invoice_id");
            $table->integer("project_id");
            $table->integer("customer_id");
            $table->date("date");
            $table->string("payment_method");
            $table->string("check_no")->nullable();
            $table->string("bank_name")->nullable();
            $table->string("branch_name")->nullable();
            $table->string("customer_name")->nullable();
            $table->decimal("total_amount", 10,3);
            $table->decimal("paid_amount", 10,3);
            $table->decimal("due_amount", 10,3);
            $table->integer("status")->default(0);
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
        Schema::dropIfExists('receipt_vouchers');
    }
}
