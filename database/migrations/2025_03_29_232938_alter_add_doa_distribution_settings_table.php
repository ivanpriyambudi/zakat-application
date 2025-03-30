<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddDoaDistributionSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('distribution_settings', function (Blueprint $table) {
            $table->integer('doa_count')->default(0);
            $table->integer('doa_distribution')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('distribution_settings', function (Blueprint $table) {
            $table->dropColumn('doa_count');
            $table->dropColumn('doa_distribution');
        });
    }
}
