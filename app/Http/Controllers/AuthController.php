<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginUser;

class AuthController extends APIController
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json();
    }

    public function login(LoginUser $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            //Solo se permite que el usuario tenga un solo dispositivo logueado
            Auth::logoutOtherDevices($credentials['password']);
            $request->session()->regenerate();
            return $this->respondSuccess();
        }

        return $this->respondFailedLogin();
    }
}
