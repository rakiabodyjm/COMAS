<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Inventory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::dropIfExists('inventory');
        Schema::create('inventory', function (Blueprint $table) {

            $table->increments('inventoryid');
            $table->text('name');
            $table->string('classification');
            $table->integer('quantity');
            $table->integer('restrictionid')->nullable()->unsigned();
            $table->foreign('restrictionid')->references('skillid')->on('skills');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
