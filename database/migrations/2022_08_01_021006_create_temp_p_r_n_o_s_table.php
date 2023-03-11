<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempPRNOSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_p_r_n_o_s', function (Blueprint $table) {
            $table->id();
            $table->integer('pr_no')->nullable();
            $table->integer('po_no')->nullable();
            $table->integer('gr_no')->nullable();
            $table->integer('ip_no')->nullable();
            $table->integer('pt_no')->nullable();
            $table->integer('pv_no')->nullable();
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
        Schema::dropIfExists('temp_p_r_n_o_s');
    }
}
