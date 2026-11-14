<?php

namespace App\Http\Controllers;

// Esto proporciona métodos auxiliares —siendo el principal $this->authorize()— que permiten verificar de forma rápida si el usuario autenticado tiene permiso para realizar una acción específica sobre un recurso (por ejemplo, actualizar o eliminar un modelo).
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
        use AuthorizesRequests;
}
