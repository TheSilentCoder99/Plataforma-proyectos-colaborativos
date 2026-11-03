<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Este archivo es donde se declaran las rutas que te llevan al crud


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// // Solo pueden ejecutar estos métodos los usuarios que han iniciado sesión
// Route::middleware('auth')->group(function () {

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';

// Regla práctica: las rutas específicas (fijas) van antes que las que tienen parámetros.

// Envío al cliente al index donde se muestran todos los usuarios. Dará igual que no ponga nada o que ponga index: van a llegar al mismo sitio
Route::get('/', [UserController::class, 'index'])->name('users.index');
Route::get('/index', [UserController::class, 'index'])->name('users.index');


// Envío al cliente al formulario de creación de un nuevo usuario
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// A través de un id específico, muestro todos los detalles de un usuario. Laravel "adivinará" que estoy buscando un usuario por cómo está construida la URL.
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// Las URLs se parecen y es confuso, pero la diferencia entre estos dos, es que en el de arriba no puedes escribir ni modificar nada y el de abajo sí.

// Muestra el formulario de actualización de un usuario
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');


// Ejecuta el contenido del formulario de actualización de un usuario, o sea, lo actualiza en la BD. Aquí también se usa el Route Model Binding
Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');

Route::delete('/users/{user}/delete', [UserController::class, 'destroy'])->name('users.destroy');