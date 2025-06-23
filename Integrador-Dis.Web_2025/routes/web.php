<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('InicioSesion');
});

//Route::view('/Inicio', 'Inicio' ); es lo mismo que lo siguiente:
Route::get('/inicioAdmin', function () {
    return view('admin.inicioAdmin', ['nombre' => 'Administrador'] );
});

//
Route::get('/app', function () {
    return view('app', ['nombre' => 'Adminn'] );
});

Route::get('/gestionCursos', function () {
    return view('admin.gestionCursos', ['nombre' => 'Adminn'] );
});
Route::get('/gestionUsuarios', function () {
    return view('admin.gestionUsuarios', ['nombre' => 'Adminn'] );
});
