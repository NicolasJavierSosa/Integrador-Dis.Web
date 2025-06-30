<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;

class InscripcionController extends Controller
{
    public function inscribir(Request $request, $codigo)
    {
        // Verificar autenticación
        if (!Auth::check()) {
            return redirect()->route('login')
                   ->with('error', 'Debes iniciar sesión para inscribirte.');
        }

        try {
            $curso = Curso::findOrFail($codigo);
            $user = Auth::user();

            // Verificar si ya está inscrito
            if ($user->cursos()->where('codigo', $codigo)->exists()) {
                return redirect()->back()
                       ->with('info', 'Ya estás inscrito en este curso.');
            }

            // Realizar la inscripción
            $user->cursos()->attach($codigo, [
                'fecha_inscripcion' => now(),  // Usar el nombre correcto del campo
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Redireccionar con mensaje de éxito
            return redirect()->back()
                   ->with('success', '¡Inscripción exitosa! Ahora estás registrado en '.$curso->nombre);

        } catch (\Exception $e) {
            // Manejo de errores
            return redirect()->back()
                   ->with('error', 'Ocurrió un error: '.$e->getMessage());
        }
    }
}