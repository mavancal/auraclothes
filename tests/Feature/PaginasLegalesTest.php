<?php

namespace Tests\Feature;

use Database\Seeders\CatalogosSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginasLegalesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CatalogosSeeder::class);
    }

    public function test_paginas_legales_y_de_ayuda_cargan_correctamente(): void
    {
        $this->get(route('paginas.envios'))
            ->assertOk()
            ->assertSee('Envíos y entregas');

        $this->get(route('paginas.cambios'))
            ->assertOk()
            ->assertSee('Cambios y devoluciones');

        $this->get(route('paginas.terminos'))
            ->assertOk()
            ->assertSee('Términos y condiciones');

        $this->get(route('paginas.privacidad'))
            ->assertOk()
            ->assertSee('Políticas de privacidad');
    }
}
