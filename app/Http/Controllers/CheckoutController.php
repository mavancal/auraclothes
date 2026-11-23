<?php

namespace App\Http\Controllers;

use App\Exceptions\PedidoInvalidoException;
use App\Models\MetodoPago;
use App\Services\CarritoService;
use App\Services\PedidoService;
use Illuminate\Http\Request;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    public function __construct(private CarritoService $carrito)
    {
    }

    /**
     * Pantalla para confirmar la compra (la vista "checkout" la arma el frontend).
     */
    public function create(Request $request)
    {
        if ($this->carrito->cantidadTotal() === 0) {
            return redirect()->route('carrito')->withErrors(['carrito' => 'Tu carrito está vacío.']);
        }

        return view('checkout', [
            'items'       => $this->carrito->items(),
            'subtotal'    => $this->carrito->subtotal(),
            'costoEnvio'  => $this->carrito->costoEnvio(),
            'total'       => $this->carrito->total(),
            'envioGratisDesde' => config('tienda.envio.gratis_desde'),
            'direcciones' => $request->user()->contacto->direcciones()->orderByDesc('es_principal')->get(),
            'metodosPago' => MetodoPago::orderBy('metodo')->get(),
        ]);
    }

    /**
     * Confirma la compra: convierte el carrito en un pedido.
     */
    public function store(CheckoutRequest $request, PedidoService $pedidos)
    {
        $datos = $request->validated();

        try {
            $pedido = $pedidos->crear(
                $request->user(),
                $this->carrito->paraPedido(),
                $datos['direccion_id'],
                $datos['metodo_pago_id'],
                costoEnvio: $this->carrito->costoEnvio(),
            );
        } catch (PedidoInvalidoException $e) {
            return back()->withErrors(['checkout' => $e->getMessage()])->withInput();
        }

        // Solo si el pedido se creó bien
        $this->carrito->vaciar();

        return redirect()->route('inicio')
            ->with('success', "¡Gracias por tu compra! Tu pedido #{$pedido->id} quedó registrado.");
    }
}