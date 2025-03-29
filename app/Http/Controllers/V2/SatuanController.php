<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\SatuanZakatRequest;
use App\Http\Resources\BackOffice\SatuanZakatResource;
use App\Models\SatuanZakat;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class SatuanController extends Controller
{
    private $modulName = "Satuan Zakat";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = QueryBuilder::for(SatuanZakat::class)
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return SatuanZakatResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SatuanZakatRequest $request)
    {
        $validator = $request->safe()->all();
        $satuanZakat = SatuanZakat::create($validator);
        return $this->successMessage(SatuanZakatResource::make($satuanZakat), 'store', $this->modulName);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(SatuanZakat $satuanZakat)
    {
        return SatuanZakatResource::make($satuanZakat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SatuanZakatRequest $request, SatuanZakat $satuanZakat)
    {
        $validator = $request->safe()->all();
        $satuanZakat->update($validator);
        return $this->successMessage(SatuanZakatResource::make($satuanZakat), 'update', $this->modulName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SatuanZakat $satuanZakat)
    {
        $satuanZakat->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
