<?php

namespace App\Policies;

use App\Models\MedicalEquipment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MedicalEquipmentPolicy
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
        return $user->can('technical:medicalEquipments-read');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, MedicalEquipment $medicalEquipment)
    {
        return $user->can('technical:medicalEquipments-read');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('technical:medicalEquipments-create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, MedicalEquipment $medicalEquipment)
    {
        return $user->can('technical:medicalEquipments-update');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, MedicalEquipment $medicalEquipment)
    {
        return $user->can('technical:medicalEquipments-delete');
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('technical:medicalEquipments-restore');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, MedicalEquipment $medicalEquipment)
    {
        return $user->can('technical:medicalEquipments-restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\MedicalEquipment  $medicalEquipment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, MedicalEquipment $medicalEquipment)
    {
        return $user->can('technical:medicalEquipments-force-delete');
    }
}
