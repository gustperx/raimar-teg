<?php

namespace App\Http\Requests\ComputerEquipment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateComputerEquipmentRequest extends FormRequest
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
            'category_id' => ['required', 'numeric', 'max:191', 'exists:categories'],
            'status_id' => ['required', 'numeric', 'max:191', 'exists:statuses'],
            'code' => ['required', 'string', 'max:191', Rule::unique('computer_equipments')->ignore($this->computer_equipment)],
            'serial' => ['required', 'string', 'max:191', Rule::unique('computer_equipments')->ignore($this->computer_equipment)],
            'description' => ['required', 'string', 'max:191'],
            'brand' => ['required', 'string', 'max:191'],
            'model' => ['required', 'string', 'max:191'],
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
