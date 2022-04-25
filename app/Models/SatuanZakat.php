<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuanZakat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'kilo',
        'is_primary',
    ];
}
