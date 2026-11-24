<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Términos y condiciones | AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/quienes-somos.css') }}" />
  </head>
  <body>
    @include('partials.header')

    <main>
      <section class="about-hero">
        <p class="kicker">CONDICIONES GENERALES DE USO</p>
        <h1>Términos y condiciones</h1>
        <p class="lead">Conocé las pautas y condiciones que rigen el uso del sitio web y las compras en AURA CLOTHES.</p>
      </section>

      <section class="section" style="max-width:800px;margin:0 auto 4rem auto;padding:0 1.5rem;">
        <article style="margin-bottom:2.5rem;">
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">1. Generalidades</h2>
          <p style="color:#444;line-height:1.6;">Al acceder y realizar pedidos a través de AURA CLOTHES, aceptás quedar vinculado por los presentes Términos y Condiciones. Todas las compras efectuadas quedan sujetas a la legislación vigente en la República Argentina.</p>
        </article>

        <article style="margin-bottom:2.5rem;">
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">2. Precios y disponibilidad</h2>
          <p style="color:#444;line-height:1.6;">Los precios expresados en el sitio están en pesos argentinos ($ ARS) e incluyen los impuestos correspondientes. El stock de cada producto está sujeto a disponibilidad al momento de confirmar el pedido.</p>
        </article>

        <article>
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">3. Propiedad intelectual</h2>
          <p style="color:#444;line-height:1.6;">Todos los contenidos, fotografías, diseños, logotipos y textos publicados en este sitio web son propiedad exclusiva de AURA CLOTHES y se encuentran protegidos por las leyes de propiedad intelectual.</p>
        </article>
      </section>
    </main>

    @include('partials.footer')
  </body>
</html>
