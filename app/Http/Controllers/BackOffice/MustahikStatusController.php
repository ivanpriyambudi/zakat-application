<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MustahikStatus;
use App\Models\SatuanZakat;
use App\Http\Resources\BackOffice\MustahikStatusResource;
use Spatie\QueryBuilder\QueryBuilder;
use Inertia\Inertia;

class MustahikStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mustahik_status = QueryBuilder::for(MustahikStatus::class)
            ->allowedFilters([
                'name',
            ])
            ->paginate($this->getLimit());

        $satuan = SatuanZakat::where('is_primary', 1)->first();

        return Inertia::render('MustahikStatus/List', [
            'list' => MustahikStatusResource::collection($mustahik_status),
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
        $satuan = SatuanZakat::where('is_primary', 1)->first();

        return Inertia::render('MustahikStatus/Create', [
            'satuan' => $satuan,
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
            'name' => 'required|string',
            'distribution' => 'required|integer',
        ]);

        MustahikStatus::create($validated);

        session()->flash('success', 'Berhasil menambahkan Status Mustahik');

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
    public function edit($mustahikStatusId)
    {
        $mustahik_status = MustahikStatus::where('id', $mustahikStatusId)
            ->first();

        $satuan = SatuanZakat::where('is_primary', 1)->first();

        return Inertia::render('MustahikStatus/Edit', [
            'mustahikStatus' => $mustahik_status,
            'satuan' => $satuan,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $mustahikStatusId)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'distribution' => 'required|integer',
        ]);

        $mustahikStatus = MustahikStatus::find($mustahikStatusId);
        $mustahikStatus->update($validated);

        return redirect()->route('mustahik-status.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($mustahikStatusId)
    {
        $mustahikStatus = MustahikStatus::find($mustahikStatusId);
        $mustahikStatus->delete();

        return redirect()->back();
    }
}
