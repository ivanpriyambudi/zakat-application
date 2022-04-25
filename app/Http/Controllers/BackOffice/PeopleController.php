<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;
use Inertia\Inertia;
use App\Http\Resources\BackOffice\PeopleResource;
use App\Models\People;
use App\Models\Rw;
use App\Http\Resources\BackOffice\RwResource;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $people = QueryBuilder::for(People::class)
            ->with([
                'rw',
                'rt',
            ])
            ->allowedFilters([
                'name',
                'rt_id',
                'rw_id'
            ])
            ->paginate($this->getLimit());

        $rw = QueryBuilder::for(Rw::class)
            ->with([
                'rt',
            ])
            ->get();

        return Inertia::render('DaftarWarga/List', [
            'list' => PeopleResource::collection($people),
            'rw' => RwResource::collection($rw),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($peopleId)
    {
        $people = People::find($peopleId)
            ->with([
                'rw',
                'rt',
            ])
            ->first();

        $rw = QueryBuilder::for(Rw::class)
            ->with([
                'rt',
            ])
            ->get();

        return Inertia::render('DaftarWarga/Edit', [
            'people' => $people,
            'rw' => RwResource::collection($rw)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $peopleId)
    {
        $validated = $this->validate($request, [
            'name' => 'required|string',
            'rw_id' => 'required|exists:rws,id',
            'rt_id' => 'required|exists:rts,id',
        ]);

        $people = People::find($peopleId);
        $people->update($validated);

        return redirect()->route('people.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($peopleId)
    {
        $people = People::find($peopleId);
        $people->delete();

        return redirect()->back();
    }
}
