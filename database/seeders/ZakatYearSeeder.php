<?php

namespace Database\Seeders;

use App\Models\YearPeriod;
use App\Models\Zakat;
use Illuminate\Database\Seeder;

class ZakatYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $zakats = Zakat::all();
        $yearPeriod = YearPeriod::where('year', '2024')->first();

        foreach ($zakats as $zakat) {
            $zakat->update([
                'year_period_id' => $yearPeriod['id']
            ]);
        }
    }
}
