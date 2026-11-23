<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Panel de Administración — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/estilos_vista_admin/panel_productos_admin.css') }}" />
  </head>
  <body>

    @include('partials.admin_header')

    <!-- ===== CONTENIDO ===== -->
    <main class="section admin-container">
      <h1 class="page-title">Gestión de Catálogo</h1>
      
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

      <div class="dashboard-grid">
        
        <!-- COLUMNA PRINCIPAL: NUEVO PRODUCTO -->
        <div class="admin-card col-span-2">
          <h2 class="card-title">Cargar Nuevo Producto</h2>
          <form id="form-producto" class="admin-form" method="POST" action="{{ route('panel_productos_admin.productos.store') }}">
            @csrf
            
            <div class="form-row">
              <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="sku" required placeholder="Ej: AC-REM-001" value="{{ old('sku') }}">
                @error('sku') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Nombre del producto" value="{{ old('nombre') }}">
                @error('nombre') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <textarea id="descripcion" name="descripcion" rows="3" required placeholder="Detalles de la prenda...">{{ old('descripcion') }}</textarea>
@error('descripcion') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
              <label for="imagen_url">URL de Imagen</label>
              <input type="text" id="imagen_url" name="imagen_url" required placeholder=""/img/productos/archivo.jpg o https://..."" value="{{ old('imagen_url') }}">
@error('imagen_url') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="precio">Precio Regular ($)</label>
                <input type="number" id="precio" name="precio" required placeholder="0.00" min="0" step="0.01" value="{{ old('precio') }}">
@error('precio') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-group">
                <label for="precio_oferta">Precio de Oferta ($) (Opcional)</label>
                <input type="number" id="precio_oferta" name="precio_oferta" placeholder="0.00" min="0" step="0.01" value="{{ old('precio_oferta') }}">
