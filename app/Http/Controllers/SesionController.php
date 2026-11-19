<?php

namespace App\Http\Controllers;

use App\Exceptions\SesionInvalidaException;
use App\Services\SesionService;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class SesionController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión (vista "cuenta").
     */
    public function create()
    {
        return view('cuenta');
    }

    /**
     * Procesa el formulario de inicio de sesión.
     */
    public function store(LoginRequest $request, SesionService $sesion)
{
    $datos = $request->validated();

    try {
        $sesion->iniciar($datos['email'], $datos['password'], $request->boolean('recordar'));
    } catch (SesionInvalidaException $e) {
        return back()
            ->withErrors(['email' => $e->getMessage()])
            ->onlyInput('email');
    }

    $request->session()->regenerate();

    $user = auth()->user();
    if ($user && $user->tieneNivel(50)) {
        return redirect()->route('panel_productos_admin');
    }

    return redirect()->intended(route('inicio'));
}

    /**
     * Cierra la sesión.
     */
    public function destroy(Request $request, SesionService $sesion)
    {
        $sesion->cerrar();

        // Borra los datos de la sesión y genera un token CSRF nuevo
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio');
    }
}