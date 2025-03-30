<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionSettingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_period_id',
        'mustahik_id',
        'mustahik_type_id',
        'amount',
    ];

    public function scopeContext(Builder $query, $value)
    {
        return $value === 'additional' ? $query->whereNotNull('mustahik_id') : $query->whereNull('mustahik_id');
    }

    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class, 'mustahik_id');
    }

    public function mustahikType()
    {
        return $this->belongsTo(MustahikType::class, 'mustahik_type_id');
    }
}
