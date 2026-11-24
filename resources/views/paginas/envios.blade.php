<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Envíos y entregas | AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/quienes-somos.css') }}" />
  </head>
  <body>
    @include('partials.header')

    <main>
      <section class="about-hero">
        <p class="kicker">INFORMACIÓN DE LOGÍSTICA</p>
        <h1>Envíos y entregas</h1>
        <p class="lead">Despachamos nuestras prendas desde Posadas, Misiones hacia todo el territorio nacional con seguimiento en tiempo real.</p>
      </section>

      <section class="section" style="max-width:800px;margin:0 auto 4rem auto;padding:0 1.5rem;">
        <article style="margin-bottom:2.5rem;">
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">Costo de envío y bonificaciones</h2>
          <p style="color:#444;line-height:1.6;">El costo de envío estándar a cualquier punto del país es de <strong>${{ number_format(config('tienda.envio.costo', 5000), 0, ',', '.') }}</strong>. En compras iguales o superiores a <strong>${{ number_format(config('tienda.envio.gratis_desde', 50000), 0, ',', '.') }}</strong>, el envío es <strong>100% gratuito</strong>.</p>
        </article>

        <article style="margin-bottom:2.5rem;">
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">Tiempos de entrega estimados</h2>
          <ul style="color:#444;line-height:1.8;padding-left:1.5rem;">
            <li><strong>Posadas y Gran Posadas:</strong> 24 a 48 horas hábiles.</li>
            <li><strong>Provincia de Misiones y Corrientes:</strong> 2 a 3 días hábiles.</li>
            <li><strong>Resto del país:</strong> 3 a 6 días hábiles mediante correo nacional y empresas asociadas.</li>
          </ul>
        </article>

        <article>
          <h2 style="font-size:1.4rem;margin-bottom:0.8rem;">Seguimiento de tu pedido</h2>
          <p style="color:#444;line-height:1.6;">Apenas tu compra cambie de estado a "En preparación" y sea despachada, podrás consultar el avance desde la sección <a href="{{ route('mis-pedidos') }}" style="text-decoration:underline;">Mis Pedidos</a> de tu cuenta.</p>
        </article>
      </section>
    </main>

    @include('partials.footer')
  </body>
</html>
