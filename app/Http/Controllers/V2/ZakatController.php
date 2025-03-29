<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZakatRequest;
use App\Http\Resources\BackOffice\ZakatResource;
use App\Models\People;
use App\Models\Zakat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ZakatController extends Controller
{
    private $modulName = "Zakat";

    public function index()
    {
        $data = QueryBuilder::for(Zakat::class)
            ->with([
                'people.rt',
                'people.rw',
                'amount_type',
                'year_period'
            ])
            ->allowedSorts([
                'created_at',
            ])
            ->allowedFilters([
                'year_period_id',
                AllowedFilter::scope('rw'),
                AllowedFilter::scope('rt'),
            ])
            ->paginate($this->getLimit());

        return ZakatResource::collection($data);
    }

    public function store(ZakatRequest $request)
    {
        $validator = $request->safe()->all();

        DB::beginTransaction();
        try {
            $people = People::firstOrCreate([
                'rt_id' => $validator['rt_id'],
                'rw_id' => $validator['rw_id'],
                'name' => $validator['name'],
            ]);

            $zakat = Zakat::create([
                'people_id' => $people->id,
                'amount_type_id' => $validator['amount_type_id'],
                'amount' => $validator['amount'],
                'type' => $validator['type'],
            ]);

            return $this->successMessage(ZakatResource::make($zakat), 'store', $this->modulName);
        } catch (Exception $error) {
            DB::rollback();
            throw $error;
        }
    }

    public function show(Zakat $zakat)
    {
        return ZakatResource::make($zakat);
    }

    public function update(ZakatRequest $request, Zakat $zakat)
    {
        $validator = $request->safe()->all();
        $zakat->update($validator);
        return $this->successMessage(ZakatResource::make($zakat), 'update', $this->modulName);
    }

    public function destroy(Zakat $zakat)
    {
        $zakat->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
