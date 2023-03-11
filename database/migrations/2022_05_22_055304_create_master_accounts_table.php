<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('mst_ac_code')->unique();
            $table->string('mst_ac_head');
            $table->string('mst_definition');
            $table->string('mst_ac_type');
            $table->string('vat_type');
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
        Schema::dropIfExists('master_accounts');
    }
}
