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

    <header class="topbar">
      <div class="topbar__inner">
        <button class="icon-btn icon-btn--search" type="button" aria-label="Buscar productos">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
          <span class="icon-btn__label">Buscar</span>
        </button>


        <a class="logo" href="index.html" aria-label="AURA CLOTHES, ir al inicio">
          <span class="logo__mark">AC</span>
          <span class="logo__word">AURA CLOTHES</span>
        </a>

        <div class="topbar__actions">


          <button class="icon-btn" type="button" aria-label="Mi cuenta">
            <a href="{{ route('cuenta') }}">
                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"></path></svg>
                <span class="icon-btn__label">Cuenta</span>
            </a>
          </button>


          <button class="icon-btn" type="button" aria-label="Ver carrito, 3 productos">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16l-1.5 10.5a2 2 0 0 1-2 1.5H7.5a2 2 0 0 1-2-1.5L4 6z"></path><path d="M8 6V5a4 4 0 0 1 8 0v1"></path></svg>
            <span class="icon-btn__label">Carrito</span>
            <span class="icon-btn__badge">3</span>
          </button>
        </div>
      </div>
    

      <!-- ===== NAVBAR ===== -->
      <nav class="mainnav" aria-label="Navegación principal">
        <ul class="mainnav__list">
          <li><a class="mainnav__link" href="{{ route('inicio') }}">Inicio</a></li>
          <li><a class="mainnav__link" href="{{ route('nuevo') }}">Nuevo</a></li>
          <li><a class="mainnav__link is-active" href="{{ route('productos') }}">Productos</a></li>
          <li><a class="mainnav__link" href="{{ route('contacto') }}">Contacto</a></li>
          <li><a class="mainnav__link" href="{{ route('quienes-somos') }}">Quiénes somos</a></li>
        </ul>
      </nav>
    </header>

    <main class="account-main">
      <section class="login-panel" aria-labelledby="login-title">
        <div class="login-panel__heading">
          <p class="login-panel__kicker">TU ESPACIO AURA</p>
          <h1 id="login-title">Iniciar sesión</h1>
          <p>Ingresá a tu cuenta para consultar tus pedidos y guardar tus prendas favoritas.</p>
        </div>

        <form class="login-form" action="#" method="post">
          <div class="form-field">
            <label for="login-email">Correo electrónico</label>
            <input type="email" id="login-email" name="email" placeholder="tu@correo.com" autocomplete="email" required />
          </div>

          <div class="form-field">
            <label for="login-password">Contraseña</label>
            <input type="password" id="login-password" name="password" placeholder="Ingresá tu contraseña" autocomplete="current-password" required />
          </div>

          <a class="forgot-password" href="#">¿Olvidaste tu contraseña?</a>

          <div class="login-actions">
            <button class="btn btn--primary" type="submit">Iniciar sesión</button>
            <button class="btn btn--secondary" type="button">Registrarse</button>
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