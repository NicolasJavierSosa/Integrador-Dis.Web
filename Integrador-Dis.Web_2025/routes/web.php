<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MisCursosController;
use App\Http\Controllers\AlumnoController;

// Página de inicio general
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// 🔒 Ruta: VER TODOS LOS CURSOS DISPONIBLES
Route::get('/inicioAlumno', [CursoController::class, 'index'])
     ->name('curso.inicio');

// 🔒 Ruta: INSCRIBIRSE A CURSO
Route::post('/curso/{codigo}/inscribirse', [InscripcionController::class, 'inscribir'])
    ->middleware('auth')
    ->name('curso.inscribirse');

// 🔒 Ruta: MIS CURSOS INSCRITOS
Route::middleware(['auth'])->group(function () {
    Route::get('/misCursos', [MisCursosController::class, 'misCursos'])->name('alumno.misCursos');
    Route::delete('/alumno/curso/{curso}', [MisCursosController::class, 'darDeBaja'])->name('alumno.bajaCurso');
});

// Admin protegido// Rutas de Admin protegidas
Route::middleware(['auth'])->group(function () {
    // Página principal del admin
    Route::get('/admin', [AdminController::class, 'gestionCursos'])->name('admin');

    // Dashboard del Admin (redirección)
    Route::get('/dashboard', function() {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    })->name('dashboard');

    // 🔽 Otras rutas
    Route::get('/admin/cursos', [AdminController::class, 'index'])->name('admin.cursos');


    // Rutas para la gestión de cursos por parte del admin
    Route::get('/admin/cursos', [AdminController::class, 'index'])->name('admin.cursos');
    Route::get('/admin/cursos/{codigo}/edit', [AdminController::class, 'editCourse'])->name('admin.cursos.edit');
    Route::post('/admin/cursos', [AdminController::class, 'storeCourse'])->name('admin.cursos.store');
    Route::put('/admin/cursos/{codigo}', [AdminController::class, 'updateCourse'])->name('admin.cursos.update');
    Route::delete('/admin/cursos/{codigo}', [AdminController::class, 'destroyCourse'])->name('admin.cursos.destroy');

    // Rutas para gestión de usuarios y roles del admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/roles', [AdminController::class, 'roles'])->name('admin.roles');

    // Rutas para la gestión de usuarios
    Route::post('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});



// 🔒 Logout
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// 🔑 Rutas de invitado (guest)
Route::middleware((['guest']))->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('registro');
    Route::post('/registro', [AuthController::class, 'register'])->name('register.post');
});


// Otras vistas simples
Route::get('/app', function () {
    return view('estructuras.app', ['nombre' => 'Alumno'] );
});
Route::get('/inicioAdmin', function () {
    return view('admin.inicioAdmin', ['nombre' => 'Adminn'] );
});
Route::get('/gestionCursos', function () {
    return view('admin.gestionCursos', ['nombre' => 'Adminn'] );
});
Route::get('/gestionUsuarios', function () {
    return view('admin.gestionUsuarios', ['nombre' => 'Adminn'] );
})->name('gestionUsuarios');
Route::get('/gestionRoles', function () {
    return view('admin.gestionRoles', ['nombre' => 'Adminn'] );
})->name('gestionRoles');
