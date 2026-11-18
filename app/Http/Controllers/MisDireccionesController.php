<?php

namespace App\Http\Controllers;

use App\Exceptions\DireccionInvalidaException;
use App\Http\Requests\DireccionRequest;
use App\Models\Localidad;
use App\Models\Provincia;
use App\Services\DireccionService;
use Illuminate\Http\Request;

class MisDireccionesController extends Controller
{
    public function __construct(private DireccionService $direcciones)
    {
    }

    /**
     * Las direcciones del usuario y el formulario para agregar una
     * (la vista "mis-direcciones" la arma el frontend).
     */
    public function index(Request $request)
    {
        return view('mis-direcciones', [
            'direcciones' => $request->user()->contacto->direcciones()
                ->with('localidad.provincia')
                ->orderByDesc('es_principal')
                ->orderBy('id')
                ->get(),
            'provincias'  => Provincia::orderBy('descripcion')->get(),
            'localidades' => Localidad::orderBy('descripcion')->get(),
        ]);
    }

    public function store(DireccionRequest $request)
    {
        try {
            $this->direcciones->agregar(
                $request->user(),
                $request->validated(),
                $request->boolean('es_principal'),
            );
        } catch (DireccionInvalidaException $e) {
            return back()->withErrors(['direccion' => $e->getMessage()])->withInput();
        }

        return back()->with('success', 'Dirección agregada.');
    }

    public function marcarPrincipal(Request $request, int $direccionId)
    {
        try {
            $this->direcciones->marcarComoPrincipal($request->user(), $direccionId);
        } catch (DireccionInvalidaException $e) {
            return back()->withErrors(['direccion' => $e->getMessage()]);
        }

        return back()->with('success', 'Dirección principal actualizada.');
    }
}