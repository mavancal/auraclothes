<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main id="contenido">
      <div class="section">
        <h1 style="font-size:2.2rem;margin:0 0 2rem">Confirmar compra</h1>

        @error('checkout')
          <p style="color:red;margin-bottom:1rem">{{ $message }}</p>
        @enderror

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;flex-wrap:wrap">
          {{-- Resumen del carrito --}}
          <div>
            <h2 style="font-size:1.2rem;margin-bottom:1rem">Tu pedido</h2>
            <ul class="product-grid" style="grid-template-columns:1fr">
              @foreach ($items as $item)
                @php $producto = $item['producto']; @endphp
                <li class="product-card" style="display:flex;gap:1rem;align-items:center">
                  <div class="product-card__media product-card__media--sand" style="width:80px;height:80px;flex-shrink:0">
                    @if ($producto->imagen_url)
                      <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}" style="width:100%;height:100%;object-fit:cover;display:block;" />
                    @endif
                  </div>
                  <div>
                    <p class="product-card__name" style="margin:0">{{ $producto->nombre }}</p>
                    <p style="font-size:0.85rem;margin:0.2rem 0">Cantidad: {{ $item['cantidad'] }}</p>
                    <p class="product-card__price" style="margin:0">$ {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                  </div>
                </li>
              @endforeach
            </ul>
            <p style="font-size:1.1rem;font-weight:600;margin-top:1rem">Subtotal: ${{ number_format($subtotal, 0, ',', '.') }}</p>
            @if ($costoEnvio > 0)
              <p style="font-size:0.95rem">Envío: ${{ number_format($costoEnvio, 0, ',', '.') }}</p>
              <p style="font-size:0.8rem;color:#666">Envío gratis en compras desde ${{ number_format($envioGratisDesde, 0, ',', '.') }}</p>
            @else
              <p style="font-size:0.95rem;color:green">Envío: gratis</p>
            @endif
            <p style="font-size:1.2rem;font-weight:700;margin-top:0.5rem">Total: ${{ number_format($total, 0, ',', '.') }}</p>
          </div>

          {{-- Formulario de confirmación --}}
          <div>
            <h2 style="font-size:1.2rem;margin-bottom:1rem">Datos de entrega y pago</h2>
            <form method="POST" action="{{ route('checkout.confirmar') }}">
              @csrf

              <div class="form-field" style="margin-bottom:1rem">
                <label style="display:block;margin-bottom:0.4rem;font-weight:600">Dirección de envío</label>
                @foreach ($direcciones as $direccion)
                  <label style="display:block;margin-bottom:0.4rem">
                    <input type="radio" name="direccion_id" value="{{ $direccion->id }}" {{ $loop->first ? 'checked' : '' }}>
                    {{ $direccion->calle }} {{ $direccion->numero }}{{ $direccion->piso ? ', Piso '.$direccion->piso : '' }}{{ $direccion->departamento ? ' Dpto '.$direccion->departamento : '' }}
                    — {{ $direccion->localidad->descripcion ?? '' }}
                    @if ($direccion->es_principal) <strong>(principal)</strong> @endif
                  </label>
                @endforeach
                @error('direccion_id')
                  <span style="color:red;font-size:0.85rem">{{ $message }}</span>
                @enderror
              </div>

              <div class="form-field" style="margin-bottom:1rem">
                <label style="display:block;margin-bottom:0.4rem;font-weight:600">Método de pago</label>
                @foreach ($metodosPago as $metodo)
                  <label style="display:block;margin-bottom:0.4rem">
                    <input type="radio" name="metodo_pago_id" value="{{ $metodo->id }}" {{ $loop->first ? 'checked' : '' }}>
                    {{ $metodo->metodo }}
                  </label>
                @endforeach
                @error('metodo_pago_id')
                  <span style="color:red;font-size:0.85rem">{{ $message }}</span>
                @enderror
              </div>

              <button type="submit" class="filter-btn is-active" style="margin-top:1rem">Confirmar compra</button>
              <a href="{{ route('carrito') }}" class="filter-btn" style="margin-left:0.5rem">Volver al carrito</a>
            </form>
          </div>
        </div>
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