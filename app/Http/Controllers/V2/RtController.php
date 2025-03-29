<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\RtRequest;
use App\Http\Resources\RtResource;
use App\Models\Rt;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class RtController extends Controller
{
    private $modulName = "RT";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = QueryBuilder::for(Rt::class)
            ->allowedFilters([
                'rw_id'
            ])
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return RtResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RtRequest $request)
    {
        $validator = $request->safe()->all();
        $satuanZakat = Rt::create($validator);
        return $this->successMessage(RtResource::make($satuanZakat), 'store', $this->modulName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rt $rt)
    {
        return RtResource::make($rt);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RtRequest $request, Rt $rt)
    {
        $validator = $request->safe()->all();
        $rt->update($validator);
        return $this->successMessage(RtResource::make($rt), 'update', $this->modulName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rt $rt)
    {
        $rt->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
