<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

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

        // 🗝️ Este hace la magia:
        return redirect()->intended(route('curso.inicio'));
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

    public function showRegister() {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'dni' => 'required|numeric|digits:8|unique:users,dni',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'nullable|in:M,F,X',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|in:student,teacher',
            'terms' => 'required|accepted'
        ]);

        try {
            $user = new User();
            $user->name = $validatedData['name'];
            $user->surname = $validatedData['surname'];
            $user->dni = $validatedData['dni'];
            $user->email = $validatedData['email'];
            $user->password = Hash::make($validatedData['password']);
            $user->gender = $validatedData['gender'] ?? 'X';
            $user->birth_date = $validatedData['birth_date'];
            $user->address = $validatedData['address'];
            $user->phone = $validatedData['phone'];
            $user->role = $validatedData['role'];
            
            $user->save();

            return redirect()->route('login')->with('success', 'Usuario registrado correctamente. Puedes iniciar sesión.');
            
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Error al registrar el usuario: ' . $e->getMessage());
        }
    }
}
