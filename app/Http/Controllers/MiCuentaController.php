<?php

namespace App\Http\Controllers;

use App\Http\Requests\CambiarPasswordRequest;
use App\Http\Requests\DatosPersonalesRequest;
use Illuminate\Http\Request;

class MiCuentaController extends Controller
{
    /**
     * Datos del usuario (la vista "mi-cuenta" la arma el frontend).
     */
    public function show(Request $request)
    {
        return view('mi-cuenta', [
            'user'     => $request->user(),
            'contacto' => $request->user()->contacto->load(['tipoDocumento', 'tipoPersona']),
        ]);
    }

    public function actualizarDatos(DatosPersonalesRequest $request)
    {
        $request->user()->contacto->update($request->validated());

        return back()->with('success', 'Tus datos se actualizaron.');
    }

    public function cambiarPassword(CambiarPasswordRequest $request)
    {
        // Se guarda en texto plano: el cast 'hashed' del modelo User la hashea
        $request->user()->update(['password' => $request->validated('password')]);

        return back()->with('success', 'Tu contraseña se cambió.');
    }
}