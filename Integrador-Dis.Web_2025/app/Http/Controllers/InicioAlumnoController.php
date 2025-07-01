<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;

class InicioAlumnoController extends Controller
{


    
    public function inscribir(Request $request, $codigo)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para inscribirte.');
        }

        $curso = Curso::findOrFail($codigo);

        $user = Auth::user();

        // Evita duplicados
        if (!$user->cursos->contains($codigo)) {
            $user->cursos()->attach($codigo);
        }

        return redirect()->back()->with('success', 'Te has inscrito correctamente.');
    }

    
}
