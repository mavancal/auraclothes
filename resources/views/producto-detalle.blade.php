<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $producto->nombre }} | AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}" />
    <style>
      .product-detail-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 1.5rem;
      }
      .product-breadcrumb {
        font-size: 0.85rem;
        color: #777;
        margin-bottom: 2rem;
      }
      .product-breadcrumb a {
        color: #444;
        text-decoration: underline;
      }
      .product-detail-layout {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: start;
      }
      @media (max-width: 768px) {
        .product-detail-layout {
          grid-template-columns: 1fr;
          gap: 2rem;
        }
      }
      .product-gallery {
        position: relative;
        background: #f4f4f4;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .product-gallery img {
        width: 100%;
        height: 100%;
        object-fit: cover;
      }
      .product-info-col h1 {
        font-size: 2.2rem;
        margin: 0.5rem 0 1rem 0;
        font-family: 'Roboto Condensed', sans-serif;
        letter-spacing: -0.5px;
      }
      .product-meta-tags {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
      }
      .badge-tag {
        background: #eee;
        padding: 0.25rem 0.6rem;
        border-radius: 4px;
        font-size: 0.8rem;
        font-weight: 500;
        text-transform: uppercase;
      }
      .badge-offer {
        background: #b00020;
        color: #fff;
      }
      .product-price-box {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 1.5rem 0;
        display: flex;
        align-items: baseline;
        gap: 0.8rem;
      }
      .price-old-strike {
        font-size: 1.2rem;
        color: #888;
        text-decoration: line-through;
        font-weight: 400;
      }
      .product-desc {
        color: #444;
        line-height: 1.7;
        margin-bottom: 2rem;
        font-size: 1rem;
      }
      .stock-status {
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        font-weight: 500;
      }
      .stock-available {
        color: #1e4620;
      }
      .stock-unavailable {
        color: #b00020;
      }
      .add-to-cart-form {
        display: flex;
        gap: 1rem;
        align-items: center;
        margin-bottom: 2rem;
      }
      .qty-input {
        width: 4rem;
        padding: 0.7rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        text-align: center;
      }
      .btn-add-cart {
        padding: 0.8rem 2rem;
        background: #111;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
      }
      .btn-add-cart:hover:not(:disabled) {
        background: #333;
      }
      .btn-add-cart:disabled {
        background: #999;
        cursor: not-allowed;
      }
      .sku-tag {
        font-size: 0.8rem;
        color: #888;
      }
      .related-section {
        margin-top: 4rem;
        padding-top: 3rem;
        border-top: 1px solid #e5e5e5;
      }
      .related-title {
        font-size: 1.5rem;
        margin-bottom: 1.5rem;
        font-family: 'Roboto Condensed', sans-serif;
      }
    </style>
  </head>
  <body>
    @include('partials.header')

    <main class="product-detail-container">
      <nav class="product-breadcrumb" aria-label="Ruta de navegación">
        <a href="{{ route('inicio') }}">Inicio</a> &gt;
        <a href="{{ route('productos') }}">Productos</a>
        @if ($producto->coleccion)
          &gt; <a href="{{ route('productos', ['coleccion_id' => $producto->coleccion_id]) }}">{{ $producto->coleccion->nombre_coleccion }}</a>
        @endif
        &gt; <span>{{ $producto->nombre }}</span>
      </nav>

      @if (session('success'))
        <div style="background:#e6f4ea;color:#1e4620;padding:1rem;border-radius:4px;margin-bottom:1.5rem;">
          {{ session('success') }}
        </div>
      @endif

      @if ($errors->any())
        <div style="background:#fce8e6;color:#b00020;padding:1rem;border-radius:4px;margin-bottom:1.5rem;">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="product-detail-layout">
        {{-- Imagen del producto --}}
        <div class="product-gallery">
          @if ($producto->imagen_url)
            <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}" />
          @else
            <span style="font-size:1.5rem;color:#888;">{{ $producto->coleccion->nombre_coleccion ?? 'AURA CLOTHES' }}</span>
          @endif

          @if ($producto->porcentaje_descuento)
            <span class="tag-discount" style="position:absolute;top:1rem;left:1rem;background:#b00020;color:#fff;padding:0.4rem 0.8rem;border-radius:4px;font-weight:700;">-{{ $producto->porcentaje_descuento }}% OFF</span>
          @endif
        </div>

        {{-- Información y compra --}}
        <div class="product-info-col">
          <div class="product-meta-tags">
            @if ($producto->coleccion)
              <span class="badge-tag">{{ $producto->coleccion->nombre_coleccion }}</span>
            @endif
            @foreach ($producto->categorias as $cat)
              <span class="badge-tag">{{ $cat->nombre_categoria }}</span>
            @endforeach
            @if ($producto->precio_oferta)
              <span class="badge-tag badge-offer">Oferta</span>
            @endif
          </div>

          <h1>{{ $producto->nombre }}</h1>
          <p class="sku-tag">SKU: {{ $producto->sku }}</p>

          <div class="product-price-box">
            @if ($producto->precio_oferta)
              <span class="price-old-strike">${{ number_format($producto->precio, 0, ',', '.') }}</span>
            @endif
            <span>${{ number_format($producto->precio_final, 0, ',', '.') }}</span>
          </div>

          <div class="product-desc">
            @if ($producto->descripcion)
              <p>{{ $producto->descripcion }}</p>
            @else
              <p>Prenda confeccionada con materias primas de primera calidad en talleres locales.</p>
            @endif
          </div>

          <div class="stock-status">
            @if ($producto->stock > 0)
              <span class="stock-available">✓ Disponible en stock ({{ $producto->stock }} unidades)</span>
            @else
              <span class="stock-unavailable">✕ Agotado temporalmente</span>
            @endif
          </div>

          <form class="add-to-cart-form" method="POST" action="{{ route('carrito.agregar') }}">
            @csrf
            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
            <input 
              class="qty-input" 
              type="number" 
              name="cantidad" 
              value="1" 
              min="1" 
              max="{{ $producto->stock }}" 
              {{ $producto->stock < 1 ? 'disabled' : '' }} 
              aria-label="Cantidad"
            />
            <button class="btn-add-cart" type="submit" {{ $producto->stock < 1 ? 'disabled' : '' }}>
              {{ $producto->stock < 1 ? 'Sin stock' : 'Agregar al carrito' }}
            </button>
          </form>

          <p style="font-size:0.85rem;color:#666;line-height:1.5;">
            🚚 <strong>Envío sin cargo</strong> en compras a partir de ${{ number_format(config('tienda.envio.gratis_desde', 50000), 0, ',', '.') }}.<br>
            🔄 <strong>Cambios y devoluciones:</strong> 30 días para cambio sin costo.
          </p>
        </div>
      </div>

      {{-- Productos relacionados --}}
      @if ($relacionados->isNotEmpty())
        <section class="related-section">
          <h2 class="related-title">También te puede interesar</h2>
          <ul class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.5rem;">
            @foreach ($relacionados as $rel)
              <li class="product-card">
                <a href="{{ route('productos.show', $rel) }}" style="text-decoration:none;color:inherit;">
                  <div class="product-card__media" style="aspect-ratio:1/1;background:#f4f4f4;position:relative;">
                    @if ($rel->imagen_url)
                      <img src="{{ asset($rel->imagen_url) }}" alt="{{ $rel->nombre }}" style="width:100%;height:100%;object-fit:cover;display:block;" />
                    @else
                      <span class="placeholder-tag">{{ $rel->coleccion->nombre_coleccion ?? 'AURA' }}</span>
                    @endif
                    @if ($rel->porcentaje_descuento)
                      <span class="tag-discount">-{{ $rel->porcentaje_descuento }}%</span>
                    @endif
                  </div>
                  <p class="product-card__name" style="margin-top:0.5rem;font-weight:600;">{{ $rel->nombre }}</p>
                  <p class="product-card__price">
                    @if ($rel->precio_oferta)
                      <span class="price-old">${{ number_format($rel->precio, 0, ',', '.') }}</span>
                    @endif
                    ${{ number_format($rel->precio_final, 0, ',', '.') }}
                  </p>
                </a>
              </li>
            @endforeach
          </ul>
        </section>
      @endif
    </main>

    @include('partials.footer')
  </body>
</html>
