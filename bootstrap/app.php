<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'nivel' => \App\Http\Middleware\NivelPermiso::class,
        ]);

        //Sin sesion iniciada -> al formulario de login
        $middleware->redirectGuestsTo(fn () => route('cuenta'));

        //Con sesion iniciada, si entra a /cuenta -> al inicio
        $middleware->redirectUsersTo(fn () => route('inicio'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
