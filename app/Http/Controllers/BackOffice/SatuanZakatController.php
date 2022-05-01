<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\SatuanZakat;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\BackOffice\SatuanZakatResource;

class SatuanZakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $satuan = QueryBuilder::for(SatuanZakat::class)
            ->allowedFilters([
                'name',
                'kilo'
            ])
            ->paginate($this->getLimit());

        return Inertia::render('SatuanZakat/List', [
            'list' => SatuanZakatResource::collection($satuan),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('SatuanZakat/Create');
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
            'kilo' => 'required|numeric',
            'is_primary' => 'nullable|integer',
        ]);

        SatuanZakat::create($validated);

        session()->flash('success', 'Berhasil menambahkan satuan zakat');

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
    public function edit(SatuanZakat $satuanZakat)
    {
        return Inertia::render('SatuanZakat/Edit', [
            'satuanZakat' => $satuanZakat
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SatuanZakat $satuanZakat)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'kilo' => 'required|numeric',
            'is_primary' => 'nullable|integer',
        ]);

        $status = SatuanZakat::where('is_primary', 1)->first();

        if ($validated['is_primary'] == 1) {
            $oldStatus = SatuanZakat::find($status->id);
            $oldStatus['is_primary'] = 0;
            $oldStatus->update();
        }

        $satuanZakat->update($validated);

        return redirect()->route('satuan-zakat.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SatuanZakat $satuanZakat)
    {
        $satuanZakat->delete();

        return redirect()->back();
    }

    public function changePrimary($satuanZakatId)
    {
        $status = SatuanZakat::where('is_primary', 1)
            ->first();
        $oldStatus = SatuanZakat::find($status->id);
        $oldStatus['is_primary'] = 0;
        $oldStatus->update();

        $newStatus = SatuanZakat::find($satuanZakatId);
        $newStatus['is_primary'] = 1;
        $newStatus->update();

        return redirect()->route('satuan-zakat.index');
    }
}
