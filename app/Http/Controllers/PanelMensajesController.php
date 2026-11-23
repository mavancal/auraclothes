<?php

namespace App\Http\Controllers;

use App\Models\MensajeContacto;

class PanelMensajesController extends Controller
{
    public function index()
    {
        return view('vistas_admin.panel_mensajes_admin', [
            // Primero los no leídos, y dentro de cada grupo los más nuevos
            'mensajes'  => MensajeContacto::orderBy('leido')->latest()->paginate(20),
            'noLeidos'  => MensajeContacto::where('leido', false)->count(),
        ]);
    }

    public function marcarLeido(MensajeContacto $mensaje)
    {
        $mensaje->update(['leido' => ! $mensaje->leido]);

        return back();
    }
}