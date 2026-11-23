<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mensajes — Panel de Administración — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/estilos_vista_admin/panel_productos_admin.css') }}" />
  </head>
  <body>

    @include('partials.admin_header')

    <main class="section admin-container">
      <h1 class="page-title">Mensajes de contacto</h1>
      <p style="margin-bottom:1rem;">{{ $noLeidos }} sin leer</p>

      @if ($mensajes->isEmpty())
        <section class="admin-card">
          <p>Todavía no llegó ningún mensaje.</p>
        </section>
      @else
        @foreach ($mensajes as $mensaje)
          <section class="admin-card" style="margin-bottom:1rem;{{ $mensaje->leido ? 'opacity:.6;' : '' }}">
            <div style="display:flex;justify-content:space-between;gap:1rem;flex-wrap:wrap;">
              <div>
                <h2 class="card-title" style="margin:0;">
                  @unless ($mensaje->leido) <span style="color:#b00020;">●</span> @endunless
                  {{ $mensaje->asunto }}
                </h2>
                <p style="margin:.3rem 0;">
                  {{ $mensaje->nombre }} · <a href="mailto:{{ $mensaje->email }}">{{ $mensaje->email }}</a>
                  · {{ $mensaje->created_at->format('d/m/Y H:i') }}
                </p>
              </div>
              <form method="POST" action="{{ route('panel_mensajes_admin.leido', $mensaje) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn--secondary">{{ $mensaje->leido ? 'Marcar como no leído' : 'Marcar como leído' }}</button>
              </form>
            </div>
            <p style="margin-top:.75rem;white-space:pre-line;">{{ $mensaje->mensaje }}</p>
          </section>
        @endforeach

        {{ $mensajes->links() }}
      @endif
    </main>
  </body>
</html>