@error('precio_oferta') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-group">
                <label for="stock">Stock (unidades)</label>
                <input type="number" id="stock" name="stock" required min="0" max="100000" step="1" value="{{ old('stock', 0) }}">
                @error('stock') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria_id" required>
                  <option value="" disabled selected>Selecciona una categoría...</option>
                  @foreach($categorias ?? [] as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nombre_categoria }}</option>
                  @endforeach
                </select>
                @error('categoria_id') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-group">
                <label for="coleccion">Colección</label>
                <select id="coleccion" name="coleccion_id" required>
                  <option value="" disabled selected>Selecciona una colección...</option>
                  @foreach($colecciones ?? [] as $coleccion)
                    <option value="{{ $coleccion->id }}" {{ old('coleccion_id') == $coleccion->id ? 'selected' : '' }}>{{ $coleccion->nombre_coleccion }}</option>
                  @endforeach
                </select>
                @error('coleccion_id') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="form-group form-checkbox">
              <label>
                <input type="checkbox" id="activo" name="activo" value="1" @checked(old('activo', true))>
                Producto Activo (Visible en la tienda)
              </label>
            </div>

            <div class="form-actions">
              <button type="submit" class="btn btn--primary">Guardar Producto</button>
            </div>
          </form>
        </div>

        <!-- COLUMNA SECUNDARIA: COLECCIONES Y CATEGORÍAS -->
        <div class="admin-sidebar">
          
          <div class="admin-card">
            <h2 class="card-title">Cargar Colección</h2>
            <form id="form-coleccion" class="admin-form" method="POST" action="{{ route('panel_productos_admin.colecciones.store') }}">
              @csrf
              <div class="form-group">
                <label for="nombre_coleccion">Nombre de la Colección</label>
                <input type="text" id="nombre_coleccion" name="nombre_coleccion" required placeholder="Ej: Primavera 2027" value="{{ old('nombre_coleccion') }}">
                @error('nombre_coleccion') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn--secondary">Crear Colección</button>
              </div>
            </form>
          </div>

          <div class="admin-card">
            <h2 class="card-title">Cargar Categoría</h2>
            <form id="form-categoria" class="admin-form" method="POST" action="{{ route('panel_productos_admin.categorias.store') }}">
              @csrf
              <div class="form-group">
                <label for="nombre_categoria">Nombre de la Categoría</label>
                <input type="text" id="nombre_categoria" name="nombre_categoria" required placeholder="Ej: Calzado" value="{{ old('nombre_categoria') }}">
                @error('nombre_categoria') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn--secondary">Crear Categoría</button>
              </div>
            </form>
          </div>

        </div>

      </div>

      <section class="admin-card" style="margin-top:2rem;">
        <h2 class="card-title">Gestión de Colecciones</h2>
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr>
              <th style="text-align:left;padding:.5rem;">Nombre</th>
              <th style="text-align:right;padding:.5rem;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($colecciones ?? [] as $coleccion)
              <tr>
                <td style="padding:.5rem;">
                  <form method="POST" action="{{ route('panel_productos_admin.colecciones.update', $coleccion) }}" style="display:flex;gap:.5rem;align-items:center;">
                    @csrf
                    @method('PUT')
                    <input type="text" name="nombre_coleccion" value="{{ $coleccion->nombre_coleccion }}" required style="flex:1;">
                    <button type="submit" class="btn btn--secondary">Guardar</button>
                  </form>
                </td>
                <td style="padding:.5rem;text-align:right;">
                  <form method="POST" action="{{ route('panel_productos_admin.colecciones.destroy', $coleccion) }}" onsubmit="return confirm('¿Eliminar esta colección?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--outline">Eliminar</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </section>

      <section class="admin-card" style="margin-top:2rem;">
        <h2 class="card-title">Gestión de Categorías</h2>
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr>
              <th style="text-align:left;padding:.5rem;">Nombre</th>
              <th style="text-align:right;padding:.5rem;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($categorias ?? [] as $categoria)
              <tr>
                <td style="padding:.5rem;">
                  <form method="POST" action="{{ route('panel_productos_admin.categorias.update', $categoria) }}" style="display:flex;gap:.5rem;align-items:center;">
                    @csrf
                    @method('PUT')
                    <input type="text" name="nombre_categoria" value="{{ $categoria->nombre_categoria }}" required style="flex:1;">
                    <button type="submit" class="btn btn--secondary">Guardar</button>
                  </form>
                </td>
                <td style="padding:.5rem;text-align:right;">
                  <form method="POST" action="{{ route('panel_productos_admin.categorias.destroy', $categoria) }}" onsubmit="return confirm('¿Eliminar esta categoría?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--outline">Eliminar</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </section>

      <section class="admin-card" style="margin-top:2rem;">
        <h2 class="card-title">Gestión de Productos</h2>
        <table style="width:100%;border-collapse:collapse;">
          <thead>
            <tr>
              <th style="text-align:left;padding:.5rem;">SKU</th>
              <th style="text-align:left;padding:.5rem;">Nombre</th>
              <th style="text-align:left;padding:.5rem;">Precio</th>
              <th style="text-align:left;padding:.5rem;">Oferta</th>
              <th style="text-align:left;padding:.5rem;">Stock</th>
              <th style="text-align:left;padding:.5rem;">Colección</th>
              <th style="text-align:left;padding:.5rem;">Categoría</th>
              <th style="text-align:left;padding:.5rem;">Activo</th>
              <th style="text-align:right;padding:.5rem;">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($productos ?? [] as $producto)
              <tr>
                <td style="padding:.5rem;">{{ $producto->sku }}</td>
                <td style="padding:.5rem;">{{ $producto->nombre }}</td>
                <td style="padding:.5rem;">{{ $producto->precio }}</td>
                <td style="padding:.5rem;">{{ $producto->precio_oferta ?? '-' }}</td>
                <td style="padding:.5rem;">{{ $producto->stock }}</td>
                <td style="padding:.5rem;">{{ $producto->coleccion?->nombre_coleccion ?? '-' }}</td>
                <td style="padding:.5rem;">{{ $producto->categorias->pluck('nombre_categoria')->join(', ') ?: '-' }}</td>
                <td style="padding:.5rem;">{{ $producto->activo ? 'Sí' : 'No' }}</td>
                <td style="padding:.5rem;text-align:right;">
                  <a class="btn btn--secondary" href="{{ route('panel_productos_admin.productos.edit', $producto) }}">Editar</a>
                  <form method="POST" action="{{ route('panel_productos_admin.productos.destroy', $producto) }}" onsubmit="return confirm('¿Eliminar este producto?');" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn--outline">Eliminar</button>
                  </form>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </section>

    </main>

  </body>
</html>