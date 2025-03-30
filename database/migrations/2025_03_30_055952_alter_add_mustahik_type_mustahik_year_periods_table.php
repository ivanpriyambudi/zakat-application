<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddMustahikTypeMustahikYearPeriodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mustahik_year_periods', function (Blueprint $table) {
            $table->integer('mustahik_type_id')->unsigned()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mustahik_year_periods', function (Blueprint $table) {
            $table->integer('mustahik_type_id')->unsigned()->nullable();
        });
    }
}
