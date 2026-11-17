<?php

namespace App\Http\Controllers;

use App\Exceptions\PedidoInvalidoException;
use App\Models\EstadoPedido;
use App\Models\Pedido;
use App\Services\PedidoService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PanelPedidosController extends Controller
{
    /**
     * Todos los pedidos, con filtro por estado y búsqueda por número, usuario o correo.
     * (La vista "vistas_admin.panel_pedidos_admin" la arma el frontend.)
     */
    public function index(Request $request)
    {
        $estadoId = $request->integer('estado_pedido_id') ?: null;
        $busqueda = $request->string('q')->trim()->limit(100, '')->value();

        $pedidos = Pedido::query()
            ->with(['user', 'estadoPedido', 'detalles'])
            ->when($estadoId, fn ($query, $id) => $query->where('estado_pedido_id', $id))
            ->when($busqueda, function ($query, $texto) {
                $query->where(function ($q) use ($texto) {
                    if (ctype_digit($texto)) {
                        $q->whereKey((int) $texto); // "15" → pedido #15
                    }

                    $q->orWhereHas('user', fn ($u) => $u
                        ->where('name', 'like', "%{$texto}%")
                        ->orWhere('email', 'like', "%{$texto}%"));
                });
            })
            ->latest('fecha_ped')
            ->latest('id')
            ->paginate(20)
            ->withQueryString();

        return view('vistas_admin.panel_pedidos_admin', [
            'pedidos' => $pedidos,
            'estados' => EstadoPedido::orderBy('id')->get(),
            'filtros' => ['estado_pedido_id' => $estadoId, 'q' => $busqueda],
        ]);
    }

    /**
     * Detalle de un pedido con los estados a los que puede pasar.
     * (La vista "vistas_admin.panel_pedido_detalle" la arma el frontend.)
     */
    public function show(Pedido $pedido)
    {
        $pedido->load(['user.contacto', 'detalles.producto', 'estadoPedido', 'metodoPago', 'direccionEnvio.localidad']);

        return view('vistas_admin.panel_pedido_detalle', [
            'pedido'            => $pedido,
            'estadosSiguientes' => EstadoPedido::TRANSICIONES[$pedido->estadoPedido->descripcion] ?? [],
        ]);
    }

    /**
     * Cambia el estado del pedido (las transiciones válidas las controla PedidoService).
     */
    public function cambiarEstado(Request $request, Pedido $pedido, PedidoService $pedidos)
    {
        $datos = $request->validate([
            'estado' => ['required', Rule::in(array_keys(EstadoPedido::TRANSICIONES))],
        ]);

        try {
            $pedido = $pedidos->cambiarEstado($pedido, $datos['estado']);
        } catch (PedidoInvalidoException $e) {
            return back()->withErrors(['estado' => $e->getMessage()]);
        }

        return back()->with('success', "El pedido #{$pedido->id} pasó a \"{$pedido->estadoPedido->descripcion}\".");
    }
}