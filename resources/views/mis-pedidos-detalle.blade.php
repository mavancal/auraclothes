<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pedido #{{ $pedido->id }} — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main id="contenido">
      <div class="section">
        <h1 style="font-size:2.2rem;margin:0 0 2rem">Pedido #{{ $pedido->id }}</h1>

        @if (session('success'))
          <p style="color:green;margin-bottom:1rem">{{ session('success') }}</p>
        @endif
        @error('pedido')
          <p style="color:red;margin-bottom:1rem">{{ $message }}</p>
        @enderror

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;flex-wrap:wrap">
          {{-- Datos del pedido --}}
          <div>
            <h2 style="font-size:1.2rem;margin-bottom:1rem">Resumen</h2>
            <p style="margin:0.3rem 0">Fecha: <strong>{{ $pedido->fecha_ped->format('d/m/Y') }}</strong></p>
            <p style="margin:0.3rem 0">Estado: <strong>{{ $pedido->estadoPedido->descripcion }}</strong></p>
            <p style="margin:0.3rem 0">Método de pago: <strong>{{ $pedido->metodoPago->metodo }}</strong></p>
            <p style="margin:0.3rem 0">Subtotal: ${{ number_format($pedido->subtotal(), 0, ',', '.') }}</p>
            <p style="margin:0.3rem 0">Envío: ${{ number_format($pedido->costo_envio, 0, ',', '.') }}</p>
            <p style="margin:0.3rem 0;font-weight:600">Total: ${{ number_format($pedido->total(), 0, ',', '.') }}</p>

            <h2 style="font-size:1.2rem;margin:1.5rem 0 0.5rem">Dirección de envío</h2>
            @php $dir = $pedido->direccionEnvio; @endphp
            <p style="margin:0.2rem 0">{{ $dir->calle }} {{ $dir->numero }}{{ $dir->piso ? ', Piso '.$dir->piso : '' }}{{ $dir->departamento ? ' Dpto '.$dir->departamento : '' }}</p>
            <p style="margin:0.2rem 0">{{ $dir->localidad->descripcion ?? '' }}</p>
          </div>

          {{-- Productos --}}
          <div>
            <h2 style="font-size:1.2rem;margin-bottom:1rem">Productos</h2>
            <ul class="product-grid" style="grid-template-columns:1fr">
              @foreach ($pedido->detalles as $detalle)
                <li class="product-card" style="padding:1rem">
                  <p class="product-card__name" style="margin:0">{{ $detalle->producto->nombre }}</p>
                  <p style="font-size:0.85rem;margin:0.2rem 0">Cantidad: {{ $detalle->cantidad }}</p>
                  <p style="font-size:0.85rem;margin:0.2rem 0">Precio unitario: ${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</p>
                </li>
              @endforeach
            </ul>
          </div>
        </div>

        <div style="margin-top:2rem">
          @can('cancelar', $pedido)
            <form method="POST" action="{{ route('mis-pedidos.cancelar', $pedido) }}">
              @csrf
              <button type="submit" class="filter-btn" onclick="return confirm('¿Seguro que querés cancelar el pedido?')">Cancelar pedido</button>
            </form>
          @else
            <p style="color:#666;font-size:0.9rem">Este pedido no se puede cancelar (solo los pedidos Pendientes pueden cancelarse).</p>
          @endcan

          <p style="margin-top:1rem"><a href="{{ route('mis-pedidos') }}" class="filter-btn">Volver a mis pedidos</a></p>
        </div>
      </div>
    </main>

    @include('partials.footer')
  </body>
</html>