<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransectionDefinitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transection_definitions', function (Blueprint $table) {
            $table->id();
            $table->string('trn_desc');
            $table->string('trns_code');
            $table->string('trn_type');
            $table->string('trn_type_code');
            $table->string('stock_effect');
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
        Schema::dropIfExists('transection_definitions');
    }
}
