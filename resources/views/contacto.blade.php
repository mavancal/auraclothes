<!doctype html>
<html lang="es">
  <head>
    <!-- figma:head-start -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contacto | AURA CLOTHES</title>
    <!-- figma:head-end -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/contacto.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main>
      <div class="contact-layout">
        <section class="contact-intro" aria-labelledby="contact-title">
          <p class="contact-kicker">Estamos para ayudarte</p>
          <h1 id="contact-title">Contacto</h1>
          <p class="contact-lead">Si tenés dudas sobre un pedido, cambios, devoluciones o simplemente querés saber más de alguna prenda, escribinos.</p>

          <div class="contact-details">
            <div class="contact-info-item">
              <h2>Local</h2>
              <p>San Martín 1420, Posadas, Misiones.<br />Retiro gratuito de lunes a sábado.</p>
            </div>
            <div class="contact-info-item">
              <h2>Horario de atención</h2>
              <p>Lun a vie: 9 a 18 hs<br />Sáb: 9 a 13 hs<br />Dom y feriados: cerrado</p>
            </div>
            <div class="contact-info-item">
              <h2>Redes sociales</h2>
              <p>Instagram · Facebook · Pinterest · TikTok</p>
            </div>
          </div>
        </section>

        <section class="contact-form-box" aria-labelledby="form-title">
          @if (session('contacto_enviado'))
            <div id="contact-success" class="success-msg">
              <h2>¡Mensaje enviado!</h2>
              <p>Te respondemos en menos de 24 horas hábiles.</p>
              <a class="btn-primary success-msg__button" href="{{ route('contacto') }}">Enviar otro mensaje</a>
            </div>
          @else
            <form id="contact-form" method="POST" action="{{ route('contacto.enviar') }}">
              @csrf
              <h2 id="form-title">Envianos un mensaje</h2>
              <div class="form-field">
                <label for="c-nombre">Nombre completo</label>
                <input type="text" id="c-nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Ana García" autocomplete="name" required />
                @error('nombre') <span style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="c-email">Correo electrónico</label>
                <input type="email" id="c-email" name="email" value="{{ old('email') }}" placeholder="ana@correo.com" autocomplete="email" required />
                @error('email') <span style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="c-asunto">Asunto</label>
                <input type="text" id="c-asunto" name="asunto" value="{{ old('asunto') }}" placeholder="Consulta sobre mi pedido" required />
                @error('asunto') <span style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="c-mensaje">Mensaje</label>
                <textarea id="c-mensaje" name="mensaje" rows="5" placeholder="Contanos en qué te podemos ayudar..." required>{{ old('mensaje') }}</textarea>
                @error('mensaje') <span style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <button class="btn-primary" type="submit">Enviar mensaje</button>
            </form>
          @endif
        </section>
      </div>
    </main>

    @include('partials.footer')

    <!-- figma:body-end -->
  </body>
</html>