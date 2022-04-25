<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rw;
use App\Models\SatuanZakat;
use App\Models\Mustahik;
use App\Models\MustahikStatus;
use App\Http\Resources\BackOffice\RwResource;
use App\Http\Resources\BackOffice\MustahikStatusResource;
use Spatie\QueryBuilder\QueryBuilder;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $rw = QueryBuilder::for(Rw::class)
            ->get();

        $countAllMustahik = QueryBuilder::for(Mustahik::class)
            ->count();

        $satuan = SatuanZakat::where('is_primary', 1)->first();

        return Inertia::render('Dashboard', [
            'rw' => RwResource::collection($rw),
            'countAllMustahik' => $countAllMustahik,
            'satuan' => $satuan,
        ]);
    }
}
