<?php

namespace App\Http\Controllers\V2\Auth;

use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class Logout extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:api',
        ]);
    }

    public function __invoke()
    {
        $removeToken = JWTAuth::invalidate(JWTAuth::getToken());

        if($removeToken) {
            return response()->json([
                'success' => true,
                'message' => 'Logout Berhasil!',
            ]);
        }
    }
}
