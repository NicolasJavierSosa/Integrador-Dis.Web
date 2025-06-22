<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;


class RegisterController extends Controller
{
    public function showRegistroForm(){
        return view('autenticacion.registro');
    }

    public function registrar(UserRequest $request){
        $usuario = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'activo' => 1, // Activar automáticamente
        ]);

        $clienteRol=Role::where('name','cliente')->first();
        if($clienteRol){
            $usuario->assignRole($clienteRol);
        }
        Auth::login($usuario);
        return redirect()->route('dashboard')->with('mensaje', 'Registro exitoso. ¡Bienvenido!');
    }
}
