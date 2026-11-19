<!doctype html>
<html lang="es">
  <head>
    <!-- figma:head-start -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Quiénes somos | AURA CLOTHES</title>
    <!-- figma:head-end -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/quienes-somos.css') }}" />
  </head>
  <body>
    
    @include('partials.header')
    
    <main>
      <section class="about-hero">
        <p class="kicker">POSADAS, MISIONES — DESDE 2019</p>
        <h1>Ropa hecha para durar más que una temporada</h1>
        <p class="lead">AURA CLOTHES nació de la necesidad de tener prendas que no se deshilachen al tercer lavado. Empezamos con cinco remeras en un taller de Posadas y seguimos ahí, con más modelos pero con la misma lógica.</p>
      </section>

      <section class="section" aria-labelledby="values-title">
        <h2 class="section__title" id="values-title">Cómo trabajamos</h2>
        <div class="values-grid">
          <article>
            <p class="value-num">01</p>
            <h3 class="value-title">Sin fibras de más</h3>
            <p class="value-body">Trabajamos exclusivamente con lana, algodón y lino. Sin mezclas sintéticas, sin atajos.</p>
          </article>
          <article>
            <p class="value-num">02</p>
            <h3 class="value-title">Talleres pequeños</h3>
            <p class="value-body">Toda la producción pasa por talleres locales en Posadas y Corrientes. Conocemos a cada persona que cose.</p>
          </article>
          <article>
            <p class="value-num">03</p>
            <h3 class="value-title">Volúmenes controlados</h3>
            <p class="value-body">No fabricamos de más. Cuando se acaba, se acaba. Eso mantiene la calidad y evita el desperdicio.</p>
          </article>
          <article>
            <p class="value-num">04</p>
            <h3 class="value-title">Sin apuro</h3>
            <p class="value-body">Las colecciones salen cuando están listas. Una vez al año, dos si el año fue bueno.</p>
          </article>
        </div>
      </section>

      <section class="stats-band" aria-label="AURA CLOTHES en números">
        <div class="stats-inner">
          <div><p class="stat-num">7</p><p class="stat-label">años en el mercado</p></div>
          <div><p class="stat-num">4</p><p class="stat-label">talleres asociados</p></div>
          <div><p class="stat-num">+12.000</p><p class="stat-label">prendas entregadas</p></div>
        </div>
      </section>

      <section class="section" aria-labelledby="team-title">
        <h2 class="section__title" id="team-title">El equipo</h2>
        <ul class="team-grid">
          <li>
            <div class="team-card__media team-card__media--one" role="img" aria-label="Retrato de Valentina Ruiz"></div>
            <p class="team-card__name">Valentina Ruiz</p>
            <p class="team-card__role">Fundadora &amp; Dirección creativa</p>
          </li>
          <li>
            <div class="team-card__media team-card__media--two" role="img" aria-label="Retrato de Martín Ojeda"></div>
            <p class="team-card__name">Martín Ojeda</p>
            <p class="team-card__role">Diseño de producto</p>
          </li>
          <li>
            <div class="team-card__media team-card__media--three" role="img" aria-label="Retrato de Camila Torres"></div>
            <p class="team-card__name">Camila Torres</p>
            <p class="team-card__role">Producción &amp; talleres</p>
          </li>
          <li>
            <div class="team-card__media team-card__media--four" role="img" aria-label="Retrato de Lucas Ferreyra"></div>
            <p class="team-card__name">Lucas Ferreyra</p>
            <p class="team-card__role">Logística &amp; e-commerce</p>
          </li>
        </ul>
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
            <li><a href="./index.html" aria-current="page">Quiénes somos</a></li>
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
