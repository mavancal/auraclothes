<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CambiarPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ruta ya exige haber iniciado sesión
    }

    public function rules(): array
    {
        return [
            // current_password: compara con la contraseña del usuario que inició sesión
            'password_actual' => ['required', 'current_password'],
            'password'        => ['required', 'string', 'min:8', 'confirmed', 'different:password_actual'],
        ];
    }

    public function attributes(): array
    {
        return [
            'password_actual' => 'contraseña actual',
            'password'        => 'nueva contraseña',
        ];
    }

    public function messages(): array
    {
        return [
            'password_actual.current_password' => 'La contraseña actual no es correcta.',
            'password.different'               => 'La nueva contraseña tiene que ser distinta de la actual.',
        ];
    }
}