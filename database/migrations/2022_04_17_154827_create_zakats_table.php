<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZakatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zakats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount');
            $table->enum('type', ['Donasi', 'Fitrah']);
            $table->integer('people_id')->unsigned();
            $table->foreign('people_id')->references('id')->on('people')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('amount_type_id')->unsigned();
            $table->foreign('amount_type_id')->references('id')->on('satuan_zakats')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('zakats');
    }
}
