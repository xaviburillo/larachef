<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Valoracion;
use Illuminate\Auth\Access\HandlesAuthorization;

class ValoracionPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede almacenar el modelo.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function store(User $user) {
        return $user->hasRole(['lector', 'redactor', 'editor', 'administrador']);
    }

    /**
     * Determina si el usuario puede actualizar el modelo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Valoracion $valoracion) {
        return $user->isValoracionOwner($valoracion);
    }

    /**
     * Determina si el usuario puede eliminar el modelo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, Valoracion $valoracion) {
        return $user->isValoracionOwner($valoracion) || $user->hasRole(['administrador']);
    }
    
    /**
     * Determina si el usuario puede eliminar definitivamente el modelo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Valoracion  $valoracion
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Valoracion $valoracion) {
        return $user->isValoracionOwner($valoracion);
    }
}
