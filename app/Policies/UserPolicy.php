<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

// En una Policy, el primer parámetro siempre es el usuario autenticado (lo pone Laravel desde la sesión). El segundo es el modelo sobre el que se actúa. la pregunta es “¿quién eres tú (autenticado) y qué relación tienes con este recurso?”. Solo cambia el recurso.


class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     * Un usuario puede ver otros usuarios
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     * En mi arquitectura un usuario no puede crear otros usuarios
     */
    public function create(User $user): bool
    {
        // Si el usuario es admin, sí puede crear un nuevo usuario
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authUser): bool
    {
        //  Si el usuario es admin, sí puede actualizar un usuario
        return $authUser->is_admin;
;
    }

    /**
     * Determine whether the user can delete the model.
     * Un usuario solo puede borrar su propia cuenta, no puede borrar a otros usuarios
     */
    public function delete(User $authUser): bool
    {
         //  Si el usuario es admin, sí puede borrar un usuario
        return $authUser->is_admin;

        }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
