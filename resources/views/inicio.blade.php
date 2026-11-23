<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>AURA CLOTHES</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
</head>
<body>

    @include('partials.header')
    @if (session('success'))
    <div style="max-width:1200px;margin:1rem auto;padding:1rem;background:#e6f4ea;color:#1e4620;border-radius:4px;">
      {{ session('success') }}
    </div>
    @endif

<main id="contenido">

  <!-- ===== PRESENTACIÓN DE COLECCIÓN ===== -->
  <section class="feature">
    <div class="feature__media" role="img" aria-label="Sala de estar con muebles y objetos AURA CLOTHES">
      <span class="placeholder-tag">Colección Otoño</span>
    </div>
    <div class="feature__text">
      <p class="feature__kicker">Nueva colección</p>
      <h1 class="feature__title">Prendas con textura, hechas para durar</h1>
      <p class="feature__body">Prendas de lana, algodón y pana, pensadas para días que empiezan fríos y terminan templados. Confección en talleres pequeños, sin apuro y sin fibras de más.</p>
      <a class="link-arrow" href="{{ route('productos') }}">Ver la colección completa</a>
    </div>
  </section>

  <!-- ===== OFERTAS ===== -->
  <section class="section" aria-labelledby="tit-ofertas">
    <div class="section__head">
      <h2 class="section__title" id="tit-ofertas">Ofertas de la semana</h2>
      <a class="section__link" href="{{ route('productos', ['en_oferta' => 1]) }}">Ver todas las ofertas</a>
    </div>

    @if ($productos->isEmpty())
      <p>Pronto vas a ver nuestros productos acá.</p>
    @else
      <ul class="product-grid">
        @foreach ($productos as $producto)
          @php
            $mediaClasses = ['product-card__media--sand','product-card__media--brand','product-card__media--ink','product-card__media--accent'];
          @endphp
          <li class="product-card">
            <a href="{{ route('productos') }}" style="color:inherit;text-decoration:none">
              <div class="product-card__media {{ $mediaClasses[$loop->index % 4] }}">
                @if ($producto->imagen_url)
                  <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}" style="width:100%;height:100%;object-fit:cover;display:block;" />
                @elseif ($producto->coleccion)
                  <span class="placeholder-tag">{{ $producto->coleccion->nombre_coleccion }}</span>
                @endif
                @if ($producto->porcentaje_descuento)
                  <span class="tag-discount">-{{ $producto->porcentaje_descuento }}%</span>
                @endif
              </div>
              <p class="product-card__name">{{ $producto->nombre }}</p>
              <p class="product-card__price">
                @if ($producto->precio_oferta)
                  <span class="price-old">${{ number_format($producto->precio, 0, ',', '.') }}</span>
                @endif
                ${{ number_format($producto->precio_final, 0, ',', '.') }}
              </p>
            </a>
          </li>
        @endforeach
      </ul>
    @endif
  </section>

  <!-- ===== CATEGORÍAS PRINCIPALES ===== -->
  <section class="section section--alt" aria-labelledby="tit-categorias">
    <div class="section__head">
      <h2 class="section__title" id="tit-categorias">Categorías principales</h2>
    </div>

    <ul class="category-grid">
      <li class="category-card">
        <div class="category-card__media category-card__media--1"><span class="placeholder-tag">Remeras</span></div>
        <p class="category-card__name">Remeras</p>
      </li>
      <li class="category-card">
        <div class="category-card__media category-card__media--2"><span class="placeholder-tag">Pantalones</span></div>
        <p class="category-card__name">Pantalones</p>
      </li>
      <li class="category-card">
        <div class="category-card__media category-card__media--3"><span class="placeholder-tag">HeadWear</span></div>
        <p class="category-card__name">HeadWear</p>
      </li>
      <li class="category-card">
        <div class="category-card__media category-card__media--4"><span class="placeholder-tag">Accesorios</span></div>
        <p class="category-card__name">Accesorios</p>
      </li>
      <li class="category-card">
        <div class="category-card__media category-card__media--5"><span class="placeholder-tag">Buzos</span></div>
        <p class="category-card__name">Buzos</p>
      </li>
      <li class="category-card">
        <div class="category-card__media category-card__media--6"><span class="placeholder-tag">Mochilas</span></div>
        <p class="category-card__name">Mochilas</p>
      </li>
    </ul>
  </section>

  <!-- ===== ENVÍOS / REDES / HORARIO ===== -->
  <section class="info-band">
    <div class="info-band__col">
      <h2 class="info-band__title">Envíos</h2>
      <p class="info-band__body">Entregamos en todo el país en 3 a 7 días hábiles.
      Envío gratis en compras superiores a $50.000. Retiro sin cargo en
      nuestro local de Posadas.</p>
    </div>

    <div class="info-band__col">
      <h2 class="info-band__title">Seguinos</h2>
      <ul class="social-list">
        <li><a href="#">Instagram</a></li>
        <li><a href="#">Facebook</a></li>
        <li><a href="#">Pinterest</a></li>
        <li><a href="#">TikTok</a></li>
      </ul>
    </div>

    <div class="info-band__col">
      <h2 class="info-band__title">Horario de atención</h2>
      <p class="info-band__body">Lunes a viernes, de 9 a 18 hs.<br>
      Sábados, de 9 a 13 hs.<br>
      Domingos y feriados, cerrado.</p>
    </div>
  </section>

  <!-- ===== NEWSLETTER ===== -->
    <section class="newsletter" id="newsletter">
    <div class="newsletter__inner">
      <h2 class="newsletter__title">Novedades una vez al mes, nada más</h2>
      <p class="newsletter__body">Nuevos productos, reposiciones y descuentos
      exclusivos para quienes se suscriben.</p>

      @if (session('newsletter'))
        <p style="color:#1e4620;background:#e6f4ea;padding:.5rem 1rem;border-radius:4px;margin-bottom:1rem;">{{ session('newsletter') }}</p>
      @endif

      <form class="newsletter__form" method="POST" action="{{ route('newsletter.suscribir') }}">
        @csrf
        <label class="visually-hidden" for="newsletter-email">Correo electrónico</label>
        <input class="newsletter__input" type="email" id="newsletter-email" name="email" value="{{ old('email') }}" placeholder="tu@correo.com" required>
        <button class="newsletter__button" type="submit">Suscribirme</button>
      </form>
      @error('email', 'newsletter')
        <p style="color:#b00020;margin-top:.5rem;">{{ $message }}</p>
      @enderror
    </div>
  </section>

</main>

<!-- ===== FOOTER ===== -->
<footer class="footer">
  <div class="footer__grid">

    <div class="footer__col">
      <p class="footer__brand">AURA CLOTHES</p>
      <p class="footer__body">Prendas de lana, algodón y lino de uso diario, hechas en talleres pequeños.</p>
    </div>

    <div class="footer__col">
      <h3 class="footer__heading">Navegación</h3>
      <ul class="footer__list">
        <li><a href="#">Inicio</a></li>
        <li><a href="#">Nuevo</a></li>
        <li><a href="#">Productos</a></li>
        <li><a href="#">Ofertas</a></li>
        <li><a href="#">Blog</a></li>
      </ul>
    </div>

    <div class="footer__col">
      <h3 class="footer__heading">Ayuda</h3>
      <ul class="footer__list">
        <li><a href="#">Envíos y entregas</a></li>
        <li><a href="#">Cambios y devoluciones</a></li>
        <li><a href="#">Contacto</a></li>
        <li><a href="#">Quiénes somos</a></li>
      </ul>
    </div>

    <div class="footer__col">
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

</body>
</html>