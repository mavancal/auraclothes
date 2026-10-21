<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Productos — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
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

    <!-- ===== CONTENIDO: VISTA PRODUCTOS ===== -->
    <main id="contenido">
      <div id="page-productos" class="page is-active">
        <div class="section">
          <h1 style="font-size:2.2rem;margin:0 0 2rem">Todos los productos</h1>
          <div class="toolbar">
            <div class="filter-group" id="productos-filters">
              <button class="filter-btn is-active" data-filter="Todo">Todo</button>
              <button class="filter-btn" data-filter="Remeras">Remeras</button>
              <button class="filter-btn" data-filter="Pantalones">Pantalones</button>
              <button class="filter-btn" data-filter="Buzos">Buzos</button>
              <button class="filter-btn" data-filter="HeadWear">HeadWear</button>
              <button class="filter-btn" data-filter="Accesorios">Accesorios</button>
              <button class="filter-btn" data-filter="Mochilas">Mochilas</button>
            </div>
            <div style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap">
              <select class="sort-select" id="productos-coleccion" aria-label="Filtrar por colección">
                <option value="Todas">Todas las colecciones</option>
                <option value="Otoño 2026">Otoño 2026</option>
                <option value="Invierno 2025">Invierno 2025</option>
                <option value="Verano 2025">Verano 2025</option>
                <option value="Básicos">Básicos</option>
              </select>
              <select class="sort-select" id="productos-sort" aria-label="Ordenar productos">
                <option value="default">Destacados</option>
                <option value="price-asc">Precio: menor a mayor</option>
                <option value="price-desc">Precio: mayor a menor</option>
                <option value="name">Nombre A–Z</option>
              </select>
            </div>
          </div>
          <p class="count-label" id="productos-count"></p>
          <ul class="product-grid" id="productos-grid"></ul>
        </div>
      </div>
    </main>

    <!-- ===== FOOTER ===== -->
    <footer class="footer">
      <div class="footer__grid">
        <div>
          <p class="footer__brand">AURA CLOTHES</p>
          <p class="footer__body">Prendas de lana, algodón y lino de uso diario, hechas en talleres pequeños.</p>
        </div>
        <div>
          <h3 class="footer__heading">Navegación</h3>
          <ul class="footer__list">
            <li><a href="index.html">Inicio</a></li>
            <li><a href="nuevo.html">Nuevo</a></li>
            <li><a href="productos.html">Productos</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer__heading">Ayuda</h3>
          <ul class="footer__list">
            <li><a href="#">Envíos y entregas</a></li>
            <li><a href="#">Cambios y devoluciones</a></li>
            <li><a href="contacto.html">Contacto</a></li>
            <li><a href="quienes-somos.html">Quiénes somos</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer__heading">Contacto</h3>
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

    <script src="/js/productos.js"></script>
  </body>
</html>