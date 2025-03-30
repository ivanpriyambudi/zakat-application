<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('amil_count')->default(0);
            $table->integer('amil_distribution')->default(0);
            $table->integer('satuan_zakat_id')->unsigned()->nullable();
            $table->integer('year_period_id')->unsigned()->nullable();
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
        Schema::dropIfExists('distribution_settings');
    }
}
