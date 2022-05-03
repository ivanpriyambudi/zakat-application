<?php

namespace App\Http\Controllers\BackOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rw;
use App\Http\Resources\BackOffice\RwResource;
use App\Http\Resources\BackOffice\SatuanZakatResource;
use App\Http\Resources\BackOffice\ZakatResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\SatuanZakat;
use App\Models\Zakat;
use App\Models\People;
use App\Models\Rt;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Events\ZakatRecapt;
use Illuminate\Support\Facades\Auth;

class ZakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zakat = QueryBuilder::for(Zakat::class)
            ->with([
                'people',
                'amount_type',
                'people.rw',
                'people.rt',
            ])
            ->allowedFilters([
                'type',
                AllowedFilter::callback('rw_id', function (Builder $query, $value) {
                    $query->whereHas('people.rw', function ($query) use ($value) {
                        $query->where('rw_id', $value);
                    });
                }),
                AllowedFilter::callback('rt_id', function (Builder $query, $value) {
                    $query->whereHas('people.rt', function ($query) use ($value) {
                        $query->where('rt_id', $value);
                    });
                }),
                AllowedFilter::callback('name', function (Builder $query, $value) {
                    $query->whereHas('people', function ($query) use ($value) {
                        $query->where('name', $value);
                    });
                }),
            ])
            ->paginate($this->getLimit());

        $rw = QueryBuilder::for(Rw::class)
            ->with([
                'rt',
            ])
            ->get();

        return Inertia::render('Zakat/List', [
            'list' => ZakatResource::collection($zakat),
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
        $rw = QueryBuilder::for(Rw::class)
            ->with([
                'rt',
            ])
            ->get();

        $satuan = QueryBuilder::for(SatuanZakat::class)
            ->get();

        return Inertia::render('Zakat/Create', [
            'rw' => RwResource::collection($rw),
            'satuan' => SatuanZakatResource::collection($satuan),
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
        $user = Auth::user();

        $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'rt_id' => 'required|exists:rts,id',
            'amount_type_id' => 'required|exists:satuan_zakats,id',
            'name' => 'required|string',
            'amount' => 'required|integer',
            'type' => 'required|in:Donasi,Fitrah',
        ]);

        $people = People::firstOrCreate([
            'rt_id' => $request['rt_id'],
            'rw_id' => $request['rw_id'],
            'name' => $request['name'],
        ]);

        $zakat = Zakat::create([
            'people_id' => $people->id,
            'amount_type_id' => $request['amount_type_id'],
            'amount' => $request['amount'],
            'type' => $request['type'],
        ]);

        session()->flash('success', 'Berhasil menambahkan Zakat');

        broadcast(new ZakatRecapt($user, $zakat))->toOthers();

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
    public function edit($zakatId)
    {
        $zakat = Zakat::where('id', $zakatId)
            ->with([
                'people',
                'amount_type',
                'people.rw',
                'people.rt',
            ])
            ->first();

        $rw = QueryBuilder::for(Rw::class)
            ->with([
                'rt',
            ])
            ->get();

        $satuan = QueryBuilder::for(SatuanZakat::class)
            ->get();

        return Inertia::render('Zakat/Edit', [
            'zakat' => $zakat,
            'rw' => RwResource::collection($rw),
            'satuan' => SatuanZakatResource::collection($satuan),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($zakatId)
    {
        $zakat = Zakat::find($zakatId);
        $zakat->delete();

        return redirect()->back();
    }
}
