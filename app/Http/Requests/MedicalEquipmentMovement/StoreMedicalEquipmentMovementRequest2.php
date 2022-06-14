<?php

namespace App\Http\Requests\MedicalEquipmentMovement;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalEquipmentMovementRequest2 extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            /* 'previous_department_id' => ['required', 'numeric', 'max:191', 'exists:departments,id'], */
            'current_department_id' => ['required', 'numeric', 'max:191', 'exists:departments,id'],
            'user_movement_id' => ['required', 'numeric', 'max:191', 'exists:users,id'],
            'user_responsible_id' => ['required', 'numeric', 'max:191', 'exists:users,id'],
            /* 'user_assigned' => ['required', 'string', 'max:191'], */
            'user_assigned_id' => ['required', 'numeric', 'exists:users,id'],
            'equipment_id' => ['required', 'numeric', 'max:191', 'exists:medical_equipments,id'],
            'status_id' => ['required', 'numeric', 'max:191', 'exists:statuses,id'],
            'transfer_date' => ['required', 'date', 'before:tomorrow'],
            'incidence' => ['required', 'string', 'max:191'],
            'period_start' => ['required', 'date', 'after:yesterday'],
            'period_end' => ['required', 'date', 'after:period_start'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'previous_department_id' => 'Departamento anterior',
            'current_department_id' => 'Departamento destinó',
            'user_movement_id' => 'Responsable movimiento',
            'user_responsible_id' => 'Responsable departamento',
            'user_assigned_id' => 'Responsable del equipo',
            'equipment_id' => 'Equipo medicó',
            'status_id' => 'Estatus del equipo',
            'transfer_date' => 'Fecha de transferencia',
            'period_start' => 'Fecha de inicio',
            'period_end' => 'Fecha final',
            'incidence' => 'Incidencia',
        ];
    }
}
