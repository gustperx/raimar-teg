<?php

namespace App\Policies;

use App\Models\ComputerEquipment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComputerEquipmentPolicy
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
        return $user->can('technical:computerEquipments-read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ComputerEquipment $computerEquipment)
    {
        return $user->can('technical:computerEquipments-read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('technical:computerEquipments-create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ComputerEquipment $computerEquipment)
    {
        return $user->can('technical:computerEquipments-update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ComputerEquipment $computerEquipment)
    {
        return $user->can('technical:computerEquipments-delete');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('technical:computerEquipments-restore');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ComputerEquipment $computerEquipment)
    {
        return $user->can('technical:computerEquipments-restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ComputerEquipment  $computerEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ComputerEquipment $computerEquipment)
    {
        return $user->can('technical:computerEquipments-force-delete');
    }
}
