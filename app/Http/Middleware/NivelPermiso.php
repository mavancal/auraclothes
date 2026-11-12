<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NivelPermiso
{
    /**
     * Deja pasar solo a usuarios con un rol de nivel igual o mayor al pedido.
     * Uso en rutas: ->middleware('nivel:50')
     */
    public function handle(Request $request, Closure $next, string $minimo): Response
    {
        $user = $request->user();

        if (! $user || ! $user->tieneNivel((int) $minimo)) {
            abort(403, 'No tenés permiso para entrar a esta sección.');
        }

        return $next($request);
    }
}