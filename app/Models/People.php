<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class People extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'rt_id',
        'rw_id',
        'name',
    ];

    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }

    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }

    public function zakatYear()
    {
        $year = date("Y");
        $yearActive = YearPeriod::active()->first();

        if ($yearActive) {
            $year = $yearActive->year;
        }

        return $this->hasMany(Zakat::class)->whereYear('created_at', '=', $year)->with('amount_type');
    }

    public function zakatYearV2()
    {
        $yearActive = YearPeriod::active()->first();

        return $this->hasMany(Zakat::class)->where('year_period_id', $yearActive->id)->with('amount_type');
    }

    public function zakatFitrahYear()
    {
        $year = date("Y");
        $yearActive = YearPeriod::active()->first();

        if ($yearActive) {
            $year = $yearActive->year;
        }

        return $this->hasMany(Zakat::class)
            ->whereYear('created_at', '=', $year)
            ->where('type', 'Fitrah')
            ->with('amount_type');
    }

    public function zakatFitrahYearV2()
    {
        $yearActive = YearPeriod::active()->first();

        return $this->hasMany(Zakat::class)
            ->where('year_period_id', $yearActive->id)
            ->where('type', 'Fitrah')
            ->with('amount_type');
    }

    public function donasiYear()
    {
        $year = date("Y");
        $yearActive = YearPeriod::active()->first();

        if ($yearActive) {
            $year = $yearActive->year;
        }

        return $this->hasMany(Zakat::class)
            ->whereYear('created_at', '=', $year)
            ->where('type', 'Donasi')
            ->with('amount_type');
    }

    public function donasiYearV2()
    {
        $yearActive = YearPeriod::active()->first();

        return $this->hasMany(Zakat::class)
            ->where('year_period_id',  $yearActive->id)
            ->where('type', 'Donasi')
            ->with('amount_type');
    }

    public function getSumZakat()
    {
        return (int) $this->zakatYear->sum('amount');
    }
}
