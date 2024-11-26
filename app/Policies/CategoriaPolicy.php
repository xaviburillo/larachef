<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriaPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario está autorizado para administrar el modelo.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function manage(User $user) {        
        return $user->hasRole(['editor', 'administrador']);
    }
    
    /**
     * Determina si el usuario puede almacenar el modelo.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function store(User $user) {
        return $user->hasRole(['editor', 'administrador']);
    }

    /**
     * Determina si el usuario puede actualizar el modelo.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user) {
        return $user->hasRole(['editor', 'administrador']);
    }

    /**
     * Determina si el usuario puede eliminar el modelo.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user) {
        return $user->hasRole(['editor', 'administrador']);
    }
}
