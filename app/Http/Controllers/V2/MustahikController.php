<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\MustahikRequest;
use App\Http\Resources\BackOffice\MustahikResource;
use App\Models\Mustahik;
use App\Models\MustahikYearPeriod;
use App\Models\YearPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class MustahikController extends Controller
{
    private $modulName = "Mustahik";

    public function index()
    {
        $data = QueryBuilder::for(Mustahik::class)
            ->with([
                'rw',
                'rt'
            ])
            ->allowedFilters([
                AllowedFilter::scope('keyword')
            ])
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return MustahikResource::collection($data);
    }

    public function store(MustahikRequest $request)
    {
        $validator = $request->safe()->all();

        DB::beginTransaction();
        try {

            if (!$validator['names']) {
                $mustahik = Mustahik::create($validator);

                if ($validator['is_mustahik_year']) {
                    $year = YearPeriod::active()->first();
                    MustahikYearPeriod::create([
                        'year_period_id' => $year->id,
                        'mustahik_id' => $mustahik->id,
                    ]);
                }

                DB::commit();

                return $this->successMessage(MustahikResource::make($mustahik), 'store', $this->modulName);
            }

            if ($validator['names']) {
                $mustahiks = collect();
                $year = YearPeriod::active()->first();

                foreach ($validator['names'] as $item) {
                    $mustahik = Mustahik::create([
                        'rw_id' => $validator['rw_id'],
                        'rt_id' => $validator['rt_id'],
                        'mustahik_type_id' => $validator['mustahik_type_id'],
                        'name' => $item
                    ]);
                    $mustahiks->push($mustahik);

                    if ($validator['is_mustahik_year']) {
                        MustahikYearPeriod::create([
                            'year_period_id' => $year->id,
                            'mustahik_id' => $mustahik->id,
                        ]);
                    }
                }

                DB::commit();

                return $this->successMessage(MustahikResource::collection($mustahiks), 'store', $this->modulName);
            }
        } catch (Exception $error) {
            DB::rollback();
            throw $error;
        }
    }

    public function show(Mustahik $mustahik)
    {
        return MustahikResource::make($mustahik);
    }

    public function update(MustahikRequest $request, Mustahik $mustahik)
    {
        $validator = $request->safe()->all();
        $mustahik->update($validator);
        return $this->successMessage(MustahikResource::make($mustahik), 'update', $this->modulName);
    }

    public function destroy(Mustahik $mustahik)
    {
        $mustahik->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
