<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Resources\MustahikYearPeriodResource;
use App\Models\MustahikYearPeriod;
use Illuminate\Http\Request;
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
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return MustahikYearPeriodResource::collection($data);
    }
}
