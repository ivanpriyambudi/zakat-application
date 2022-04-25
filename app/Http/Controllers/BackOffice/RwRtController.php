<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\Rw;
use App\Models\Rt;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BackOffice\RwResource;

use Inertia\Inertia;

class RwRtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuan = QueryBuilder::for(Rw::class)
            ->allowedFilters([
                'name'
            ])
            ->with([
                'rt',
            ])
            ->paginate($this->getLimit());

        return Inertia::render('RtRw/List', [
            'list' => RwResource::collection($satuan),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('RtRw/Create');
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

        Rw::create($validated);

        session()->flash('success', 'Berhasil menambahkan RW (Rukun Warga)');

        return redirect()->back();
    }

    public function storeRt(Request $request)
    {
        $validated = $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'name' => 'required|string',
        ]);

        Rt::create($validated);

        session()->flash('success', 'Berhasil menambahkan RT (Rukun Tetangga)');

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
    public function edit($rwId)
    {
        $rw = Rw::find($rwId);

        return Inertia::render('RtRw/Edit', [
            'rw' => $rw
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $rwId)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
        ]);

        $rw = Rw::find($rwId);
        $rw->update($validated);

        return redirect()->route('rw-rt.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rws)
    {
        $rw = Rw::find($rws);
        $rw->delete();

        return redirect()->back();
    }

    public function destroyRt($rts)
    {
        $rt = Rt::find($rts);
        $rt->delete();

        return redirect()->back();
    }
}
