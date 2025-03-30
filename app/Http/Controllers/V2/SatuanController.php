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

    public function index()
    {
        $data = QueryBuilder::for(SatuanZakat::class)
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return SatuanZakatResource::collection($data);
    }

    public function store(SatuanZakatRequest $request)
    {
        $validator = $request->safe()->all();
        $satuanZakat = SatuanZakat::create($validator);
        return $this->successMessage(SatuanZakatResource::make($satuanZakat), 'store', $this->modulName);
    }

    public function show(SatuanZakat $satuanZakat)
    {
        return SatuanZakatResource::make($satuanZakat);
    }

    public function update(SatuanZakatRequest $request, SatuanZakat $satuanZakat)
    {
        $validator = $request->safe()->all();
        $satuanZakat->update($validator);
        return $this->successMessage(SatuanZakatResource::make($satuanZakat), 'update', $this->modulName);
    }

    public function destroy(SatuanZakat $satuanZakat)
    {
        $satuanZakat->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
