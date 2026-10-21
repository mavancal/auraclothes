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

    <!-- ===== TOPBAR ADMIN ===== -->
    <header class="topbar">
      <div class="topbar__inner">
        <div class="logo" aria-label="AURA CLOTHES, Administración">
          <span class="logo__mark">AC</span>
          <span class="logo__word">ADMINISTRACIÓN</span>
        </div>
        <div class="topbar__actions">
          <button class="btn btn--outline" type="button" onclick="logout()">Salir de la cuenta</button>
        </div>
      </div>
    </header>

    <!-- ===== NAVBAR ADMIN ===== -->
    <nav class="mainnav" aria-label="Navegación de administración">
      <ul class="mainnav__list">
        <li><a class="mainnav__link is-active" href="#">Productos</a></li>
        <li><a class="mainnav__link" href="#">Pedidos</a></li>
        <li><a class="mainnav__link" href="#">Usuarios</a></li>
      </ul>
    </nav>

    <!-- ===== CONTENIDO ===== -->
    <main class="section admin-container">
      <h1 class="page-title">Gestión de Catálogo</h1>
      
      <div class="dashboard-grid">
        
        <!-- COLUMNA PRINCIPAL: NUEVO PRODUCTO -->
        <div class="admin-card col-span-2">
          <h2 class="card-title">Cargar Nuevo Producto</h2>
          <form id="form-producto" class="admin-form">
            
            <div class="form-row">
              <div class="form-group">
                <label for="sku">SKU</label>
                <input type="text" id="sku" name="sku" required placeholder="Ej: AC-REM-001">
              </div>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Nombre del producto">
              </div>
            </div>

            <div class="form-group">
              <label for="descripcion">Descripción</label>
              <textarea id="descripcion" name="descripcion" rows="3" required placeholder="Detalles de la prenda..."></textarea>
            </div>

            <div class="form-group">
              <label for="imagen_url">URL de Imagen</label>
              <input type="text" id="imagen_url" name="imagen_url" required placeholder="https://ejemplo.com/imagen.jpg">
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="precio">Precio Regular ($)</label>
                <input type="number" id="precio" name="precio" required placeholder="0.00" min="0" step="0.01">
              </div>
              <div class="form-group">
                <label for="precio_oferta">Precio de Oferta ($) (Opcional)</label>
                <input type="number" id="precio_oferta" name="precio_oferta" placeholder="0.00" min="0" step="0.01">
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria" required>
                  <option value="" disabled selected>Selecciona una categoría...</option>
                  <option value="Remeras">Remeras</option>
                  <option value="Pantalones">Pantalones</option>
                  <option value="Buzos">Buzos</option>
                  <option value="HeadWear">HeadWear</option>
                </select>
              </div>
              <div class="form-group">
                <label for="coleccion">Colección</label>
                <select id="coleccion" name="coleccion" required>
                  <option value="" disabled selected>Selecciona una colección...</option>
                  <option value="Otoño 2026">Otoño 2026</option>
                  <option value="Invierno 2025">Invierno 2025</option>
                  <option value="Verano 2025">Verano 2025</option>
                  <option value="Básicos">Básicos</option>
                </select>
              </div>
            </div>

            <div class="form-group form-checkbox">
              <label>
                <input type="checkbox" id="activo" name="activo" checked>
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
            <form id="form-coleccion" class="admin-form">
              <div class="form-group">
                <label for="nombre_coleccion">Nombre de la Colección</label>
                <input type="text" id="nombre_coleccion" name="nombre_coleccion" required placeholder="Ej: Primavera 2027">
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn--secondary">Crear Colección</button>
              </div>
            </form>
          </div>

          <div class="admin-card">
            <h2 class="card-title">Cargar Categoría</h2>
            <form id="form-categoria" class="admin-form">
              <div class="form-group">
                <label for="nombre_categoria">Nombre de la Categoría</label>
                <input type="text" id="nombre_categoria" name="nombre_categoria" required placeholder="Ej: Calzado">
              </div>
              <div class="form-actions">
                <button type="submit" class="btn btn--secondary">Crear Categoría</button>
              </div>
            </form>
          </div>

        </div>

      </div>
    </main>

    <script src="admin.js"></script>
  </body>
</html>