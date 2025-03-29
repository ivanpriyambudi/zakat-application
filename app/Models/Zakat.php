<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zakat extends Model
{
    use HasFactory;

    protected $fillable = [
        'people_id',
        'amount_type_id',
        'amount',
        'type',
        'year_period_id'
    ];

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    public function amount_type()
    {
        return $this->belongsTo(SatuanZakat::class);
    }

    public function year_period()
    {
        return $this->belongsTo(YearPeriod::class, 'year_period_id');
    }

    public function scopeRw(Builder $query, $value)
    {
        return $query->whereHas('people', function ($query) use ($value) {
            $query->where('rw_id', $value);
        });
    }

    public function scopeRt(Builder $query, $value)
    {
        return $query->whereHas('people', function ($query) use ($value) {
            $query->where('rt_id', $value);
        });
    }
}
