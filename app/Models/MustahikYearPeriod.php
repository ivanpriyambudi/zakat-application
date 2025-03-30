<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MustahikYearPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_period_id',
        'mustahik_id',
        'mustahik_type_id'
    ];

    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class, 'mustahik_id');
    }

    public function mustahikType()
    {
        return $this->belongsTo(Mustahik::class, 'mustahik_type_id');
    }

    public function scopeKeyword(Builder $query, $value): Builder
    {
        return $query->whereHas('mustahik', function($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        });
    }
}
