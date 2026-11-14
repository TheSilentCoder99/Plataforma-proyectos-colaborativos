<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;

// Cada método recibe el usuario autenticado (lo inyecta Laravel desde la sesión) y el proyecto (el que el binding cargó). Devuelve true o false; si es false, Laravel responde 403.

// Las policies son reglas que se aplican a cada método de ruta que llama un usuario. Por ejemplo, más abajo se ve que, si se llama a un método update sobre un proyecto, la regla a cumplir es que debes ser el creador de ese proyecto para poder si quiera acceder a la pantalla de edición. Esta policy es con respecto a los proyectos. Se podrían hacer otras con respecto a Users.

// Las policies siempre son clases y están ligadas a un modelo específico. Las Gate (que aquí no usas por ningún lado) son para acciones globales o lógicas de negocio que no dependen directamente de una tabla o modelo de la base de datos (por ejemplo: "ver el panel de administración" o "exportar reportes").
class ProjectPolicy
{
    // Todos los usuarios autenticados pueden ver proyectos (de momento)
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Project $project): bool
    {
        return true;
    }

    // Cualquier autenticado puede crear
    public function create(User $user): bool
    {
        return true;
    }

    // Solo el creador edita
    public function update(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }

    // Solo el creador borra
    public function delete(User $user, Project $project): bool
    {
        return $user->id === $project->user_id;
    }
}