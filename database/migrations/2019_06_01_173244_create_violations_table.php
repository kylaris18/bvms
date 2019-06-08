<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->bigIncrements('violation_id');
            $table->integer('type_id');
            $table->integer('account_id');
            $table->integer('violation_violator');
            $table->string('violation_date');
            $table->integer('violation_status');
            $table->string('violation_report');
            $table->string('violation_resolution')->nullable();
            $table->string('violation_notes');
            $table->string('violation_photo');
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
        Schema::dropIfExists('violations');
    }
}
