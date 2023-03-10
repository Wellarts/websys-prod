<?php

namespace App\Policies;

use App\Models\Compra;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompraPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('View Compras');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Compra $compra)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('Create Compras');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Compra $compra)
    {
        return $user->hasPermissionTo('Edit Compras');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Compra $compra)
    {
        return $user->hasPermissionTo('Delete Compras');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Compra $compra)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Compra  $compra
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Compra $compra)
    {
        //
    }
}
