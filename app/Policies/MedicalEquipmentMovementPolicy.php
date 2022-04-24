<?php

namespace App\Policies;

use App\Models\MedicalEquipmentMovement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MedicalEquipmentMovementPolicy
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
        return $user->can('technical:medicalEquipmentMovements-read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, MedicalEquipmentMovement $medicalEquipmentMovement)
    {
        return $user->can('technical:medicalEquipmentMovements-read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('technical:medicalEquipmentMovements-create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, MedicalEquipmentMovement $medicalEquipmentMovement)
    {
        return $user->can('technical:medicalEquipmentMovements-update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, MedicalEquipmentMovement $medicalEquipmentMovement)
    {
        return $user->can('technical:medicalEquipmentMovements-delete');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('technical:medicalEquipmentMovements-restore');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, MedicalEquipmentMovement $medicalEquipmentMovement)
    {
        return $user->can('technical:medicalEquipmentMovements-restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipmentMovement  $medicalEquipmentMovement
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, MedicalEquipmentMovement $medicalEquipmentMovement)
    {
        return $user->can('technical:medicalEquipmentMovements-force-delete');
    }
}
