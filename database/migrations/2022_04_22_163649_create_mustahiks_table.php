<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMustahiksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mustahiks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('rt_id')->unsigned();
            $table->foreign('rt_id')->references('id')->on('rts')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('rw_id')->unsigned();
            $table->foreign('rw_id')->references('id')->on('rws')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('mustahik_type_id')->unsigned();
            $table->foreign('mustahik_type_id')->references('id')->on('mustahik_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('mustahik_status_id')->unsigned();
            $table->foreign('mustahik_status_id')->references('id')->on('mustahik_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('distribution')->nullable();
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
        Schema::dropIfExists('mustahiks');
    }
}
