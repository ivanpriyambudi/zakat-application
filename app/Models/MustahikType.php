<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MustahikType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function count_mustahik()
    {
        return $this->hasMany(Mustahik::class);
    }
}
