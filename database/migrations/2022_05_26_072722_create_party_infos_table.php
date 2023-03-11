<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartyInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('party_infos', function (Blueprint $table) {
            $table->id();
            $table->string('pi_code')->unique();
            $table->string('pi_name');
            $table->string('pi_type');
            $table->string('trn_no')->nullable();
            $table->string('address')->nullable();
            $table->string('con_person')->nullable();
            $table->string('con_no')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('email')->nullable();
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
        Schema::dropIfExists('party_infos');
    }
}
