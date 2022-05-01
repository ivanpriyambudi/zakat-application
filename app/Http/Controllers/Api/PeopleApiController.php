<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\People;

class PeopleApiController extends Controller
{
    public function getSearch(Request $request)
    {
        $keyword = $request->keyword;

        $people = People::where('name', 'LIKE', '%' . $keyword . '%')
            ->with([
                'rw',
                'rt',
            ])
            ->limit(10)
            ->get();

        // $peoples = $people->groupBy(['rw.name', 'rt.name']);

        return response()->json($people);
    }
}
