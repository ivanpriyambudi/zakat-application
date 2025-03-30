<?php

namespace App\Http\Controllers\V2;

use App\Http\Controllers\Controller;
use App\Http\Requests\DistributionSettingItemRequest;
use App\Http\Resources\DistributionSettingItemResource;
use App\Models\DistributionSettingItem;
use App\Models\YearPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class DistributionSettingItemController extends Controller
{
    private $modulName = "Distribution";

    public function index()
    {
        $year = YearPeriod::active()->first();

        $data = QueryBuilder::for(DistributionSettingItem::where('year_period_id', $year->id))
            ->with([
                'mustahikType',
                'mustahik'
            ])
            ->allowedFilters([
                AllowedFilter::scope('context')
            ])
            ->allowedSorts([
                'created_at',
            ])
            ->paginate($this->getLimit());

        return DistributionSettingItemResource::collection($data);
    }

    public function store(DistributionSettingItemRequest $request)
    {
        $validator = $request->safe()->all();

        DB::beginTransaction();
        try {
            $year = YearPeriod::active()->first();
            $distributionSettingItem = DistributionSettingItem::updateOrCreate(
                [
                    'year_period_id' => $year->id,
                    'mustahik_id' => $validator['mustahik_id'],
                    'mustahik_type_id' => $validator['mustahik_type_id'],

                ],
                [
                    'amount' => $validator['amount'],
                ]
            );

            DB::commit();

            return $this->successMessage(DistributionSettingItemResource::make($distributionSettingItem), 'store', $this->modulName);
        } catch (Exception $error) {
            DB::rollback();
            throw $error;
        }
    }

    public function destroy(DistributionSettingItem $distributionSettingItem)
    {
        $distributionSettingItem->delete();
        return $this->successMessage(null, 'destroy', $this->modulName);
    }
}
