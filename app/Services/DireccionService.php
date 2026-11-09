<?php

namespace App\Services;

use App\Exceptions\DireccionInvalidaException;
use App\Models\Contacto;
use App\Models\Direccion;
use App\Models\Localidad;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DireccionService
{
    /**
     * Agrega una dirección al contacto del usuario.
     * Si es la primera, o si se pide, queda como principal (y se desmarcan las demás).
     *
     * @throws DireccionInvalidaException
     */
    public function agregar(User $user, array $datos, bool $principal = false): Direccion
    {
        return DB::transaction(function () use ($user, $datos, $principal) {
            // Bloqueamos el contacto: si llegan dos pedidos a la vez, el segundo espera
            $contacto = Contacto::whereKey($user->contacto_id)->lockForUpdate()->firstOrFail();

            if (! Localidad::whereKey($datos['localidad_id'])->exists()) {
                throw new DireccionInvalidaException('La localidad elegida no existe.');
            }

            // La primera dirección siempre es la principal
            if (! $contacto->direcciones()->exists()) {
                $principal = true;
            }

            if ($principal) {
                $contacto->direcciones()->update(['es_principal' => false]);
            }

            return $contacto->direcciones()->create([
                'calle'        => $datos['calle'],
                'numero'       => $datos['numero'],
                'piso'         => $datos['piso'] ?? null,
                'departamento' => $datos['departamento'] ?? null,
                'cod_postal'   => $datos['cod_postal'] ?? null,
                'referencia'   => $datos['referencia'] ?? null,
                'localidad_id' => $datos['localidad_id'],
                'es_principal' => $principal,
            ]);
        });
    }

    /**
     * Marca una dirección del usuario como principal y desmarca las demás.
     *
     * @throws DireccionInvalidaException
     */
    public function marcarComoPrincipal(User $user, int $direccionId): Direccion
    {
        return DB::transaction(function () use ($user, $direccionId) {
            $contacto = Contacto::whereKey($user->contacto_id)->lockForUpdate()->firstOrFail();

            // La dirección tiene que ser del usuario (igual que en PedidoService)
            $direccion = $contacto->direcciones()->whereKey($direccionId)->first();

            if (! $direccion) {
                throw new DireccionInvalidaException('La dirección no pertenece al usuario.');
            }

            $contacto->direcciones()
                ->whereKeyNot($direccion->id)
                ->update(['es_principal' => false]);

            $direccion->update(['es_principal' => true]);

            return $direccion;
        });
    }
}