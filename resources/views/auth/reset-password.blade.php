<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Restablecer contraseña | AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/cuenta.css') }}" />
  </head>
  <body>
    @include('partials.header')

    <main class="account-main">
      <section class="login-panel" aria-labelledby="reset-title">
        <div class="login-panel__heading">
          <p class="login-panel__kicker">SEGURIDAD DE TU CUENTA</p>
          <h1 id="reset-title">Restablecer contraseña</h1>
          <p>Escribí tu nueva contraseña para volver a ingresar a AURA CLOTHES.</p>
        </div>

        <form class="login-form" action="{{ route('password.update') }}" method="POST">
          @csrf
          <input type="hidden" name="token" value="{{ $token }}">

          <div class="form-field">
            <label for="email">Correo electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email', $email) }}" required autocomplete="email" />
            @error('email')
              <span class="form-error" style="color:#b00020;font-size:0.85rem;margin-top:0.3rem;">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-field">
            <label for="password">Nueva contraseña</label>
            <input type="password" id="password" name="password" required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
            @error('password')
              <span class="form-error" style="color:#b00020;font-size:0.85rem;margin-top:0.3rem;">{{ $message }}</span>
            @enderror
          </div>

          <div class="form-field">
            <label for="password_confirmation">Confirmar nueva contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password" placeholder="Repetí la contraseña" />
          </div>

          <div class="login-actions" style="margin-top:1.5rem;">
            <button class="btn btn--primary" type="submit">Actualizar contraseña</button>
            <a class="btn btn--secondary" href="{{ route('cuenta') }}">Cancelar</a>
          </div>
        </form>
      </section>
    </main>

    @include('partials.footer')
  </body>
</html>
