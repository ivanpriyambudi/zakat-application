<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistributionSettingRequest;
use App\Http\Resources\BaseResponse;
use App\Models\DistributionSetting;
use App\Models\YearPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionSettingController extends Controller
{
    public function index()
    {
        //
    }

    public function store(DistributionSettingRequest $request)
    {
        $validator = $request->safe()->all();

        DB::beginTransaction();
        try {
            $year = YearPeriod::active()->first();
            $setting = DistributionSetting::updateOrCreate(
                [
                    'year_period_id' => $year->id,

                ],
                [
                    'amil_count' => $validator['amil_count'],
                    'amil_distribution' => $validator['amil_distribution'],
                    'doa_count' => $validator['doa_count'],
                    'doa_distribution' => $validator['doa_distribution'],
                ]
            );

            DB::commit();

            return BaseResponse::instance()->setData([
                'setting' => $setting
            ])->build();
        } catch (Exception $error) {
            DB::rollback();
            throw $error;
        }
    }
}
