<?php

namespace App\Http\Controllers\V2\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResponse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function __invoke(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email or password has not match'
            ], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = auth('api')->login($user);

        return BaseResponse::instance()->setData([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ])->build();
    }
}
