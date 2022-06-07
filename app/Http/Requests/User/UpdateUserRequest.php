<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'string', 'email', 'max:191', Rule::unique('users')->ignore($this->user)],
            'dni' => ['required', 'string', 'max:191', 'min:6', Rule::unique('users')->ignore($this->user)],
            'department_id' => ['required', 'numeric', 'max:191', 'exists:departments,id'],
            'allow_login' => ['required', 'boolean'],
            'dni_type' => ['required', 'string'],
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
            'name' => 'Nombre',
            'email' => 'Correo electrónico',
            'dni' => 'Documento de identidad',
            'department_id' => 'Departamento',
            'allow_login' => 'Permitir iniciar sesión',
            'password' => 'Contraseña',
            'dni_type' => 'Tipo'
        ];
    }
}
