<?php

namespace App\Http\Controllers;

use App\Exceptions\RegistroInvalidoException;
use App\Http\Requests\RegistroRequest;
use App\Models\Localidad;
use App\Models\Provincia;
use App\Models\TipoDocumento;
use App\Models\TipoPersona;
use App\Services\RegistroService;

class RegistroController extends Controller
{
    public function create()
    {
        return view('registro', [
            'provincias' => Provincia::orderBy('descripcion')->get(),
            'localidades' => Localidad::orderBy('descripcion')->get(),
            'tiposPersona' => TipoPersona::orderBy('descripcion')->get(),
            'tiposDocumento' => TipoDocumento::orderBy('descripcion')->get(),
        ]);
    }

    public function store(RegistroRequest $request, RegistroService $registro)
    {
        // Si llegamos acá, los datos ya pasaron todas las reglas de RegistroRequest
        try {
            $registro->registrar($request->validated());
        } catch (RegistroInvalidoException $e) {
            return back()->withErrors(['registro' => $e->getMessage()])->withInput();
        }

        return redirect()->route('registro')->with('success', 'Cuenta creada correctamente.');
    }
}