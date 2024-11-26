<?php

namespace App\Policies;

use App\Models\Receta;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecetaPolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede visualizar el modelo (published_at == null).
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewUnpublished(User $user, Receta $receta) {
        return $receta->published_at != null || $user->hasRole(['editor', 'administrador']);
    }

    /**
     * Determina si el usuario puede almacenar el modelo.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function store(User $user) {
        return $user->hasRole(['redactor']);
    }

    /**
     * Determina si el usuario puede actualizar el modelo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Receta $receta) {
        return ($receta->published_at != null && $user->isRecetaOwner($receta)) || $user->hasRole(['redactor']);
    }

    /**
     * Determina si el usuario puede publicar o rechazar el modelo.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function publishOrReject(User $user) {
        return $user->hasRole(['editor', 'administrador']);
    }

    /**
     * Determina si el usuario puede eliminar el modelo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Receta $receta) {
        return $receta->published_at != null && $user->isRecetaOwner($receta) || $user->hasRole(['editor', 'administrador']);
    }

    /**
     * Determina si el usuario puede eliminar el modelo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function destroy(User $user, Receta $receta) {
        return $receta->published_at != null && $user->isRecetaOwner($receta);
    }

    /**
     * Determina si el usuario puede restaurar el modelo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Receta $receta) {
        return $user->isRecetaOwner($receta) || $user->hasRole(['editor', 'administrador']);
    }

    /**
     * Determina si el usuario puede eliminar definitivamente el modelo.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Noticia  $noticia
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Receta $receta) {
        return $user->isRecetaOwner($receta);
    }
}
