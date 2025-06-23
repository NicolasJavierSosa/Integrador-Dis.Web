<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/app', function () {
    return view('app', ['nombre' => 'Adminn'] );
});

Route::get('/gestionCursos', function () {
    return view('admin.gestionCursos', ['nombre' => 'Adminn'] );
});
Route::get('/gestionUsuarios', function () {
    return view('admin.gestionUsuarios', ['nombre' => 'Adminn'] );
});