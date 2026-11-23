<?php

namespace App\Http\Controllers;

use App\Models\SuscriptorNewsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        // Volvemos a la sección del newsletter (está al final del inicio), no al principio de la página
        $volver = redirect()->to(route('inicio') . '#newsletter');

        $validator = Validator::make(
            $request->only('email'),
            ['email' => ['required', 'email', 'max:120']],
            [],
            ['email' => 'correo electrónico'],
        );

        if ($validator->fails()) {
            // Bolsa de errores propia ("newsletter") para no mezclarla con otros formularios
            return $volver->withErrors($validator, 'newsletter')->withInput();
        }

        // firstOrCreate: si ya estaba suscripto no lo duplica (y no da error)
        SuscriptorNewsletter::firstOrCreate([
            'email' => Str::lower($validator->validated()['email']),
        ]);

        return $volver->with('newsletter', '¡Gracias! Te vamos a escribir con las novedades.');
    }
}