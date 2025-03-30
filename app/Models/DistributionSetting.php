<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistributionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'amil_count',
        'amil_distribution',
        'doa_count',
        'doa_distribution',
        'satuan_zakat_id',
        'year_period_id',
    ];

    public function satuan_zakat()
    {
        return $this->belongsTo(SatuanZakat::class, 'satuan_zakat_id');
    }
}
