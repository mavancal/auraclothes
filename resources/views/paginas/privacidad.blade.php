<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Políticas de privacidad | AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/quienes-somos.css') }}" />
  </head>
  <body>
    @include('partials.header')

    <main>
      <section class="about-hero">
        <p class="kicker">PROTECCIÓN DE DATOS PERSONALES</p>
        <h1>Políticas de privacidad</h1>
        <p class="lead">Nos comprometemos a resguardar la confidencialidad de tu información personal y financiera.</p>
      </section>

      <section class="section" style="max-width:800px;margin:0 auto 4rem auto;padding:0 1.5rem;">
        <article style="margin-bottom:2.5rem;">
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">1. Información recopilada</h2>
          <p style="color:#444;line-height:1.6;">Recopilamos únicamente los datos necesarios para procesar tus pedidos, despachar los envíos y mantenerte informado sobre el estado de tu cuenta (nombre, correo electrónico, documento, teléfono y dirección de entrega).</p>
        </article>

        <article style="margin-bottom:2.5rem;">
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">2. Seguridad y confidencialidad</h2>
          <p style="color:#444;line-height:1.6;">Tus datos nunca son compartidos, vendidos ni cedidos a terceros con fines publicitarios ajenos a AURA CLOTHES. Las contraseñas se almacenan mediante encriptación segura y protegida.</p>
        </article>

        <article>
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">3. Derechos del titular</h2>
          <p style="color:#444;line-height:1.6;">Podés solicitar la actualización, rectificación o eliminación de tus datos en cualquier momento comunicándote con nosotros mediante la sección de <a href="{{ route('contacto') }}" style="text-decoration:underline;">contacto</a>.</p>
        </article>
      </section>
    </main>

    @include('partials.footer')
  </body>
</html>
