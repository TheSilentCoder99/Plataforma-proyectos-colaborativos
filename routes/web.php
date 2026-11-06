<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Este archivo es donde se declaran las rutas que te llevan al crud


require __DIR__.'/auth.php';

// Envío al cliente al formulario de creación de un nuevo usuario
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// Regla práctica: las rutas específicas (fijas) van antes que las que tienen parámetros.

// Envío al cliente al index donde se muestran todos los proyectos. Dará igual que no ponga nada o que ponga index: van a llegar al mismo sitio. ¿Debo dejar que alguien vea los proyectos si no ha iniciado sesión? Mejor no, quizá por privacidad

// // Solo pueden ejecutar estos métodos los usuarios que han iniciado sesión
Route::middleware('auth')->group(function () {

Route::get('/', [ProjectController::class, 'index'])->name('projects.index');

Route::get('/index', [ProjectController::class, 'index'])->name('projects.index');

// A través de un id específico, muestro todos los detalles de un usuario. Laravel "adivinará" que estoy buscando un usuario por cómo está construida la URL.
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// Las URLs se parecen y es confuso, pero la diferencia entre estos dos, es que en el de arriba no puedes escribir ni modificar nada y el de abajo sí.

// Muestra el formulario de actualización de un usuario
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');


// Ejecuta el contenido del formulario de actualización de un usuario, o sea, lo actualiza en la BD. Aquí también se usa el Route Model Binding
Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

});