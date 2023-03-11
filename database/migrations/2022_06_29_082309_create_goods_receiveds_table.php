<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoodsReceivedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_receiveds', function (Blueprint $table) {
            $table->id();
            $table->string('goods_received_no');
            $table->string('temp_goods_received_no');
            $table->string("po_no");
            $table->string("pr_no");
            $table->string("project_id");
            $table->string("supplier_id");
            $table->integer('is_invoice_posted')->default(0);
            $table->string('challan_number')->nullable();
            $table->date('date');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('goods_receiveds');
    }
}
