<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class MisCursosController extends Controller
{
    /**
     * Muestra la pantalla de inicio del alumno con sus cursos inscritos.
     */
    public function misCursos() 
{
    $user = auth()->user();

    // Trae cursos con la cuenta de usuarios inscritos
    $cursos = $user->cursos()
        ->withCount(['usuarios as estudiantes_count' => function($q) {
            $q->where('role', 'student');
        }])
        ->get();

    return view('alumnos.cursosAlumno', compact('cursos'));
}


    public function darDeBaja(Course $curso)
    {
        $user = auth()->user();

        // Quita el curso de la tabla pivot
        $user->cursos()->detach($curso->codigo);

        return back()->with('message', 'Te diste de baja del curso correctamente.');
    }
}
