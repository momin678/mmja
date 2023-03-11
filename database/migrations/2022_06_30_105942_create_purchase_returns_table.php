<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->id();
            $table->string("purchase_return_no");
            $table->integer("temp_purchase_return_no");
            $table->string("po_no");
            $table->string("gr_no");
            $table->string("project_id");
            $table->string("supplier_id");
            $table->string('challan_number')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string("state");
            $table->date('date');
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
        Schema::dropIfExists('purchase_returns');
    }
}
