<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Inventorytransfer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventorytransfer', function (Blueprint $table) {
            $table->increments('transferid');

            $table->integer('inventoryid')->unsigned();
            $table->foreign('inventoryid')->references('inventoryid')->on('inventory');

            $table->integer('projectname')->unsigned()->nullable();
            $table->foreign('projectname')->references('projectid')->on('project');

            $table->integer('employeeid')->unsigned()->nullable();
            $table->foreign('employeeid')->references('employeeid')->on('employees');

            $table->integer('quantity');
            $table->date('date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventorytransfer');
    }
}
