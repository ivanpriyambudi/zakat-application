<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rw;
use App\Models\MustahikType;
use App\Models\MustahikStatus;
use App\Models\Mustahik;
use App\Models\SatuanZakat;
use App\Http\Resources\BackOffice\RwResource;
use App\Http\Resources\BackOffice\MustahikTypeResource;
use App\Http\Resources\BackOffice\MustahikResource;
use App\Http\Resources\BackOffice\MustahikStatusResource;
use Spatie\QueryBuilder\QueryBuilder;
use Inertia\Inertia;

class MustahikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

        $rw = QueryBuilder::for(Rw::class)
            ->with([
                'rt',
            ])
            ->get();

        $mustahik_type = QueryBuilder::for(MustahikType::class)
            ->get();

        $mustahik_status = QueryBuilder::for(MustahikStatus::class)
            ->get();

        $satuan = SatuanZakat::where('is_primary', 1)->first();

        return Inertia::render('Mustahik/List', [
            'list' => MustahikResource::collection($mustahik),
            'rw' => RwResource::collection($rw),
            'mustahikType' => MustahikTypeResource::collection($mustahik_type),
            'mustahikStatus' => MustahikStatusResource::collection($mustahik_status),
            'satuan' => $satuan,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rw = QueryBuilder::for(Rw::class)
            ->with([
                'rt',
            ])
            ->get();

        $mustahik_type = QueryBuilder::for(MustahikType::class)
            ->get();

        $mustahik_status = QueryBuilder::for(MustahikStatus::class)
            ->get();

        return Inertia::render('Mustahik/Create', [
            'rw' => RwResource::collection($rw),
            'mustahikType' => MustahikTypeResource::collection($mustahik_type),
            'mustahikStatus' => MustahikStatusResource::collection($mustahik_status),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'rt_id' => 'required|exists:rts,id',
            'mustahik_type_id' => 'required|exists:mustahik_types,id',
            'mustahik_status_id' => 'required|exists:mustahik_statuses,id',
            'name' => 'required|string',
        ]);

        Mustahik::create($validated);

        session()->flash('success', 'Berhasil menambahkan mustahik');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($mustahikId)
    {
        $mustahik = Mustahik::where('id', $mustahikId)
            ->with([
                'rw',
                'rt',
                'mustahik_type',
            ])
            ->first();

        $rw = QueryBuilder::for(Rw::class)
            ->with([
                'rt',
            ])
            ->get();

        $mustahik_type = QueryBuilder::for(MustahikType::class)
            ->get();

        return Inertia::render('Mustahik/Edit', [
            'mustahik' => $mustahik,
            'rw' => RwResource::collection($rw),
            'mustahikType' => MustahikTypeResource::collection($mustahik_type),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $mustahikId)
    {
        $validated = $this->validate($request, [
            'rw_id' => 'required|exists:rws,id',
            'rt_id' => 'required|exists:rts,id',
            'mustahik_type_id' => 'required|exists:mustahik_types,id',
            'mustahik_status_id' => 'required|exists:mustahik_statuses,id',
            'name' => 'required|string',
        ]);

        $mustahik = Mustahik::find($mustahikId);
        $mustahik->update($validated);

        return redirect()->route('mustahik.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($mustahikId)
    {
        $mustahik = Mustahik::find($mustahikId);
        $mustahik->delete();

        return redirect()->back();
    }
}
