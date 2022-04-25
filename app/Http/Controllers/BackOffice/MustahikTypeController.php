<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\MustahikType;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\BackOffice\MustahikTypeResource;

class MustahikTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuan = QueryBuilder::for(MustahikType::class)
            ->allowedFilters([
                'name'
            ])
            ->paginate($this->getLimit());

        return Inertia::render('MustahikType/List', [
            'list' => MustahikTypeResource::collection($satuan),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('MustahikType/Create');
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
        ]);

        MustahikType::create($validated);

        session()->flash('success', 'Berhasil menambahkan tipe mustahik');

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
    public function edit(MustahikType $mustahikType)
    {
        return Inertia::render('MustahikType/Edit', [
            'mustahikType' => $mustahikType
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MustahikType $mustahikType)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
        ]);

        $mustahikType->update($validated);

        return redirect()->route('mustahik-type.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(MustahikType $mustahikType)
    {
        $mustahikType->delete();

        return redirect()->back();
    }
}
