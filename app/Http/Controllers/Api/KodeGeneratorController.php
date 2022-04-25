<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KodeGeneratorController extends Controller
{
    public function makeCode() {
        $kode = Str::random(13);
        return response()->json($kode);
    }
}
