<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZakatRequest;
use App\Http\Resources\BackOffice\ZakatResource;
use App\Models\Zakat;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ZakatController extends Controller
{
    private $modulName = "Zakat";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = QueryBuilder::for(Zakat::class)
            ->with([
                'people.rt',
                'people.rw',
                'amount_type',
                'year_period'
            ])
            ->allowedSorts([
                'created_at',
            ])
            ->allowedFilters([
                'year_period_id',
                AllowedFilter::scope('rw'),
                AllowedFilter::scope('rt'),
            ])
            ->paginate($this->getLimit());

        return ZakatResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ZakatRequest $request)
    {
        $validator = $request->safe()->all();
        $satuanZakat = Zakat::create($validator);
        return $this->successMessage(ZakatResource::make($satuanZakat), 'store', $this->modulName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Zakat $zakat)
    {
        return ZakatResource::make($zakat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ZakatRequest $request, Zakat $zakat)
    {
        $validator = $request->safe()->all();
        $zakat->update($validator);
        return $this->successMessage(ZakatResource::make($zakat), 'update', $this->modulName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zakat $zakat)
    {
        $zakat->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
