<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\MustahikRequest;
use App\Http\Resources\BackOffice\MustahikResource;
use App\Models\Mustahik;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;

class MustahikController extends Controller
{
    private $modulName = "Mustahik";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = QueryBuilder::for(Mustahik::class)
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return MustahikResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MustahikRequest $request)
    {
        $validator = $request->safe()->all();

        DB::beginTransaction();
        try {

            if (!$validator['names']) {
                $mustahikType = Mustahik::create($validator);
                DB::commit();

                return $this->successMessage(MustahikResource::make($mustahikType), 'store', $this->modulName);
            }

            if ($validator['names']) {
                $mustahiks = collect();

                foreach ($validator['names'] as $item) {
                    $mustahikType = Mustahik::create([
                        'rw_id' => $validator['rw_id'],
                        'rt_id' => $validator['rt_id'],
                        'mustahik_type_id' => $validator['mustahik_type_id'],
                        'name' => $item
                    ]);
                    $mustahiks->push($mustahikType);
                }

                DB::commit();

                return $this->successMessage(MustahikResource::collection($mustahiks), 'store', $this->modulName);
            }
        } catch (Exception $error) {
            DB::rollback();
            throw $error;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Mustahik $mustahik)
    {
        return MustahikResource::make($mustahik);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MustahikRequest $request, Mustahik $mustahik)
    {
        $validator = $request->safe()->all();
        $mustahik->update($validator);
        return $this->successMessage(MustahikResource::make($mustahik), 'update', $this->modulName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mustahik $mustahik)
    {
        $mustahik->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
