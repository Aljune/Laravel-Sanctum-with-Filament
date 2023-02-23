<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
    
     */
    public function viewAny(User $user)
    {
        return $user->hasRole(['Admin','Writer']);
    }

    /**
     * Determine whether the user can view the model.
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     * @param \App\Models\User $user;
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole(['Admin','Writer']);
    }

    /**
     * Determine whether the user can update the model.
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user)
    {
        return $user->hasRole(['Admin','Writer']);
    }

    /**
     * Determine whether the user can delete the model.
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user)
    {
        return $user->hasRole(['Admin','Writer']);
    }

    /**
     * Determine whether the user can restore the model.
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Role $role)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Role $role)
    {
        //
    }
}
