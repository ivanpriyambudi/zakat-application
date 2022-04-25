<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    use HasFactory;

    protected $fillable = [
        'rw_id',
        'name',
    ];

    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }

    public function people()
    {
        return $this->hasMany(People::class);
    }

    public function mustahik()
    {
        return $this->hasMany(Mustahik::class);
    }

    public function mustahikTambahan()
    {
        return $this->hasMany(Mustahik::class)->where('distribution', '!=', null);
    }
}
