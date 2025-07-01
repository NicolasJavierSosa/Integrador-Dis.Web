<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;

class InscripcionController extends Controller
{
    public function inscribir(Request $request, $codigo)
{
    if (!Auth::check()) {
        return redirect()->route('login')
               ->with('error', 'Debes iniciar sesión para inscribirte.');
    }

    try {
        $curso = Curso::findOrFail($codigo);
        $user = Auth::user();

        if ($user->cursos()->where('codigo', $codigo)->exists()) {
            return redirect()->route('curso.inicio')
                   ->with('info', 'Ya estás inscrito en este curso.');
        }

        $user->cursos()->attach($codigo, [
            'fecha_inscripcion' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return redirect()->route('curso.inicio')
               ->with('success', '¡Inscripción exitosa! Ahora estás registrado en '.$curso->nombre);

    } catch (\Exception $e) {
        return redirect()->route('curso.inicio')
               ->with('error', 'Ocurrió un error: '.$e->getMessage());
    }
}

}