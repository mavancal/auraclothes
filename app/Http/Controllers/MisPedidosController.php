<?php

namespace App\Http\Controllers;

use App\Exceptions\PedidoInvalidoException;
use App\Models\Pedido;
use App\Services\PedidoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MisPedidosController extends Controller
{
    /**
     * Listado de los pedidos del usuario (la vista "mis-pedidos" la arma el frontend).
     */
    public function index(Request $request)
    {
        return view('mis-pedidos', [
            'pedidos' => Pedido::delUsuario($request->user()->id)
                ->with(['estadoPedido', 'detalles'])
                ->latest('fecha_ped')
                ->latest('id')
                ->paginate(10),
        ]);
    }

    /**
     * Detalle de un pedido (la vista "mis-pedidos-detalle" la arma el frontend).
     */
    public function show(Pedido $pedido)
    {
        Gate::authorize('view', $pedido);

        $pedido->load(['detalles.producto', 'estadoPedido', 'metodoPago', 'direccionEnvio.localidad']);

        return view('mis-pedidos-detalle', ['pedido' => $pedido]);
    }

    public function cancelar(Pedido $pedido, PedidoService $pedidos)
    {
        Gate::authorize('cancelar', $pedido);

        try {
            $pedidos->cancelar($pedido);
        } catch (PedidoInvalidoException $e) {
            return back()->withErrors(['pedido' => $e->getMessage()]);
        }

        return back()->with('success', "El pedido #{$pedido->id} fue cancelado.");
    }
}