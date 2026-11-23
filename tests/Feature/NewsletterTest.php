<?php

namespace Tests\Feature;

use App\Models\SuscriptorNewsletter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsletterTest extends TestCase
{
    use RefreshDatabase;

    public function test_suscribe_un_correo(): void
    {
        $this->post(route('newsletter.suscribir'), ['email' => 'Ana@Mail.com'])
            ->assertRedirect(route('inicio') . '#newsletter')
            ->assertSessionHas('newsletter');

        $this->assertDatabaseHas('suscriptores_newsletter', ['email' => 'ana@mail.com']);
    }

    public function test_suscribirse_dos_veces_no_duplica(): void
    {
        $this->post(route('newsletter.suscribir'), ['email' => 'ana@mail.com']);
        $this->post(route('newsletter.suscribir'), ['email' => 'ANA@mail.com'])
            ->assertSessionHas('newsletter');

        $this->assertSame(1, SuscriptorNewsletter::count());
    }

    public function test_un_correo_invalido_da_error(): void
    {
        $this->post(route('newsletter.suscribir'), ['email' => 'esto-no-es-un-correo'])
            ->assertSessionHasErrorsIn('newsletter', 'email');

        $this->assertSame(0, SuscriptorNewsletter::count());
    }

    public function test_el_inicio_muestra_el_formulario_conectado(): void
    {
        $this->get(route('inicio'))
            ->assertOk()
            ->assertSee('action="' . route('newsletter.suscribir') . '"', false);
    }
}