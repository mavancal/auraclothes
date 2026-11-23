<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title> Nuevo — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main id="contenido">
      <div class="section">
        <h1 style="font-size:2.2rem;margin:0 0 2rem">Lo nuevo</h1>

        <p style="margin:-1.2rem 0 2rem;color:#666">Las últimas prendas que llegaron a la tienda.</p>

        @if ($productos->isEmpty())
          <p class="empty-msg">Todavía no hay productos nuevos.</p>
        @else
          <ul class="product-grid">
            @foreach ($productos as $producto)
                @php
                    $mediaClasses = ['product-card__media--sand','product-card__media--brand','product-card__media--ink','product-card__media--accent'];
                    $mediaClass = $mediaClasses[$loop->index % 4];
                @endphp
                <li class="product-card">
                    <div class="product-card__media {{ $mediaClass }}">
                        @if ($producto->imagen_url)
                        <img src="{{asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}" style="width:100%;height:100%;object-fit:cover;display:block;" />
                        @else
                        @if ($producto->coleccion)
                            <span class="placeholder-tag">{{ $producto->coleccion->nombre_coleccion }}</span>
                        @endif
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
                    <form method="POST" action="{{ route('carrito.agregar') }}" style="margin-top:0.5rem;display:flex;gap:0.4rem;align-items:center">
                        @csrf
                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                        <input type="number" name="cantidad" value="1" min="1" max="{{ $producto->stock }}" style="width:3rem;padding:0.3rem" {{ $producto->stock < 1 ? 'disabled' : '' }}>
                        <button type="submit" class="filter-btn" {{ $producto->stock < 1 ? 'disabled' : '' }}>
                        {{ $producto->stock < 1 ? 'Sin stock' : 'Agregar al carrito' }}
                        </button>
                    </form>
                    </li>
            @endforeach
          </ul>
        @endif
      </div>
    </main>

    <footer class="footer">
      <div class="footer__grid">
        <div>
          <p class="footer__brand">AURA CLOTHES</p>
          <p class="footer__body">Prendas de lana, algodón y lino de uso diario, hechas en talleres pequeños.</p>
        </div>
        <div>
          <h3 class="footer__heading">Navegación</h3>
          <ul class="footer__list">
            <li><a href="{{ route('inicio') }}">Inicio</a></li>
            <li><a href="{{ route('productos') }}">Productos</a></li>
            <li><a href="{{ route('carrito') }}">Carrito</a></li>
            <li><a href="{{ route('mis-pedidos') }}">Mis pedidos</a></li>
            <li><a href="{{ route('mis-direcciones') }}">Mis direcciones</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer__heading">Ayuda</h3>
          <ul class="footer__list">
            <li><a href="#">Envíos y entregas</a></li>
            <li><a href="#">Cambios y devoluciones</a></li>
            <li><a href="{{ route('contacto') }}">Contacto</a></li>
            <li><a href="{{ route('quienes-somos') }}">Quiénes somos</a></li>
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
  </body>
</html>