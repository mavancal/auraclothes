<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PaginasTest extends TestCase
{
    use RefreshDatabase;

    public function test_inicio_muestra_productos_reales_con_imagen(): void
    {
        $this->seed();

        $this->get(route('inicio'))
            ->assertOk()
            ->assertSee('img/productos/', false)
            ->assertSee('img/productos/rem-002.jpg', false);
    }

    public function test_nuevo_muestra_los_productos_activos(): void
    {
        $this->seed();

        $this->get(route('nuevo'))
            ->assertOk()
            ->assertSee('img/productos/rem-001.jpg', false)
            ->assertSee('img/productos/hw-001.jpg', false);
    }

    public function test_paginas_cargan_sin_productos(): void
    {
        $this->get(route('inicio'))->assertOk();
        $this->get(route('nuevo'))->assertOk()->assertSee('Todavía no hay productos nuevos');
    }
}