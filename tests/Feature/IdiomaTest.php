<?php

namespace Tests\Feature;

use Tests\TestCase;

class IdiomaTest extends TestCase
{
    public function test_la_aplicacion_esta_en_espanol(): void
    {
        $this->assertSame('es', app()->getLocale());
    }

    public function test_los_errores_de_validacion_salen_en_espanol(): void
    {
        // Enviar el login vacío: email y password son obligatorios
        $this->post(route('sesion.iniciar'), [])
            ->assertSessionHasErrors(['email', 'password']);

        $mensaje = session('errors')->first('email');

        $this->assertStringContainsString('obligatorio', $mensaje);
    }
}