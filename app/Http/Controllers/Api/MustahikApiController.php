<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MustahikType;
use App\Models\Mustahik;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;

class MustahikApiController extends Controller
{
    public function getCountMustahik()
    {
        $mustahik = QueryBuilder::for(MustahikType::class)
            ->withCount(['count_mustahik'])
            ->get();

        return response()->json($mustahik);
    }

    public function getMustahikTambahan()
    {
        $mustahik = QueryBuilder::for(Mustahik::class)
            ->with([
                'rw',
                'rt',
                'mustahik_type',
                'mustahik_status',
            ])
            ->allowedFilters([
                'name',
                'rt_id',
                'rw_id',
                'mustahik_type_id',
                'mustahik_status_id',
            ])
            ->paginate($this->getLimit());

        return response()->json($mustahik);
    }

    public function onAddDistribution(Request $request, $mustahikId)
    {
        $mustahik = Mustahik::find($mustahikId);
        $mustahik->distribution = $request['distribution'];
        $mustahik->update();

        return response()->json($mustahik);
    }
}
