<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cambios y devoluciones | AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/quienes-somos.css') }}" />
  </head>
  <body>
    @include('partials.header')

    <main>
      <section class="about-hero">
        <p class="kicker">POLÍTICA DE GARANTÍA Y SATISFACCIÓN</p>
        <h1>Cambios y devoluciones</h1>
        <p class="lead">Queremos que estés plenamente conforme con tu prenda. Si necesitás cambiarla o devolverla, te acompañamos en todo el proceso.</p>
      </section>

      <section class="section" style="max-width:800px;margin:0 auto 4rem auto;padding:0 1.5rem;">
        <article style="margin-bottom:2.5rem;">
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">Plazo para cambios</h2>
          <p style="color:#444;line-height:1.6;">Disponés de <strong>30 días corridos</strong> desde la recepción del pedido para solicitar un cambio por talle, modelo o falla de fabricación.</p>
        </article>

        <article style="margin-bottom:2.5rem;">
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">Condiciones de la prenda</h2>
          <p style="color:#444;line-height:1.6;">Las prendas deben estar en su estado original, sin uso, sin lavar, con sus etiquetas colocadas y en su empaque original.</p>
        </article>

        <article>
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">¿Cómo iniciar la gestión?</h2>
          <p style="color:#444;line-height:1.6;">Podés contactarte directamente mediante nuestro <a href="{{ route('contacto') }}" style="text-decoration:underline;">formulario de contacto</a> indicando tu número de pedido y el motivo del cambio o devolución. Nuestro equipo te responderá a la brevedad con las instrucciones de despacho.</p>
        </article>
      </section>
    </main>

    @include('partials.footer')
  </body>
</html>
