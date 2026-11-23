<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pedido #{{ $pedido->id }} — Panel de Administración — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/estilos_vista_admin/panel_productos_admin.css') }}" />
  </head>
  <body>

    @include('partials.admin_header')

    <main class="section admin-container">
      <h1 class="page-title">Pedido #{{ $pedido->id }}</h1>

      @if (session('success'))
        <div class="success-message" style="margin-bottom:1rem;">
          <h2>{{ session('success') }}</h2>
        </div>
      @endif
      @error('estado')
        <div class="error-summary" style="color:#b00020;margin-bottom:1rem;">
          <p>{{ $message }}</p>
        </div>
      @enderror

      <div class="dashboard-grid">
        {{-- Estado y acciones --}}
        <section class="admin-card">
          <h2 class="card-title">Estado</h2>
          <p style="font-size:1.2rem;margin:.5rem 0 1rem;"><strong>{{ $pedido->estadoPedido->descripcion }}</strong></p>

          @if (empty($estadosSiguientes))
            <p>Este pedido está terminado: ya no cambia de estado.</p>
          @else
            <p style="margin-bottom:.5rem;">Pasar a:</p>
            <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
              @foreach ($estadosSiguientes as $estado)
                <form method="POST" action="{{ route('panel_pedidos_admin.estado', $pedido) }}"
                      @if ($estado === \App\Models\EstadoPedido::CANCELADO) onsubmit="return confirm('¿Cancelar el pedido #{{ $pedido->id }}? Se devuelve el stock.');" @endif>
                  @csrf
                  @method('PATCH')
                  <input type="hidden" name="estado" value="{{ $estado }}">
                  <button type="submit" class="btn {{ $estado === \App\Models\EstadoPedido::CANCELADO ? 'btn--outline' : 'btn--primary' }}">{{ $estado }}</button>
                </form>
              @endforeach
            </div>
          @endif
        </section>

        {{-- Cliente y envío --}}
        <section class="admin-card">
          <h2 class="card-title">Cliente</h2>
          @php $contacto = $pedido->user->contacto; $dir = $pedido->direccionEnvio; @endphp
          <p><strong>{{ $contacto->nombre }} {{ $contacto->apellido }}</strong> ({{ $pedido->user->name }})</p>
          <p>{{ $pedido->user->email }}@if ($contacto->telefono) · Tel. {{ $contacto->telefono }}@endif</p>

          <h2 class="card-title" style="margin-top:1rem;">Envío</h2>
          <p>
            {{ $dir->calle }} {{ $dir->numero }}{{ $dir->piso ? ', Piso '.$dir->piso : '' }}{{ $dir->departamento ? ' Dpto '.$dir->departamento : '' }}<br>
            {{ $dir->localidad->descripcion }}@if ($dir->cod_postal) · CP {{ $dir->cod_postal }}@endif
          </p>
          @if ($dir->referencia)
            <p><small>Ref: {{ $dir->referencia }}</small></p>
          @endif
          <p style="margin-top:.5rem;">Método de pago: <strong>{{ $pedido->metodoPago->metodo }}</strong></p>
          <p>Fecha: {{ $pedido->fecha_ped->format('d/m/Y H:i') }}</p>
        </section>
      </div>

      {{-- Productos --}}
      <section class="admin-card" style="margin-top:2rem;">
        <h2 class="card-title">Productos</h2>
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr>
              <th style="text-align:left;padding:.5rem;">Producto</th>
              <th style="text-align:right;padding:.5rem;">Cantidad</th>
              <th style="text-align:right;padding:.5rem;">Precio unitario</th>
              <th style="text-align:right;padding:.5rem;">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pedido->detalles as $detalle)
              <tr>
                <td style="padding:.5rem;">{{ $detalle->producto->nombre }} <small>({{ $detalle->producto->sku }})</small></td>
                <td style="padding:.5rem;text-align:right;">{{ $detalle->cantidad }}</td>
                <td style="padding:.5rem;text-align:right;">${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</td>
                <td style="padding:.5rem;text-align:right;">${{ number_format($detalle->precio_unitario * $detalle->cantidad, 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

        <div style="text-align:right;margin-top:1rem;">
          <p>Subtotal: ${{ number_format($pedido->subtotal(), 0, ',', '.') }}</p>
          @if ($pedido->descuento > 0)
            <p>Descuento: -${{ number_format($pedido->descuento, 0, ',', '.') }}</p>
          @endif
          <p>Envío: ${{ number_format($pedido->costo_envio, 0, ',', '.') }}</p>
          <p style="font-size:1.2rem;"><strong>Total: ${{ number_format($pedido->total(), 0, ',', '.') }}</strong></p>
        </div>
      </section>

      <p style="margin-top:1.5rem;"><a class="btn btn--secondary" href="{{ route('panel_pedidos_admin') }}">Volver a pedidos</a></p>
    </main>
  </body>
</html>