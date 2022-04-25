<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zakat;
use App\Models\Rt;
use App\Models\SatuanZakat;
use App\Models\MustahikStatus;
use App\Models\Mustahik;
use Illuminate\Support\Facades\DB;

class ZakatApiController extends Controller
{
    public function getAmountZakat()
    {
        $year = date("Y");
        $zakat = Zakat::whereYear('created_at', '=', $year)
            ->get();

        $zakats = $zakat->groupBy('amount_type_id');
        $sums = 0;

        foreach ($zakats as $key => $value) {
            $satuan = SatuanZakat::find($key);
            $satuanPrimary = SatuanZakat::where('is_primary', 1)->first();
            // dd($value->sum('amount'));
            $sum = $value->sum('amount') * $satuan->kilo / $satuanPrimary->kilo;
            $sums += $sum;
        }

        return response()->json($sums);
    }

    public function getZakatRt()
    {
        $data = collect();
        $rt = Rt::with([
            'rw',
            'people.zakatYear'
        ])
            ->get();

        foreach ($rt as $item) {
            $zakats = collect();
            foreach ($item->people as $Pitems) {
                $zakats->push(...$Pitems['zakatYear']);
            }
            $data->push([
                'data' => $item,
                'amount' => $zakats->groupBy('amount_type.name')->map(function ($row) {
                    return $row->sum('amount');
                })
            ]);
        }

        return response()->json($data);
    }

    public function getZakatRtWithPenerima()
    {
        $data = collect();
        $rt = Rt::with([
            'rw',
            'mustahik.mustahik_status',
            'people.zakatFitrahYear',
            'people.donasiYear',
        ])
            ->get();

        $satuan = SatuanZakat::where('is_primary', 1)->first();

        foreach ($rt as $item) {

            // count zakat
            $zakats = collect();
            foreach ($item->people as $Pitems) {
                $zakatPeople = collect();

                foreach ($Pitems['zakatFitrahYear'] as $Zitems) {
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
            // $kebutuhan = $item['mustahik']->sum('mustahik_status.distribution') + $item['mustahik']->sum('distribution');
            $kebutuhan = $item['mustahik']->sum('mustahik_status.distribution');

            // donasi
            $donasis = collect();
            foreach ($item->people as $Pitems) {
                $donasiPeople = collect();

                foreach ($Pitems['donasiYear'] as $Zitems) {
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

        return response()->json($data);
    }

    public function getRecentZakat()
    {
        $year = date("Y");
        $zakat = Zakat::whereYear('created_at', '=', $year)
            ->with([
                'people',
                'amount_type',
                'people.rw',
                'people.rt',
            ])
            ->limit(4)
            ->latest()
            ->get();

        return response()->json($zakat);
    }

    public function getZakatPenerimaTambahan()
    {
        $mustahik = Mustahik::where('distribution', '!=', null)
            ->with([
                'rw',
                'rt',
                'mustahik_type',
                'mustahik_status',
            ])
            ->get();

        return response()->json($mustahik);
    }

    public function getTambahanZakatRt()
    {
        $data = collect();
        $rt = Rt::with([
            'rw',
            'mustahikTambahan.mustahik_status',
        ])
            ->get();

        foreach ($rt as $item) {

            $data->push([
                'data' => $item,
                'listPenerima' => $item['mustahikTambahan']->groupBy('mustahik_status_id')->map(function ($row) {
                    return $row->sum('distribution');
                }),
                'totalDistribution' => $item['mustahikTambahan']->sum('distribution'),
            ]);
        }

        return response()->json($data);
    }

    public function getSummaryPenerima()
    {
        $data = collect();
        $mustahikStatus = MustahikStatus::with([
            'mustahik',
        ])
            ->get();

        foreach ($mustahikStatus as $item) {
            //count per status
            $countStatus = $item['mustahik']->count();
            $sumGetDistribution = $countStatus * $item->distribution;
            $plusSumGetDistribution = $item['mustahik']->sum('distribution');

            $data->push([
                'data' => $item,
                'summary' => $sumGetDistribution + $plusSumGetDistribution,
            ]);
        }

        return response()->json($data);
    }
}
