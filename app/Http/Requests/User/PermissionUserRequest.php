<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PermissionUserRequest extends FormRequest
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
        $permissions = collect(config('permission_rules'));

        $final = [];
        foreach ($permissions as $key => $permission) {
            $collect = collect($permission);
            $plucked = $collect->pluck('permission', 'display_name');
            $final[$key] = $plucked->all();
        }

        $collect = collect($final);
        $finalPermissions = $collect->flatten()->toArray();

        return [
            'permissions' => [
                //'required',
                'array',
                Rule::in($finalPermissions),
            ],
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
            'permissions' => 'Permisos',
        ];
    }
}
