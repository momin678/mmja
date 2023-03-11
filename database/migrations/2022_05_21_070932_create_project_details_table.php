<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_details', function (Blueprint $table) {
            $table->id();
            $table->string('proj_no')->unique();
            $table->string('pc_code');
            $table->string('proj_name');
            $table->string('proj_type');
            $table->string('cons_agent');
            $table->string('address');
            $table->string('owner_name');
            $table->string('cont_no');
            $table->date('ord_date');
            $table->date('hnd_over_date');
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
        Schema::dropIfExists('project_details');
    }
}
