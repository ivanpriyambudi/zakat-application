<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MustahikStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'distribution',
    ];

    public function mustahik()
    {
        return $this->hasMany(Mustahik::class);
    }
}
