<?php

namespace App\Http\Requests\ComputerEquipmentMovement;

use Illuminate\Foundation\Http\FormRequest;

class StoreComputerEquipmentMovementRequest extends FormRequest
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
            'user_assigned' => ['required', 'string', 'max:191'],
            'equipment_id' => ['required', 'numeric', 'max:191', 'exists:computer_equipments,id'],
            /* 'status_id' => ['required', 'numeric', 'max:191', 'exists:statuses,id'], */
            'transfer_date' => ['required', 'date', 'before:tomorrow'],
            'incidence' => ['required', 'string', 'max:191'],
            'period' => ['required', 'string', 'max:191'],
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
            'equipment_id' => 'Equipo de computo',
            'status_id' => 'Estatus del equipo',
            'transfer_date' => 'Fecha de transferencia',
            'incidence' => 'Incidencia',
        ];
    }
}
