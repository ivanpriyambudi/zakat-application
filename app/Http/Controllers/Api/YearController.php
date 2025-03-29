<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\YearPeriod;
use Illuminate\Http\Request;

class YearController extends Controller
{
    public function getData()
    {
        $years = YearPeriod::all();

        return response()->json($years);
    }
}
