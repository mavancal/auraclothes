<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Carrito — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main id="contenido">
      <div class="section">
        <h1 style="font-size:2.2rem;margin:0 0 2rem">Tu carrito</h1>

        @if (session('success'))
          <p style="color:green;margin-bottom:1rem">{{ session('success') }}</p>
        @endif
        @error('carrito')
          <p style="color:red;margin-bottom:1rem">{{ $message }}</p>
        @enderror

        @if ($items->isEmpty())
          <p class="empty-msg">Tu carrito está vacío.</p>
          <p style="margin-top:1rem"><a href="{{ route('productos') }}" class="filter-btn">Ir a productos</a></p>
        @else
          <ul class="product-grid" id="carrito-items">
            @foreach ($items as $item)
              @php $producto = $item['producto']; @endphp
              <li class="product-card">
                <div class="product-card__media product-card__media--sand">
                  @if ($producto->imagen_url)
                    <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}" style="width:100%;height:100%;object-fit:cover;display:block;" />
                  @else
                    <span class="placeholder-tag">{{ $producto->coleccion?->nombre_coleccion }}</span>
                  @endif
                </div>
                <p class="product-card__name">{{ $producto->nombre }}</p>
                <p class="product-card__price">${{ number_format($producto->precio_final, 0, ',', '.') }}</p>
                <p style="font-size:0.85rem;margin-top:0.3rem">Cantidad: {{ $item['cantidad'] }} · Subtotal: ${{ number_format($item['subtotal'], 0, ',', '.') }}</p>

                <form method="POST" action="{{ route('carrito.actualizar', $producto->id) }}" style="margin-top:0.5rem;display:flex;gap:0.4rem;align-items:center">
                  @csrf
                  @method('PATCH')
                  <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="0" max="99" style="width:3rem;padding:0.3rem">
                  <button type="submit" class="filter-btn">Actualizar</button>
                </form>

                <form method="POST" action="{{ route('carrito.quitar', $producto->id) }}" style="margin-top:0.4rem">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="filter-btn">Quitar</button>
                </form>
              </li>
            @endforeach
          </ul>

          <div style="margin-top:2rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
            <p style="font-size:1.1rem;font-weight:600">Subtotal: ${{ number_format($subtotal, 0, ',', '.') }}</p>
            <p style="font-size:0.85rem;color:#666">Envío gratis en compras desde ${{ number_format(config('tienda.envio.gratis_desde'), 0, ',', '.') }}</p>
            <div style="display:flex;gap:0.75rem">
              <form method="POST" action="{{ route('carrito.vaciar') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="filter-btn">Vaciar carrito</button>
              </form>
              <a href="{{ route('checkout') }}" class="filter-btn is-active">Finalizar compra</a>
            </div>
          </div>
        @endif
      </div>
    </main>

    @include('partials.footer')
  </body>
</html>