<!doctype html>
<html lang="es">
  <head>
    <!-- figma:head-start -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mi cuenta | AURA CLOTHES</title>
    <!-- figma:head-end -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/cuenta.css') }}" />
  </head>
  <body>

    @include('partials.header')

    <main class="account-main">
      <section class="login-panel" aria-labelledby="login-title">
        <div class="login-panel__heading">
          <p class="login-panel__kicker">TU ESPACIO AURA</p>
          <h1 id="login-title">Iniciar sesión</h1>
          <p>Ingresá a tu cuenta para consultar tus pedidos y guardar tus prendas favoritas.</p>
        </div>

        <form class="login-form" action="{{ route('sesion.iniciar') }}" method="post">
          @csrf
          <div class="form-field">
            <label for="login-email">Correo electrónico</label>
            <input type="email" id="login-email" name="email" placeholder="tu@correo.com" autocomplete="email" value="{{ old('email') }}" required />
              @error('email')
              <span class="form-error">{{ $message }}</span>
              @enderror
          </div>

          <div class="form-field">
            <label>
              <input type="checkbox" name="recordar" value="1" {{ old('recordar') ? 'checked' : '' }} />
              Recordarme
            </label>
          </div>

          <div class="form-field">
            <label for="login-password">Contraseña</label>
            <input type="password" id="login-password" name="password" placeholder="Ingresá tu contraseña" autocomplete="current-password" required />
          </div>

          <a class="forgot-password" href="#">¿Olvidaste tu contraseña?</a>

          <div class="login-actions">
            <button class="btn btn--primary" type="submit">Iniciar sesión</button>
              <a class="btn btn--secondary" href="{{ route('registro') }}">Registrarse</a>
            
          </div>
        </form>
      </section>
    </main>

    <footer class="footer">
      <div class="footer__grid">
        <div>
          <p class="footer__brand">AURA CLOTHES</p>
          <p class="footer__body">Prendas de lana, algodón y lino de uso diario, hechas en talleres pequeños.</p>
        </div>
        <div>
          <h2 class="footer__heading">Navegación</h2>
          <ul class="footer__list">
            <li><a href="../../index.html#inicio">Inicio</a></li>
            <li><a href="../../index.html#nuevo">Nuevo</a></li>
            <li><a href="../../index.html#productos">Productos</a></li>
          </ul>
        </div>
        <div>
          <h2 class="footer__heading">Ayuda</h2>
          <ul class="footer__list">
            <li><a href="#">Envíos y entregas</a></li>
            <li><a href="#">Cambios y devoluciones</a></li>
            <li><a href="../contacto/index.html">Contacto</a></li>
            <li><a href="../../index.html#quienes-somos">Quiénes somos</a></li>
          </ul>
        </div>
        <div>
          <h2 class="footer__heading">Contacto</h2>
          <p class="footer__body">Lun a vie 9–18 hs · Sáb 9–13 hs</p>
          <ul class="footer__list footer__list--inline">
            <li><a href="#">Instagram</a></li>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Pinterest</a></li>
          </ul>
        </div>
      </div>
      <div class="footer__bottom">
        <p>© 2026 AURA CLOTHES. Todos los derechos reservados.</p>
        <ul class="footer__legal">
          <li><a href="#">Términos</a></li>
          <li><a href="#">Privacidad</a></li>
        </ul>
      </div>
    </footer>
    <!-- figma:body-end -->
  </body>
</html>