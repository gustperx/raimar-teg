<?php

namespace App\Http\Requests\MedicalEquipment;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalEquipmentRequest extends FormRequest
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
            'category_id' => ['required', 'numeric', 'max:191', 'exists:categories,id'],
            'status_id' => ['nullable', 'numeric', 'max:191', 'exists:statuses,id'],
            'code' => ['nullable', 'string', 'max:191', 'unique:medical_equipments'],
            'serial' => ['required', 'string', 'max:191', 'unique:medical_equipments'],
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
