<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Productos — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main id="contenido">
      <div id="page-productos" class="page is-active">
        <div class="section">
          <h1 style="font-size:2.2rem;margin:0 0 2rem">Todos los productos</h1>

          {{-- Filtros por GET --}}
          <form method="GET" action="{{ route('productos') }}" class="toolbar">
            <div class="filter-group">
              <input type="text" name="q" value="{{ $filtros['q'] }}" placeholder="Buscar..." class="sort-select" />
            </div>
            <div style="display:flex;gap:0.75rem;align-items:center;flex-wrap:wrap">
              <select class="sort-select" name="coleccion_id">
                <option value="">Todas las colecciones</option>
                @foreach ($colecciones as $coleccion)
                  <option value="{{ $coleccion->id }}" {{ $filtros['coleccion_id'] == $coleccion->id ? 'selected' : '' }}>
                    {{ $coleccion->nombre_coleccion }}
                  </option>
                @endforeach
              </select>

              <select class="sort-select" name="categoria_id">
                <option value="">Todas las categorías</option>
                @foreach ($categorias as $categoria)
                  <option value="{{ $categoria->id }}" {{ $filtros['categoria_id'] == $categoria->id ? 'selected' : '' }}>
                    {{ $categoria->nombre_categoria }}
                  </option>
                @endforeach
              </select>

              <select class="sort-select" name="orden">
                <option value="" {{ $filtros['orden'] === '' ? 'selected' : '' }}>Destacados</option>
                <option value="nuevos" {{ $filtros['orden'] === 'nuevos' ? 'selected' : '' }}>Nuevos</option>
                <option value="precio_asc" {{ $filtros['orden'] === 'precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                <option value="precio_desc" {{ $filtros['orden'] === 'precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                <option value="nombre" {{ $filtros['orden'] === 'nombre' ? 'selected' : '' }}>Nombre A–Z</option>
              </select>

              <label style="font-size:0.85rem;display:flex;align-items:center;gap:0.3rem">
                <input type="checkbox" name="en_oferta" value="1" {{ $filtros['en_oferta'] ? 'checked' : '' }}>
                En oferta
              </label>
              <label style="font-size:0.85rem;display:flex;align-items:center;gap:0.3rem">
                <input type="checkbox" name="con_stock" value="1" {{ $filtros['con_stock'] ? 'checked' : '' }}>
                Con stock
              </label>

              <button type="submit" class="filter-btn is-active">Filtrar</button>
            </div>
          </form>

          <p class="count-label">{{ $productos->total() }} producto(s)</p>

          @if ($productos->isEmpty())
            <p class="empty-msg">No se encontraron productos.</p>
          @else
            <ul class="product-grid" id="productos-grid">
              @foreach ($productos as $producto)
                @php
                  $mediaClasses = ['product-card__media--sand','product-card__media--brand','product-card__media--ink','product-card__media--accent'];
                  $mediaClass = $mediaClasses[$loop->index % 4];
                @endphp
                <li class="product-card">
                  <a href="{{ route('productos.show', $producto) }}" style="text-decoration:none;color:inherit;display:block;">
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
                  </a>
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

            <div style="margin-top:2rem">
              {{ $productos->links() }}
            </div>
          @endif
        </div>
      </div>
    </main>

    @include('partials.footer')
  </body>
</html>