<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageApiUserController extends ApiController
{

    public function login(Request $request)
    {
        $request->validate(
            [
                'email'    => 'required|string',
                'password' => 'required|string',
            ]
        );

        if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
            activity()
                ->causedBy(Auth::user())
                ->withProperties(['attributes' => ['ip' => request()->ip()]])
                ->event('login')
                ->useLog(Auth::user()->name)
                ->log('El usuario ' . Auth::user()->name . ' inició sesión');

            return response()->json(Auth::user());
        }

        activity()
            ->event('intento de login')
            ->withProperties(['attributes' => ['ip' => request()->ip()]])
            ->log('El usuario con email ' . $request->email . ' intento iniciar sesión');
        return $this->errorResponse('Credenciales invalidas', 401);
    }

    public function logout(Request $request)
    {
        activity()
            ->causedBy(Auth::user())
            ->withProperties(['attributes' => ['ip' => request()->ip()]])
            ->event('logout')
            ->useLog(Auth::user()->name)
            ->log('El usuario ' . Auth::user()->name . ' cerro sesión');
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(Auth::user());
    }


    public function isAuthenticated()
    {
        if (Auth::check()) {
            return response()->json(['isAuth' => true, 'user' => Auth::user()]);
        } else {
            return response()->json(['isAuth' => false, 'user' => new User()]);
        }
    }
}
