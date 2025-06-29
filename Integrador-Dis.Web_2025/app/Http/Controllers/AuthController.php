<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index() {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request) {
        $loginData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        if (Auth::attempt($loginData)) {
            $request->session()->regenerate();
            if (Auth::user()->role === 'admin') {
                return redirect()->route('dashboard');
            }
            else {
                return redirect()->route('welcome');
            }
        } else {
            return back()->withErrors([
                'email' => 'El usuario o la contraseña son incorrectos.',
            ]);
        }
    }

    public function logout(Request $request) {
        if (Auth::check()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('welcome')->with('success', 'Has cerrado sesión correctamente.');
        }
        return redirect()->route('welcome')->with('error', 'No estás autenticado.');
    }
}
