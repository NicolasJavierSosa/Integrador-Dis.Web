<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InicioAlumnoController extends Controller
{
    public function inscribir(Request $request, $codigo)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para inscribirte.');
        }

        $curso = Course::findOrFail($codigo);

        $user = Auth::user();

        // Evita duplicados
        if (!$user->cursos->contains($codigo)) {
            $user->cursos()->attach($codigo);
        }

        return redirect()->back()->with('success', 'Te has inscrito correctamente.');
    }
}
