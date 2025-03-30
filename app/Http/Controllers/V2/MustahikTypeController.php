<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\MustahikTyoeRequest;
use App\Http\Resources\BackOffice\MustahikTypeResource;
use App\Models\MustahikType;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class MustahikTypeController extends Controller
{
    private $modulName = "Mustahik Type";

    public function index()
    {
        $data = QueryBuilder::for(MustahikType::class)
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return MustahikTypeResource::collection($data);
    }

    public function store(MustahikTyoeRequest $request)
    {
        $validator = $request->safe()->all();
        $mustahikType = MustahikType::create($validator);
        return $this->successMessage(MustahikTypeResource::make($mustahikType), 'store', $this->modulName);
    }

    public function show(MustahikType $mustahikType)
    {
        return MustahikTypeResource::make($mustahikType);
    }

    public function update(MustahikTyoeRequest $request, MustahikType $mustahikType)
    {
        $validator = $request->safe()->all();
        $mustahikType->update($validator);
        return $this->successMessage(MustahikTypeResource::make($mustahikType), 'update', $this->modulName);
    }

    public function destroy(MustahikType $mustahikType)
    {
        $mustahikType->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
