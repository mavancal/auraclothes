<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperar contraseña | AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/cuenta.css') }}" />
  </head>
  <body>
    @include('partials.header')

    <main class="account-main">
      <section class="login-panel" aria-labelledby="recover-title">
        <div class="login-panel__heading">
          <p class="login-panel__kicker">RECUPERACIÓN DE CUENTA</p>
          <h1 id="recover-title">¿Olvidaste tu contraseña?</h1>
          <p>Ingresá tu correo electrónico y te enviaremos las instrucciones para restablecer tu contraseña.</p>
        </div>

        @if (session('status'))
          <div style="background:#e6f4ea;color:#1e4620;padding:1rem;border-radius:4px;margin-bottom:1.5rem;font-size:0.9rem;">
            {{ session('status') }}
          </div>
        @endif

        <form class="login-form" action="{{ route('password.email') }}" method="POST">
          @csrf
          <div class="form-field">
            <label for="recover-email">Correo electrónico</label>
            <input type="email" id="recover-email" name="email" placeholder="tu@correo.com" autocomplete="email" value="{{ old('email') }}" required />
            @error('email')
              <span class="form-error" style="color:#b00020;font-size:0.85rem;margin-top:0.3rem;">{{ $message }}</span>
            @enderror
          </div>

          <div class="login-actions" style="margin-top:1.5rem;">
            <button class="btn btn--primary" type="submit">Enviar enlace</button>
            <a class="btn btn--secondary" href="{{ route('cuenta') }}">Volver al login</a>
          </div>
        </form>
      </section>
    </main>

    @include('partials.footer')
  </body>
</html>
