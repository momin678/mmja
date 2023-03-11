<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('payment_voucher_no');
            $table->string('temp_payment_voucher_no');
            $table->string('ip_no');
            $table->string('goods_received_no');
            $table->string('po_no');
            $table->string('pr_no');
            $table->unsignedBigInteger('supplier_id');
            $table->date('date');
            $table->string('payment_method');
            $table->decimal("paid_amount", 10, 2);
            $table->decimal("due_amount", 10, 2);
            $table->string("check_no")->nullable();
            $table->string("bank_name")->nullable();
            $table->string("branch_name")->nullable();
            $table->string("supplier_name")->nullable();
            $table->integer('status')->default(0);
            $table->string('state');
            $table->integer("is_paid")->nullable();
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
        Schema::dropIfExists('payment_vouchers');
    }
}
