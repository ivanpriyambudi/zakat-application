<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\YearPeriodRequest;
use App\Http\Resources\YearPeriodResource;
use App\Models\YearPeriod;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class YearPeriodController extends Controller
{
    private $modulName = "Tahun";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = QueryBuilder::for(YearPeriod::class)
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return YearPeriodResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(YearPeriodRequest $request)
    {
        $validator = $request->safe()->all();
        $yearPeriod = YearPeriod::create($validator);
        return $this->successMessage(YearPeriodResource::make($yearPeriod), 'store', $this->modulName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(YearPeriod $yearPeriod)
    {
        return YearPeriodResource::make($yearPeriod);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(YearPeriodRequest $request, YearPeriod $yearPeriod)
    {
        $validator = $request->safe()->all();
        $yearPeriod->update($validator);
        return $this->successMessage(YearPeriodResource::make($yearPeriod), 'update', $this->modulName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(YearPeriod $yearPeriod)
    {
        $yearPeriod->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
