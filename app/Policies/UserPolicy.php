<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy {
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model (User).
     *
     * @param  \App\Models\User  $loggedUser
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $loggedUser, User $user) {
        return $loggedUser->id == $user->id;
    }

    /**
     * Determine whether the user can update the model (User).
     *
     * @param  \App\Models\User  $loggedUser
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $loggedUser, User $user) {
        return $loggedUser->id == $user->id;
    }

    /**
     * Determine whether the user can delete the model (User).
     *
     * @param  \App\Models\User  $loggedUser
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $loggedUser, User $user) {
        return $loggedUser->id == $user->id;
    }

    /**
     * Determine whether the user can manage other users.
     *
     * @param  \App\Models\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function manage(User $loggedUser) {
        return $loggedUser->hasRole(['administrador']);
    }

    /**
     * Determine whether the user can add a role to the model (User).
     *
     * @param  \App\Models\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function addRole(User $loggedUser) {
        return $loggedUser->hasRole(['administrador']);
    }

    /**
     * Determine whether the user can remove a model's (User) role.
     *
     * @param  \App\Models\User  $loggedUser
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function removeRole(User $loggedUser) {
        return $loggedUser->hasRole(['administrador']);
    }

    /**
     * Determine whether the user can ban a model (User).
     *
     * @param  \App\Models\User  $loggedUser
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function ban(User $loggedUser, User $user) {
        return $loggedUser->hasRole(['administrador']) && $loggedUser->id != $user->id && !$user->hasRole(['bloqueado']);
    }    

    /**
     * Determine whether the user can unban a model (User).
     *
     * @param  \App\Models\User  $loggedUser
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function unban(User $loggedUser, User $user) {
        return $loggedUser->hasRole(['administrador']) && $loggedUser->id != $user->id && $user->hasRole(['bloqueado']);
    }
}
