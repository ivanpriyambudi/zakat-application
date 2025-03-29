<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\PeopleRequest;
use App\Http\Resources\BackOffice\PeopleResource;
use App\Models\People;
use Spatie\QueryBuilder\QueryBuilder;

class PeopleController extends Controller
{
    private $modulName = "Warga";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = QueryBuilder::for(People::class)
            ->with([
                'rt',
                'rw'
            ])
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return PeopleResource::collection($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(People $people)
    {
        return PeopleResource::make($people);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PeopleRequest $request, People $people)
    {
        $validator = $request->safe()->all();
        $people->update($validator);
        return $this->successMessage(PeopleResource::make($people), 'update', $this->modulName);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(People $people)
    {
        $people->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
