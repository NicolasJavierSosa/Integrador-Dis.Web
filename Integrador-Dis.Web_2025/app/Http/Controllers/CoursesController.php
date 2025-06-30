<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;

class CoursesController extends Controller
{
    public function courses() {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado');
            return view('/dashboard');
        }

        $courses = Course::with('inscriptions')->get();
        return view('admin.courses', compact('courses'));
    }
    
    // Métodos ABM para Cursos
    // public function
}
