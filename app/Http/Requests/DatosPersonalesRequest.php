<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DatosPersonalesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ruta ya exige haber iniciado sesión
    }

    /**
     * Solo los datos que el cliente puede cambiar.
     * Nombre, apellido y documento identifican a la persona: no se editan acá.
     */
    public function rules(): array
    {
        return [
            'nombre2'        => ['nullable', 'string', 'max:50'],
            'telefono'       => ['nullable', 'string', 'max:20'],
            'email_contacto' => ['required', 'email', 'max:120'],
        ];
    }

    public function attributes(): array
    {
        return [
            'nombre2'        => 'segundo nombre',
            'telefono'       => 'teléfono',
            'email_contacto' => 'email de contacto',
        ];
    }
}