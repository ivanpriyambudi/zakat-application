<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Models\MustahikStatus;

class MustahiStatusApiController extends Controller
{
    public function getData()
    {
        $mustahik_status = MustahikStatus::all();

        return response()->json($mustahik_status);
    }
}
