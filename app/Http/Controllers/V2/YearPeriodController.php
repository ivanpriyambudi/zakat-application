<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\YearPeriodRequest;
use App\Http\Resources\YearPeriodResource;
use App\Models\DistributionSetting;
use App\Models\SatuanZakat;
use App\Models\YearPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class YearPeriodController extends Controller
{
    private $modulName = "Tahun";

    public function index()
    {
        $data = QueryBuilder::for(YearPeriod::class)
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return YearPeriodResource::collection($data);
    }

    public function store(YearPeriodRequest $request)
    {
        $validator = $request->safe()->all();

        DB::beginTransaction();
        try {
            $yearPeriod = YearPeriod::create($validator);
            $satuanPrimary = SatuanZakat::where('is_primary', true)->first();

            DistributionSetting::firstOrCreate([
                'mustahik_distribution_setting' => [],
                'satuan_zakat_id' => $satuanPrimary->id,
                'year_period_id' => $yearPeriod->id,
            ]);

            DB::commit();

            return $this->successMessage(YearPeriodResource::make($yearPeriod), 'store', $this->modulName);
        } catch (Exception $error) {
            DB::rollback();
            throw $error;
        }
    }

    public function show(YearPeriod $yearPeriod)
    {
        return YearPeriodResource::make($yearPeriod);
    }

    public function update(YearPeriodRequest $request, YearPeriod $yearPeriod)
    {
        $validator = $request->safe()->all();
        $yearPeriod->update($validator);
        return $this->successMessage(YearPeriodResource::make($yearPeriod), 'update', $this->modulName);
    }

    public function destroy(YearPeriod $yearPeriod)
    {
        $yearPeriod->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
