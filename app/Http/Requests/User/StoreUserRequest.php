<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:191', 'unique:users'],
            'dni' => ['required', 'digits_between:7,8', 'unique:users'],
            'department_id' => ['required', 'numeric', 'max:191', 'exists:departments,id'],
            'allow_login' => ['required', 'boolean'],
            'dni_type' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'address' => ['required', 'string', 'max:191'],
            'phone' => ['required', 'digits:7'],
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
            'name' => 'Nombre y apellido del personal',
            'email' => 'Correo electrónico del personal',
            'dni' => 'Numero de cedula de identidad',
            'department_id' => 'Departamento o Unidad del Usuario',
            'allow_login' => 'Permitir iniciar sesión',
            'password' => 'Contraseña',
            'dni_type' => 'Venezolano o Extranjero',
            'gender' => 'Género o Sexo del usuario',
            'address' => 'Dirección de Residencia del personal',
            'phone' => 'Teléfono del Usuario',
        ];
    }
}
