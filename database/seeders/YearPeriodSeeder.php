<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearPeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('year_periods')->insert([
            'year' => 2024,
            'is_active' => false,
        ]);

        DB::table('year_periods')->insert([
            'year' => 2025,
            'is_active' => true,
        ]);
    }
}
