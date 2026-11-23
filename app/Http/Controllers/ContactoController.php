<?php

namespace App\Http\Controllers;

use App\Models\MensajeContacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function store(Request $request)
    {
        $datos = $request->validate(
            [
                'nombre'  => ['required', 'string', 'max:100'],
                'email'   => ['required', 'email', 'max:120'],
                'asunto'  => ['required', 'string', 'max:150'],
                'mensaje' => ['required', 'string', 'max:2000'],
            ],
            [],
            ['email' => 'correo electrónico'],
        );

        MensajeContacto::create($datos);

        return redirect()->route('contacto')->with('contacto_enviado', true);
    }
}