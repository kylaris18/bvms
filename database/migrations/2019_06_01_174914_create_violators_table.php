<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViolatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violators', function (Blueprint $table) {
            $table->bigIncrements('violator_id');
            $table->string('violator_lname');
            $table->string('violator_fname');
            $table->string('violator_mname');
            $table->integer('violator_count');
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
        Schema::dropIfExists('violators');
    }
}
