<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MustahikYearPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
        'year_period_id',
        'mustahik_id'
    ];

    public function mustahik()
    {
        return $this->belongsTo(Mustahik::class, 'mustahik_id');
    }
}
