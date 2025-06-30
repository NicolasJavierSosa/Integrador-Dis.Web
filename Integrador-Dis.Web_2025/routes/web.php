<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\MisCursosController;


Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.gestionCursos');
    })->name('admin');
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::get('/inicioAlumno', [CursoController::class, 'index'])
     ->name('curso.inicio');

Route::post('/curso/{codigo}/inscribirse', [InscripcionController::class, 'inscribir'])
    ->middleware('auth')
    ->name('curso.inscribirse');


Route::middleware(['auth'])->group(function () {
    Route::get('/misCursos', [MisCursosController::class, 'misCursos'])->name('alumno.misCursos');
});

Route::delete('/alumno/curso/{curso}', [MisCursosController::class, 'darDeBaja'])->name('alumno.bajaCurso');


Route::middleware((['guest']))->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('registro');
    Route::post('/registro', [AuthController::class, 'register'])->name('register.post');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function() {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
    })->name('dashboard');

    //Rutas de administrador
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/courses', [AdminController::class, 'courses'])->name('admin.courses');
    Route::get('/admin/roles', [AdminController::class, 'roles'])->name('admin.roles');
    
    // Rutas para ABM de usuarios
    Route::post('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('/admin/users/update', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    //Rutas para ABM de cursos
});