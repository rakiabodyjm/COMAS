<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Realdtrbecausepastwasdtr extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtr', function (Blueprint $table) {
            $table->increments('dtr_id');
            $table->integer('assignmentid')->unsigned();
            $table->foreign('assignmentid')->references('assignmentid')->on('assignment');
            $table->integer('summonid')->nullable()->unsigned();
            $table->foreign('summonid')->references('summonid')->on('summon');
            $table->double('time');
            $table->date('date');

            $table->unique([
                'assignmentid',
                'summonid', 
                'date'
            ]);
        });
       
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtr');
    }
}
