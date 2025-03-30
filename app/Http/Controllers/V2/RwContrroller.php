<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\RwRequest;
use App\Http\Resources\BackOffice\RwResource;
use App\Models\Rw;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class RwContrroller extends Controller
{
    private $modulName = "RW";

    public function index()
    {
        $data = QueryBuilder::for(Rw::class)
            ->with([
                'rt'
            ])
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return RwResource::collection($data);
    }

    public function store(RwRequest $request)
    {
        $validator = $request->safe()->all();
        $satuanZakat = Rw::create($validator);
        return $this->successMessage(RwResource::make($satuanZakat), 'store', $this->modulName);
    }

    public function show(Rw $rw)
    {
        return RwResource::make($rw);
    }

    public function update(RwRequest $request, Rw $rw)
    {
        $validator = $request->safe()->all();
        $rw->update($validator);
        return $this->successMessage(RwResource::make($rw), 'update', $this->modulName);
    }

    public function destroy(Rw $rw)
    {
        $rw->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
