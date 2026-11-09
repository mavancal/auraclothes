<?php

namespace App\Services;

use App\Exceptions\RegistroInvalidoException;
use App\Models\Contacto;
use App\Models\Localidad;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegistroService
{
    /**
     * Registra un cliente nuevo: Contacto + Dirección principal + User + rol Cliente.
     *
     * @throws RegistroInvalidoException
     */
    public function registrar(array $datos): User
    {
        // El CUIT puede venir con guiones ("20-30111222-3"): dejamos solo los dígitos
        $cuit = isset($datos['cuit']) && $datos['cuit'] !== ''
            ? preg_replace('/\D/', '', $datos['cuit'])
            : null;

        return DB::transaction(function () use ($datos, $cuit) {
            // 1. Reglas de negocio: nada repetido y datos que existan
            if (User::where('name', $datos['name'])->exists()) {
                throw new RegistroInvalidoException('El nombre de usuario ya está en uso.');
            }

            if (User::where('email', $datos['email'])->exists()) {
                throw new RegistroInvalidoException('Ya existe una cuenta con ese correo.');
            }

            $documentoRepetido = Contacto::where('tipo_documento_id', $datos['tipo_documento_id'])
                ->where('numero_documento', $datos['numero_documento'])
                ->exists();

            if ($documentoRepetido) {
                throw new RegistroInvalidoException('Ya existe una cuenta con ese documento.');
            }

            if ($cuit !== null && Contacto::where('cuit', $cuit)->exists()) {
                throw new RegistroInvalidoException('Ya existe una cuenta con ese CUIT.');
            }

            if (! Localidad::whereKey($datos['localidad_id'])->exists()) {
                throw new RegistroInvalidoException('La localidad elegida no existe.');
            }

            $rolCliente = Rol::where('nombre_rol', 'Cliente')->first();

            if (! $rolCliente) {
                throw new RegistroInvalidoException('No está cargado el rol Cliente.');
            }

            // 2. El contacto (datos personales)
            $contacto = Contacto::create([
                'nombre'            => $datos['nombre'],
                'nombre2'           => $datos['nombre2'] ?? null,
                'apellido'          => $datos['apellido'],
                'tipo_documento_id' => $datos['tipo_documento_id'],
                'numero_documento'  => $datos['numero_documento'],
                'cuit'              => $cuit,
                'fecha_nacimiento'  => $datos['fecha_nacimiento'] ?? null,
                'telefono'          => $datos['telefono'] ?? null,
                'email_contacto'    => $datos['email_contacto'],
                'tipo_persona_id'   => $datos['tipo_persona_id'],
            ]);

            // 3. Su primera dirección, que siempre es la principal
            $contacto->direcciones()->create([
                'calle'        => $datos['calle'],
                'numero'       => $datos['numero'],
                'piso'         => $datos['piso'] ?? null,
                'departamento' => $datos['departamento'] ?? null,
                'cod_postal'   => $datos['cod_postal'] ?? null,
                'referencia'   => $datos['referencia'] ?? null,
                'localidad_id' => $datos['localidad_id'],
                'es_principal' => true,
            ]);

            // 4. El usuario (la contraseña se hashea sola por el cast 'hashed')
            $user = User::create([
                'name'        => $datos['name'],
                'email'       => $datos['email'],
                'password'    => $datos['password'],
                'contacto_id' => $contacto->id,
            ]);

            // 5. El rol Cliente (fecha_asig se completa sola con useCurrent)
            $user->roles()->attach($rolCliente->id);

            return $user;
        });
    }
}