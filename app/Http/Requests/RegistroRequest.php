<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegistroRequest extends FormRequest
{
    /**
     * ¿Quién puede enviar este formulario? Cualquiera (es el registro).
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Se ejecuta ANTES de validar: limpiamos el CUIT ("20-30111222-3" → "20301112223").
     */
    protected function prepareForValidation(): void
    {
        if ($this->filled('cuit')) {
            $this->merge(['cuit' => preg_replace('/\D/', '', (string) $this->input('cuit'))]);
        }
    }

    public function rules(): array
    {
        return [
            // Datos de acceso
            'name'     => ['required', 'string', 'max:255', 'unique:users,name'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

            // Datos personales
            'nombre'            => ['required', 'string', 'max:50'],
            'nombre2'           => ['nullable', 'string', 'max:50'],
            'apellido'          => ['required', 'string', 'max:80'],
            'fecha_nacimiento'  => ['required', 'date', 'before:today'],
            'tipo_persona_id'   => ['required', 'exists:tipos_persona,id'],
            'cuit'              => ['nullable', 'digits:11', 'unique:contactos,cuit'],
            'tipo_documento_id' => ['required', 'exists:tipos_documento,id'],
            'numero_documento'  => [
                'required', 'string', 'max:20',
                Rule::unique('contactos', 'numero_documento')
                    ->where('tipo_documento_id', $this->input('tipo_documento_id')),
            ],
            'telefono'       => ['required', 'string', 'max:20'],
            'email_contacto' => ['required', 'email', 'max:120'],

            // Dirección
            'provincia_id' => ['required', 'exists:provincias,id'],
            'localidad_id' => [
                'required',
                // La localidad tiene que existir Y ser de la provincia elegida
                Rule::exists('localidades', 'id')->where('provincia_id', $this->input('provincia_id')),
            ],
            'calle'        => ['required', 'string', 'max:120'],
            'numero'       => ['required', 'string', 'max:10'],
            'piso'         => ['nullable', 'string', 'max:10'],
            'departamento' => ['nullable', 'string', 'max:10'],
            'cod_postal'   => ['nullable', 'string', 'max:10'],
            'referencia'   => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Cómo se llama cada campo en los mensajes de error.
     */
    public function attributes(): array
    {
        return [
            'name'              => 'nombre de usuario',
            'email'             => 'correo electrónico',
            'password'          => 'contraseña',
            'nombre2'           => 'segundo nombre',
            'fecha_nacimiento'  => 'fecha de nacimiento',
            'tipo_persona_id'   => 'tipo de persona',
            'cuit'              => 'CUIT',
            'tipo_documento_id' => 'tipo de documento',
            'numero_documento'  => 'número de documento',
            'telefono'          => 'teléfono',
            'email_contacto'    => 'email de contacto',
            'provincia_id'      => 'provincia',
            'localidad_id'      => 'localidad',
            'numero'            => 'numeración',
            'cod_postal'        => 'código postal',
        ];
    }

    /**
     * Mensajes propios para casos puntuales (el resto los da lang/es/validation.php).
     */
    public function messages(): array
    {
        return [
            'name.unique'             => 'Ya existe una cuenta con ese nombre de usuario.',
            'email.unique'            => 'Ya existe una cuenta con ese correo.',
            'cuit.unique'             => 'Ya existe una cuenta con ese CUIT.',
            'numero_documento.unique' => 'Ya existe una cuenta con ese documento.',
            'localidad_id.exists'     => 'La localidad no pertenece a la provincia seleccionada.',
        ];
    }
}