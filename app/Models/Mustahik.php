<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mustahik extends Model
{
    use HasFactory;

    protected $fillable = [
        'rt_id',
        'rw_id',
        'mustahik_type_id',
        'mustahik_status_id',
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

    public function mustahik_type()
    {
        return $this->belongsTo(MustahikType::class);
    }

    public function mustahik_status()
    {
        return $this->belongsTo(MustahikStatus::class);
    }
}
