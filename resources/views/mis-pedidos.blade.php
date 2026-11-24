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

    @include('partials.footer')
  </body>
</html>