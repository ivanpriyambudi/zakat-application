<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\MustahikSettingRequest;
use App\Http\Resources\BaseResponse;
use App\Models\DistributionSetting;
use App\Models\DistributionSettingItem;
use App\Models\MustahikType;
use App\Models\YearPeriod;
use App\Models\Zakat;
use Illuminate\Http\Request;

class RecaptController extends Controller
{
    public function dashboard()
    {
        $year = YearPeriod::active()->first();
        $settings = DistributionSetting::where('year_period_id', $year->id)->first();
        $primaryKilo = $settings->satuan_zakat['kilo'];

        $zakatCountByPrimarySatuan = Zakat::where('year_period_id', $year->id)
            ->join('satuan_zakats', 'zakats.amount_type_id', '=', 'satuan_zakats.id')
            ->selectRaw('SUM(amount * (satuan_zakats.kilo / ?)) as total_in_primary', [$primaryKilo])
            ->value('total_in_primary');

        $sumNeed = ($settings->amil_count * $settings->amil_distribution) + ($settings->doa_count * $settings->doa_distribution);

        return BaseResponse::instance()->setData([
            'count_zakat' => $zakatCountByPrimarySatuan,
            'need_zakat' => $sumNeed,
            'satuan_zakat' => $settings->satuan_zakat,
            'year_period' => $year,
            'setting' => $settings
        ])->build();
    }
}
