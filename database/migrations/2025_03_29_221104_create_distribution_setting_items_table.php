<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDistributionSettingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('distribution_setting_items', function (Blueprint $table) {
            $table->id();
            $table->integer('year_period_id')->unsigned()->nullable();
            $table->integer('mustahik_id')->unsigned()->nullable();
            $table->integer('mustahik_type_id')->unsigned()->nullable();
            $table->integer('amount')->default(0);
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
        Schema::dropIfExists('distribution_setting_items');
    }
}
