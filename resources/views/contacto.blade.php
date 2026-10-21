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
          <li><a class="mainnav__link" href="{{ route('productos') }}">Productos</a></li>
          <li><a class="mainnav__link is-active" href="{{ route('contacto') }}">Contacto</a></li>
          <li><a class="mainnav__link" href="{{ route('quienes-somos') }}">Quiénes somos</a></li>
        </ul>
      </nav>
    </header>

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
          <div id="contact-success" class="success-msg" hidden>
            <h2>¡Mensaje enviado!</h2>
            <p>Te respondemos en menos de 24 horas hábiles.</p>
            <button class="btn-primary success-msg__button" type="button" id="contact-reset">Enviar otro mensaje</button>
          </div>

          <form id="contact-form">
            <h2 id="form-title">Envianos un mensaje</h2>
            <div class="form-field">
              <label for="c-nombre">Nombre completo</label>
              <input type="text" id="c-nombre" name="nombre" placeholder="Ana García" autocomplete="name" required />
            </div>
            <div class="form-field">
              <label for="c-email">Correo electrónico</label>
              <input type="email" id="c-email" name="email" placeholder="ana@correo.com" autocomplete="email" required />
            </div>
            <div class="form-field">
              <label for="c-asunto">Asunto</label>
              <input type="text" id="c-asunto" name="asunto" placeholder="Consulta sobre mi pedido" required />
            </div>
            <div class="form-field">
              <label for="c-mensaje">Mensaje</label>
              <textarea id="c-mensaje" name="mensaje" rows="5" placeholder="Contanos en qué te podemos ayudar..." required></textarea>
            </div>
            <button class="btn-primary" type="submit">Enviar mensaje</button>
          </form>
        </section>
      </div>
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
            <li><a href="./" aria-current="page">Contacto</a></li>
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

    <script type="module" src="./contacto.js"></script>
    <!-- figma:body-end -->
  </body>
</html>