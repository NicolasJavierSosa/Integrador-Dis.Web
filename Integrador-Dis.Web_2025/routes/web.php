<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
 });

Route::get('/app', function () {
    return view('estructuras.app', ['nombre' => 'Alumno'] );
});
Route::get('/inicioAlumno', function () {
    return view('alumnos.inicioAlumno', ['nombre' => 'Alumno'] );
});
Route::get('/inicioAdmin', function () {
    return view('admin.inicioAdmin', ['nombre' => 'Adminn'] );
});
// Route::get('/registro', function () {
//     return view('registro');
// });
// Pantalla de login
Route::get('/login', function () {
    return view('inicioSesion');
})->name('login');

// Pantalla de registro
Route::get('/registro', function () {
    return view('registro');
})->name('registro');


Route::get('/gestionCursos', function () {
    return view('admin.gestionCursos', ['nombre' => 'Adminn'] );
});

Route::get('/gestionUsuarios', function () {
    return view('admin.gestionUsuarios', ['nombre' => 'Adminn'] );
})->name('gestionUsuarios');

Route::get('/gestionRoles', function () {
    return view('admin.gestionRoles', ['nombre' => 'Adminn'] );
})->name('gestionRoles');

Route::get('/cursosAlumno', function () {
    return view('alumnos.cursosAlumno', ['nombre' => 'Alumno'] );
})->name('cursosAlumno');