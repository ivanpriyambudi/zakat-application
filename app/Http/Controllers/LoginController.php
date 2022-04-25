<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Traits\AuthThrottle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LoginController extends Controller
{
    use AuthThrottle;

    protected $maxAttempts = 5;

    public function __construct()
    {
        $this->middleware('guest', ['only' => 'showLogin']);
        $this->middleware('auth', ['only' => 'logout']);
    }

    public function showLogin()
    {
        return Inertia::render('Login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $user = User::whereIn('type', ['admin', 'kasir'])
            ->where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            $this->incrementLoginAttempts($request);
            throw ValidationException::withMessages([
                'email' => ['Invalid Credentials'],
            ]);
        }

        Auth::login($user);

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($request->header('X-Inertia')) {
            return Inertia::location('/');
        }
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
