<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\MustahikSettingRequest;
use App\Http\Resources\BaseResponse;
use App\Models\DistributionSetting;
use App\Models\DistributionSettingItem;
use App\Models\MustahikType;
use App\Models\MustahikYearPeriod;
use App\Models\Rt;
use App\Models\SatuanZakat;
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

        $sumNeedMustahik = MustahikYearPeriod::where('year_period_id', $year->id)->count();
        $sumNeed = ($settings->amil_count * $settings->amil_distribution) + ($settings->doa_count * $settings->doa_distribution);

        return BaseResponse::instance()->setData([
            'count_zakat' => $zakatCountByPrimarySatuan,
            'need_zakat' => $sumNeed,
            'satuan_zakat' => $settings->satuan_zakat,
            'year_period' => $year,
            'setting' => $settings
        ])->build();
    }

    public function recaptPerRt()
    {
        $data = collect();
        $rt = Rt::with([
            'rw',
            'people.zakatYearV2'
        ])
            ->get();

        foreach ($rt as $item) {
            $zakats = collect();
            foreach ($item->people as $Pitems) {
                $zakats->push(...$Pitems['zakatYearV2']);
            }
            $data->push([
                'data' => $item,
                'amount' => $zakats->groupBy('amount_type.name')->map(function ($row) {
                    return $row->sum('amount');
                })
            ]);
        }

        return BaseResponse::instance()->setData($data)->build();
    }

    public function recaptPerRtPenerima()
    {
        $data = collect();
        $rt = Rt::with([
            'rw',
            'mustahik.mustahik_status',
            'people.zakatFitrahYearV2',
            'people.donasiYearV2',
        ])
            ->get();

        $satuan = SatuanZakat::where('is_primary', 1)->first();

        foreach ($rt as $item) {

            // count zakat
            $zakats = collect();
            foreach ($item->people as $Pitems) {
                $zakatPeople = collect();

                foreach ($Pitems['zakatFitrahYearV2'] as $Zitems) {
                    if ($Zitems['amount_type_id'] == $satuan->id) {
                        $zakatPeople->push($Zitems);
                    } else {
                        $satuanDifferent = SatuanZakat::find($Zitems['amount_type_id']);
                        $sumNormalize = $satuanDifferent->kilo / $satuan->kilo;
                        $Zitems->amount = $sumNormalize * $Zitems->amount;
                        $zakatPeople->push($Zitems);
                    }
                }

                $zakats->push(...$zakatPeople);
            }

            // count penerima
            $count_penerima = $item['mustahik']->count();

            // list penerima
            $list_penerima = $item['mustahik']
                ->groupBy('mustahik_status.name')
                ->map(function ($row) {
                    return $row->count();
                });

            // amount needed
            $kebutuhan = $item['mustahik']->sum('mustahik_status.distribution');

            // donasi
            $donasis = collect();
            foreach ($item->people as $Pitems) {
                $donasiPeople = collect();

                foreach ($Pitems['donasiYearV2'] as $Zitems) {
                    if ($Zitems['amount_type_id'] == $satuan->id) {
                        $donasiPeople->push($Zitems);
                    } else {
                        $satuanDifferent = SatuanZakat::find($Zitems['amount_type_id']);
                        $sumNormalize = $satuanDifferent->kilo / $satuan->kilo;
                        $Zitems->amount = $sumNormalize * $Zitems->amount;
                        $donasiPeople->push($Zitems);
                    }
                }

                $donasis->push(...$donasiPeople);
            }


            $data->push([
                'data' => $item,
                'amount' => $zakats->sum('amount'),
                'countPenerima' => $count_penerima,
                'listPenerima' => $list_penerima,
                'kebutuhan' => $kebutuhan,
                'donasi' => $donasis->sum('amount'),
                'totalIn' => $zakats->sum('amount') + $donasis->sum('amount'),
            ]);
        }

        return BaseResponse::instance()->setData($data)->build();
    }
}
