<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar Producto — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/estilos_vista_admin/panel_productos_admin.css') }}" />
  </head>
  <body>

    @include('partials.admin_header')
    
    <main class="section admin-container">
      <h1 class="page-title">Editar Producto</h1>

      @if(session('success'))
        <div class="success-message" style="margin-bottom:1rem;">
          <h2>{{ session('success') }}</h2>
        </div>
      @endif
      @if(session('error'))
        <div class="error-summary" style="color:#b00020;margin-bottom:1rem;">
          <p>{{ session('error') }}</p>
        </div>
      @endif
      @if($errors->any())
        <div class="error-summary" style="color:#b00020;margin-bottom:1rem;">
          <p>Hay errores en el formulario. Revisá los campos marcados.</p>
        </div>
      @endif

      <div class="admin-card col-span-2">
        <form id="form-producto" class="admin-form" method="POST" action="{{ route('panel_productos_admin.productos.update', $producto) }}">
          @csrf
          @method('PUT')

          <div class="form-row">
            <div class="form-group">
              <label for="sku">SKU</label>
              <input type="text" id="sku" name="sku" required placeholder="Ej: AC-REM-001" value="{{ old('sku', $producto->sku) }}">
              @error('sku') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" id="nombre" name="nombre" required placeholder="Nombre del producto" value="{{ old('nombre', $producto->nombre) }}">
              @error('nombre') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" rows="3" placeholder="Detalles de la prenda...">{{ old('descripcion', $producto->descripcion) }}</textarea>
            @error('descripcion') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
          </div>

          <div class="form-group">
            <label for="imagen_url">URL de Imagen</label>
            <input type="text" id="imagen_url" name="imagen_url" placeholder="https://ejemplo.com/imagen.jpg" value="{{ old('imagen_url', $producto->imagen_url) }}">
            @error('imagen_url') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="precio">Precio Regular ($)</label>
              <input type="number" id="precio" name="precio" required placeholder="0.00" min="0" step="0.01" value="{{ old('precio', $producto->precio) }}">
              @error('precio') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
              <label for="precio_oferta">Precio de Oferta ($) (Opcional)</label>
              <input type="number" id="precio_oferta" name="precio_oferta" placeholder="0.00" min="0" step="0.01" value="{{ old('precio_oferta', $producto->precio_oferta) }}">
              @error('precio_oferta') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
              <label for="stock">Stock (unidades)</label>
              <input type="number" id="stock" name="stock" required min="0" max="100000" step="1" value="{{ old('stock', $producto->stock) }}">
              @error('stock') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label for="categoria">Categoría</label>
              <select id="categoria" name="categoria_id" required>
                <option value="" disabled>Selecciona una categoría...</option>
                @foreach($categorias ?? [] as $categoria)
                  <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categorias->first()?->id) == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre_categoria }}</option>
                @endforeach
              </select>
              @error('categoria_id') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
              <label for="coleccion">Colección</label>
              <select id="coleccion" name="coleccion_id">
                <option value="" disabled>Selecciona una colección...</option>
                @foreach($colecciones ?? [] as $coleccion)
                  <option value="{{ $coleccion->id }}" {{ old('coleccion_id', $producto->coleccion_id) == $coleccion->id ? 'selected' : '' }}>{{ $coleccion->nombre_coleccion }}</option>
                @endforeach
              </select>
              @error('coleccion_id') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="form-group form-checkbox">
            <label>
              <input type="checkbox" id="activo" name="activo" value="1" @checked(old('activo', $producto->activo))>
              Producto Activo (Visible en la tienda)
            </label>
          </div>

          <div class="form-actions">
            <button type="submit" class="btn btn--primary">Guardar Cambios</button>
            <a class="btn btn--secondary" href="{{ route('panel_productos_admin') }}">Cancelar</a>
          </div>
        </form>
      </div>
    </main>
  </body>
</html>