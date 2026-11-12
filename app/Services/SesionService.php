<?php

namespace App\Services;

use App\Exceptions\SesionInvalidaException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SesionService
{
    /**
     * Inicia la sesión con correo y contraseña.
     *
     * @throws SesionInvalidaException
     */
    public function iniciar(string $email, string $password, bool $recordar = false): User
    {
        $user = User::where('email', $email)->first();

        // Mismo mensaje si el correo no existe o si la contraseña está mal:
        // así nadie puede averiguar qué correos están registrados.
        if (! $user || ! Hash::check($password, $user->password)) {
            throw new SesionInvalidaException('Correo o contraseña incorrectos.');
        }

        if (! $user->activo) {
            throw new SesionInvalidaException('Tu cuenta está desactivada. Comunicate con la tienda.');
        }

        Auth::login($user, $recordar);

        $user->update(['ultimo_acceso' => now()]);

        return $user;
    }

    /**
     * Cierra la sesión del usuario actual.
     */
    public function cerrar(): void
    {
        Auth::logout();
    }
}