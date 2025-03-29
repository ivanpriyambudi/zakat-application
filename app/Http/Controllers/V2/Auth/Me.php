<?php

namespace App\Http\Controllers\V2\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\MeResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Me extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:api',
        ]);
    }

    public function __invoke()
    {
        $user = User::find(Auth::id());
        return MeResource::make($user);
    }
}
