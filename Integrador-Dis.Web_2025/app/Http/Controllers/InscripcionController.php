<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

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
            $curso = Course::findOrFail($codigo);
            $user = Auth::user();

            // Verificar si ya está inscrito - CORREGIDO
            if ($user->cursos()->where('cursos.codigo', $codigo)->exists()) {
                return redirect()->back()
                       ->with('info', 'Ya estás inscrito en este curso.');
            }

            // Verificar si el curso tiene cupos disponibles
            $inscritosCount = $curso->estudiantes()->count();
            if ($inscritosCount >= $curso->cupo) {
                return redirect()->back()->with('error', 'El curso ya no tiene cupos disponibles.');
            }


            // Verificar si aún está en período de inscripción
            if (now()->gt($curso->fecha_limite_inscripcion)) {
                return redirect()->back()
                       ->with('error', 'El período de inscripción para este curso ya ha finalizado.');
            }

            // Realizar la inscripción - CORREGIDO
            $user->cursos()->attach($codigo, [
                'fecha_inscripcion' => now(),
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