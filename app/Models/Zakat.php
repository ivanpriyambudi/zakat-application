<?php

namespace App\Models;

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
    ];

    public function people()
    {
        return $this->belongsTo(People::class);
    }

    public function amount_type()
    {
        return $this->belongsTo(SatuanZakat::class);
    }

    public function amount()
    {
        return $this->belongsTo(People::class);
    }
}
