<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $credenciales=$request->only('email', 'password');

        if(Auth::attempt($credenciales)){
            $user= Auth::user();

            if($user->activo){
                return redirect()->intended();
            }else{
                Auth::logout();
                return back()->with('error', 'Su cuenta esta inactiva. Contacte con el administrador');
            }
        }
        return back()->with('error', 'Las credenciales no son correctas')->withInput();
    }
}
