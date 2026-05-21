<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('modules/auth/login');
    }

    public function logear(Request $request)
    {
        $credenciales = [
            'email'    => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credenciales)) {
            if (Auth::user()->rol === 'administrador') {
                return to_route('admin.home');
            }
            return to_route('home');
        } else {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'El correo o la contraseña son incorrectos.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return to_route('login');
    }

    public function home()
    {
        if (Auth::user()->rol === 'administrador') {
            return to_route('admin.home');
        }
        return view('modules/dashboard/home');
    }

    public function adminHome()
    {
        if (Auth::user()->rol !== 'administrador') {
            return to_route('home');
        }
        return view('modules/dashboard/admin_home');
    }
}
