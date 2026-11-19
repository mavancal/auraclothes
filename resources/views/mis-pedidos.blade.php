<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mis pedidos — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main id="contenido">
      <div class="section">
        <h1 style="font-size:2.2rem;margin:0 0 2rem">Mis pedidos</h1>

        @if (session('success'))
          <p style="color:green;margin-bottom:1rem">{{ session('success') }}</p>
        @endif
        @error('pedido')
          <p style="color:red;margin-bottom:1rem">{{ $message }}</p>
        @enderror

        @if ($pedidos->isEmpty())
          <p class="empty-msg">Todavía no tenés pedidos.</p>
          <p style="margin-top:1rem"><a href="{{ route('productos') }}" class="filter-btn">Ir a productos</a></p>
        @else
          <ul class="product-grid" style="grid-template-columns:1fr">
            @foreach ($pedidos as $pedido)
              <li class="product-card" style="padding:1rem">
                <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem">
                  <p class="product-card__name" style="margin:0">Pedido #{{ $pedido->id }}</p>
                  <span style="font-size:0.85rem;color:#666">{{ $pedido->fecha_ped->format('d/m/Y') }}</span>
                </div>
                <p style="font-size:0.9rem;margin:0.4rem 0">Estado: <strong>{{ $pedido->estadoPedido->descripcion }}</strong></p>
                <p class="product-card__price" style="margin:0.4rem 0">$ {{ number_format($pedido->total(), 0, ',', '.') }}</p>
                <p style="margin-top:0.6rem">
                  <a href="{{ route('mis-pedidos.show', $pedido) }}" class="filter-btn">Ver detalle</a>
                </p>
              </li>
            @endforeach
          </ul>

          <div style="margin-top:2rem">
            {{ $pedidos->links() }}
          </div>
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