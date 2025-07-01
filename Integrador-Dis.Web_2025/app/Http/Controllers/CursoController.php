<?php

namespace App\Http\Controllers;

use App\Models\Course;

class CursoController extends Controller
{
    /**
     * Mostrar la página de inicio con todos los cursos.
     */
    public function index()
    {
        // Trae TODOS los cursos de la base
        $cursos = Course::all();

        // Devuelve la vista pasando la colección
        return view('alumnos.inicioAlumno', compact('cursos'));
    }
}
