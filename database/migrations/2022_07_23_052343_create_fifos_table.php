<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFifosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fifos', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('purchase_id');
            $table->integer('quantity');
            $table->decimal('unit_cost_price');
            $table->integer('consumed');
            $table->integer('remaining');
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
        Schema::dropIfExists('fifos');
    }
}
