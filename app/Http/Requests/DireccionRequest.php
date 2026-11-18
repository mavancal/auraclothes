<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DireccionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // la ruta ya exige haber iniciado sesión
    }

    public function rules(): array
    {
        return [
            'provincia_id' => ['required', 'exists:provincias,id'],
            'localidad_id' => [
                'required',
                Rule::exists('localidades', 'id')->where('provincia_id', $this->input('provincia_id')),
            ],
            'calle'        => ['required', 'string', 'max:120'],
            'numero'       => ['required', 'string', 'max:10'],
            'piso'         => ['nullable', 'string', 'max:10'],
            'departamento' => ['nullable', 'string', 'max:10'],
            'cod_postal'   => ['nullable', 'string', 'max:10'],
            'referencia'   => ['nullable', 'string', 'max:255'],
            'es_principal' => ['nullable', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'provincia_id' => 'provincia',
            'localidad_id' => 'localidad',
            'numero'       => 'numeración',
            'cod_postal'   => 'código postal',
            'es_principal' => 'dirección principal',
        ];
    }

    public function messages(): array
    {
        return [
            'localidad_id.exists' => 'La localidad no pertenece a la provincia seleccionada.',
        ];
    }
}