<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Primero las rutas con parámetros fijos, luego el resto
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. RUTA RAÍZ: Cuando entren a la web sin loguearse, los mandamos al login de Breeze (modificarlo para que tenga la apariencia que yo quiera)
Route::get('/', function () {
    return redirect()->route('login');
});

// 2. RUTAS DE AUTENTICACIÓN (Login, Registro, Password, etc.)
// Estas vienen del archivo oculto de Breeze e incluyen /login, /register, etc.
require __DIR__.'/auth.php';


// 3. ZONA BLINDADA: Solo pueden entrar los usuarios que YA han iniciado sesión (se le podrían añadir más "porteros" como 'verified' pero creo que con estar autenticado es suficiente)
Route::middleware('auth')->group(function () {


    // Rutas "sólidas" de proyectos (¡SIEMPRE ANTES de las que tienen {project}!)
    // Una vez logueados, los mandamos al listado de proyectos
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');

    Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');

    // Rutas con parámetros y acciones del CRUD de usuarios
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

    Route::get('/projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');

    Route::patch('/projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    
    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');


    // Rutas específicas de usuarios (¡SIEMPRE ANTES de las que tienen {user}!)

     Route::get('/users', [UserController::class, 'index'])->name('projects.index');

    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

    // Rutas con parámetros y acciones del CRUD de usuarios
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');


});

