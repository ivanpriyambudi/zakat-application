<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\MustahikYearPeriodRequest;
use App\Http\Resources\BaseResponse;
use App\Http\Resources\MustahikYearPeriodResource;
use App\Models\Mustahik;
use App\Models\MustahikYearPeriod;
use App\Models\YearPeriod;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MustahikYearPeriodController extends Controller
{
    private $modulName = "Mustahik Year Period";

    public function index()
    {
        $data = QueryBuilder::for(MustahikYearPeriod::class)
            ->with([
                'mustahik',
                'mustahik.rt',
                'mustahik.rw',
            ])
            ->allowedFilters([
                AllowedFilter::scope('keyword')
            ])
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return MustahikYearPeriodResource::collection($data);
    }

    public function store(MustahikYearPeriodRequest $request)
    {
        $validator = $request->safe()->all();
        $year = YearPeriod::active()->first();

        if (!$validator['context']) {
            $mustahik = Mustahik::find($validator['mustahik_id']);
            $mustahikYearPeriod = MustahikYearPeriod::create($validator + [
                'year_period_id' => $year->id,
                'mustahik_type_id' => $mustahik->mustahik_type_id
            ]);

            return $this->successMessage(MustahikYearPeriodResource::make($mustahikYearPeriod), 'store', $this->modulName);
        }

        if ($validator['context'] === 'all') {
            $mustahiks = Mustahik::all();

            foreach ($mustahiks as $item) {
                MustahikYearPeriod::updateOrCreate([
                    'year_period_id' => $year->id,
                    'mustahik_id' => $item->id,
                ], [
                    'mustahik_type_id' => $item->mustahik_type_id
                ]);
            }

            return BaseResponse::instance()->setData(null)->build();
        }
    }

    public function destroy(MustahikYearPeriod $mustahikYearPeriod)
    {
        $mustahikYearPeriod->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
