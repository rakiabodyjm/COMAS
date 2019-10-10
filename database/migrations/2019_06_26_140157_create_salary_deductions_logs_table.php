<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaryDeductionsLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salarydeductionlogs', function (Blueprint $table) {
            $table->increments('sdlogs_id');
            $table->integer('salarydeductionsid')->unsigned();
            $table->foreign('salarydeductionsid')->references('salarydeductionsid')->on('salarydeductions');
            $table->date('sdlogs_date');
            $table->double('sdlogs_amount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salarydeductionlogs');
    }
}
