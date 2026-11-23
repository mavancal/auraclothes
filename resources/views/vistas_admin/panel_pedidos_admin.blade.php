<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pedidos — Panel de Administración — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/estilos_vista_admin/panel_productos_admin.css') }}" />
  </head>
  <body>

    @include('partials.admin_header')

    <main class="section admin-container">
      <h1 class="page-title">Gestión de Pedidos</h1>

      {{-- Filtros: se envían por GET, así quedan en la URL --}}
      <section class="admin-card">
        <form method="GET" action="{{ route('panel_pedidos_admin') }}" style="display:flex;gap:1rem;align-items:flex-end;flex-wrap:wrap;">
          <div class="form-group">
            <label for="estado_pedido_id">Estado</label>
            <select id="estado_pedido_id" name="estado_pedido_id">
              <option value="">Todos</option>
              @foreach ($estados as $estado)
                <option value="{{ $estado->id }}" {{ $filtros['estado_pedido_id'] == $estado->id ? 'selected' : '' }}>{{ $estado->descripcion }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="q">Buscar</label>
            <input type="text" id="q" name="q" value="{{ $filtros['q'] }}" placeholder="N° de pedido, usuario o correo">
          </div>
          <button type="submit" class="btn btn--primary">Filtrar</button>
          <a class="btn btn--secondary" href="{{ route('panel_pedidos_admin') }}">Limpiar</a>
        </form>
      </section>

      <section class="admin-card" style="margin-top:2rem;">
        <h2 class="card-title">{{ $pedidos->total() }} pedido(s)</h2>

        @if ($pedidos->isEmpty())
          <p>No hay pedidos con esos filtros.</p>
        @else
          <table style="width:100%;border-collapse:collapse;">
            <thead>
              <tr>
                <th style="text-align:left;padding:.5rem;">N°</th>
                <th style="text-align:left;padding:.5rem;">Fecha</th>
                <th style="text-align:left;padding:.5rem;">Cliente</th>
                <th style="text-align:left;padding:.5rem;">Estado</th>
                <th style="text-align:right;padding:.5rem;">Total</th>
                <th style="text-align:right;padding:.5rem;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($pedidos as $pedido)
                <tr>
                  <td style="padding:.5rem;">#{{ $pedido->id }}</td>
                  <td style="padding:.5rem;">{{ $pedido->fecha_ped->format('d/m/Y H:i') }}</td>
                  <td style="padding:.5rem;">{{ $pedido->user->name }}<br><small>{{ $pedido->user->email }}</small></td>
                  <td style="padding:.5rem;">{{ $pedido->estadoPedido->descripcion }}</td>
                  <td style="padding:.5rem;text-align:right;">${{ number_format($pedido->total(), 0, ',', '.') }}</td>
                  <td style="padding:.5rem;text-align:right;">
                    <a class="btn btn--secondary" href="{{ route('panel_pedidos_admin.show', $pedido) }}">Ver</a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>

          <div style="margin-top:1rem;">
            {{ $pedidos->links() }}
          </div>
        @endif
      </section>
    </main>
  </body>
</html>