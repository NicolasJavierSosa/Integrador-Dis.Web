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
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para inscribirte.');
        }

        $curso = Curso::findOrFail($codigo);
        $user = Auth::user();

        if (!$user->cursos->contains($codigo)) {
            $user->cursos()->attach($codigo, [
    'created_at' => now(),
    'updated_at' => now(),
]);

        }

        return redirect()->back()->with('success', 'Te has inscrito correctamente.');
    }
}
