<?php

namespace App\Http\Requests\MedicalEquipment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMedicalEquipmentRequest extends FormRequest
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
            'department_id' => ['required', 'numeric', 'exists:departments,id'],
            'category_id' => ['required', 'numeric', 'exists:categories,id'],
            'status_id' => ['nullable', 'numeric', 'exists:statuses,id'],
            'code' => ['nullable', 'string', 'max:191', Rule::unique('medical_equipments')->ignore($this->medical_equipment)],
            'serial' => ['required', 'string', 'max:191', Rule::unique('medical_equipments')->ignore($this->medical_equipment)],
            'description' => ['required', 'string', 'max:191'],
            'brand' => ['required', 'numeric', 'exists:brands,id'],
            'model' => ['required', 'numeric', 'exists:models,id'],
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
            'category_id' => 'Categoría',
            'status_id' => 'Estatus',
            'code' => 'Código',
            'serial' => 'Serial',
            'description' => 'Descripción',
            'brand' => 'Marca',
            'model' => 'Modelo',
        ];
    }
}
