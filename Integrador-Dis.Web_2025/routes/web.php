<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.gestionCursos');
    })->name('admin');
    Route::post('/login', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware((['guest']))->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});