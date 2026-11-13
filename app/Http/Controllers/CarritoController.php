<?php

namespace App\Http\Controllers;

use App\Exceptions\CarritoInvalidoException;
use App\Services\CarritoService;
use Illuminate\Http\Request;

class CarritoController extends Controller
{
    public function __construct(private CarritoService $carrito)
    {
    }

    /**
     * Página del carrito (la vista "carrito" la arma el frontend).
     */
    public function index()
    {
        return view('carrito', [
            'items'    => $this->carrito->items(),
            'subtotal' => $this->carrito->subtotal(),
        ]);
    }

    public function agregar(Request $request)
    {
        $datos = $request->validate([
            'producto_id' => ['required', 'integer'],
            'cantidad'    => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        try {
            $this->carrito->agregar($datos['producto_id'], $datos['cantidad'] ?? 1);
        } catch (CarritoInvalidoException $e) {
            return back()->withErrors(['carrito' => $e->getMessage()]);
        }

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function actualizar(Request $request, int $productoId)
    {
        $datos = $request->validate([
            'cantidad' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        try {
            $this->carrito->actualizar($productoId, $datos['cantidad']);
        } catch (CarritoInvalidoException $e) {
            return back()->withErrors(['carrito' => $e->getMessage()]);
        }

        return back()->with('success', 'Carrito actualizado.');
    }

    public function quitar(int $productoId)
    {
        $this->carrito->quitar($productoId);

        return back()->with('success', 'Producto quitado del carrito.');
    }

    public function vaciar()
    {
        $this->carrito->vaciar();

        return back()->with('success', 'Carrito vaciado.');
    }
}