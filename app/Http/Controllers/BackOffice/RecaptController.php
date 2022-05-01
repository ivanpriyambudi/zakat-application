<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Rw;
use App\Models\Mustahik;
use App\Models\Amil;
use App\Models\Doa;
use App\Models\SatuanZakat;
use App\Models\MustahikStatus;
use App\Models\MustahikType;
use App\Http\Resources\BackOffice\RwResource;
use App\Http\Resources\BackOffice\MustahikStatusResource;
use App\Http\Resources\BackOffice\MustahikTypeResource;
use Spatie\QueryBuilder\QueryBuilder;

class RecaptController extends Controller
{
    public function index()
    {
        $rw = Rw::with([
            'rt',
        ])
            ->get();

        $status = MustahikStatus::all();

        $satuan = SatuanZakat::where('is_primary', 1)->first();

        $mustahik_status = MustahikStatus::all();

        $mustahik_type = MustahikType::all();

        $amil = Amil::where('id', 1)->first();

        $doa = Doa::where('id', 1)->first();

        return Inertia::render('Rekap/Index', [
            'rw' => RwResource::collection($rw),
            'status' => MustahikStatusResource::collection($status),
            'satuan' => $satuan,
            'mustahikStatus' => MustahikStatusResource::collection($mustahik_status),
            'mustahikType' => MustahikTypeResource::collection($mustahik_type),
            'amil' => $amil,
            'doa' => $doa,
        ]);
    }

    public function updateValueDistribution(Request $request)
    {
        foreach ($request->data as $item) {
            $status = MustahikStatus::find($item['id']);
            $status->distribution = $item['distribution'];
            $status->update();
        };

        return redirect()->back();
    }

    public function setAmil(Request $request)
    {
        $amil = Amil::find(1);
        $amil->amount = $request['amount'];
        $amil->distribution = $request['distribution'];
        $amil->update();

        return redirect()->back();
    }

    public function setDoa(Request $request)
    {
        $amil = Doa::find(1);
        $amil->amount = $request['amount'];
        $amil->distribution = $request['distribution'];
        $amil->update();

        return redirect()->back();
    }

    public function deleteTambahan($mustahikId)
    {
        $amil = Mustahik::find($mustahikId);
        $amil->distribution = null;
        $amil->update();

        return redirect()->back();
    }

    public function updateTambahan(Request $request, $mustahikId)
    {
        $amil = Mustahik::find($mustahikId);
        $amil->distribution = $request['distribution'];
        $amil->update();

        return redirect()->back();
    }

    public function printPage()
    {
        $rw = Rw::with([
            'rt',
        ])
            ->get();

        $status = MustahikStatus::all();

        $satuan = SatuanZakat::where('is_primary', 1)->first();

        $mustahik_status = MustahikStatus::all();

        $mustahik_type = MustahikType::all();

        $amil = Amil::where('id', 1)->first();

        $doa = Doa::where('id', 1)->first();

        return Inertia::render('Rekap/Print', [
            'rw' => RwResource::collection($rw),
            'status' => MustahikStatusResource::collection($status),
            'satuan' => $satuan,
            'mustahikStatus' => MustahikStatusResource::collection($mustahik_status),
            'mustahikType' => MustahikTypeResource::collection($mustahik_type),
            'amil' => $amil,
            'doa' => $doa,
        ]);
    }
}
