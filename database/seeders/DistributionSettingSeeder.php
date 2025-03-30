<?php

namespace Database\Seeders;

use App\Models\DistributionSetting;
use App\Models\SatuanZakat;
use App\Models\YearPeriod;
use Illuminate\Database\Seeder;

class DistributionSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $years = YearPeriod::all();
        $satuanPrimary = SatuanZakat::where('is_primary', true)->first();

        foreach ($years as $year) {
            DistributionSetting::firstOrCreate([
                'satuan_zakat_id' => $satuanPrimary->id,
                'year_period_id' => $year->id,
            ]);
        }
    }
}
