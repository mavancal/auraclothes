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
        public const MENSAJE_USADA = 'Esta dirección ya se usó en un pedido, así que no se puede modificar. Si cambió, agregá una dirección nueva.';
    public const MENSAJE_ELIMINAR_USADA = 'Esta dirección ya se usó en un pedido, así que no se puede eliminar.';
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
    /**
     * Busca una dirección SOLO entre las del usuario y verifica que se pueda editar
     * (que no se haya usado en ningún pedido).
     *
     * @throws DireccionInvalidaException
     */
    public function paraEditar(User $user, int $direccionId): Direccion
    {
        $direccion = Direccion::where('contacto_id', $user->contacto_id)->find($direccionId);

        if (! $direccion) {
            throw new DireccionInvalidaException('La dirección no pertenece al usuario.');
        }

        // Los pedidos apuntan a esta fila: si la cambiáramos, los pedidos viejos
        // pasarían a mostrar una dirección a la que nunca se enviaron.
        if ($direccion->pedidos()->exists()) {
            throw new DireccionInvalidaException(self::MENSAJE_USADA);
        }

        return $direccion;
    }

    /**
     * Corrige los datos de una dirección propia que todavía no se usó en pedidos.
     * (Si es o no la principal se maneja con marcarComoPrincipal.)
     *
     * @throws DireccionInvalidaException
     */
    public function actualizar(User $user, int $direccionId, array $datos): Direccion
    {
        return DB::transaction(function () use ($user, $direccionId, $datos) {
            // Mismo bloqueo que en agregar(): una operación sobre las direcciones del contacto a la vez
            Contacto::whereKey($user->contacto_id)->lockForUpdate()->firstOrFail();

            $direccion = $this->paraEditar($user, $direccionId);

            if (! Localidad::whereKey($datos['localidad_id'])->exists()) {
                throw new DireccionInvalidaException('La localidad elegida no existe.');
            }

            $direccion->update([
                'calle'        => $datos['calle'],
                'numero'       => $datos['numero'],
                'piso'         => $datos['piso'] ?? null,
                'departamento' => $datos['departamento'] ?? null,
                'cod_postal'   => $datos['cod_postal'] ?? null,
                'referencia'   => $datos['referencia'] ?? null,
                'localidad_id' => $datos['localidad_id'],
            ]);

            return $direccion;
        });
    }

    /**
     * Elimina una dirección propia del usuario siempre que no haya sido usada en ningún pedido.
     * Si la dirección era la principal y quedan otras, promueve una a principal.
     *
     * @throws DireccionInvalidaException
     */
    public function eliminar(User $user, int $direccionId): void
    {
        DB::transaction(function () use ($user, $direccionId) {
            $contacto = Contacto::whereKey($user->contacto_id)->lockForUpdate()->firstOrFail();

            $direccion = $contacto->direcciones()->whereKey($direccionId)->first();

            if (! $direccion) {
                throw new DireccionInvalidaException('La dirección no pertenece al usuario.');
            }

            if ($direccion->pedidos()->exists()) {
                throw new DireccionInvalidaException(self::MENSAJE_ELIMINAR_USADA);
            }

            $eraPrincipal = $direccion->es_principal;

            $direccion->delete();

            if ($eraPrincipal) {
                $otraDireccion = $contacto->direcciones()->first();
                if ($otraDireccion) {
                    $otraDireccion->update(['es_principal' => true]);
                }
            }
        });
    }
}