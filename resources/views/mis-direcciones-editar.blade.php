<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Editar dirección — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main id="contenido">
      <div class="section">
        <h1 style="font-size:2.2rem;margin:0 0 2rem">Editar dirección</h1>

        @error('direccion')
          <p style="color:red;margin-bottom:1rem">{{ $message }}</p>
        @enderror

        <form method="POST" action="{{ route('mis-direcciones.update', $direccion->id) }}" style="max-width:600px">
          @csrf
          @method('PUT')

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Provincia</label>
              <select name="provincia_id" class="sort-select" style="width:100%" required>
                <option value="">Seleccioná</option>
                @foreach ($provincias as $provincia)
                  <option value="{{ $provincia->id }}" {{ old('provincia_id', $direccion->localidad->provincia_id) == $provincia->id ? 'selected' : '' }}>{{ $provincia->descripcion }}</option>
                @endforeach
              </select>
              @error('provincia_id') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Localidad</label>
              <select name="localidad_id" class="sort-select" style="width:100%" required>
                <option value="">Seleccioná</option>
                @foreach ($localidades as $localidad)
                  <option value="{{ $localidad->id }}" {{ old('localidad_id', $direccion->localidad_id) == $localidad->id ? 'selected' : '' }}>{{ $localidad->descripcion }}</option>
                @endforeach
              </select>
              @error('localidad_id') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>
          </div>

          <div style="display:grid;grid-template-columns:2fr 1fr;gap:1rem;margin-top:0.8rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Calle</label>
              <input type="text" name="calle" value="{{ old('calle', $direccion->calle) }}" class="sort-select" style="width:100%" required>
              @error('calle') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Número</label>
              <input type="text" name="numero" value="{{ old('numero', $direccion->numero) }}" class="sort-select" style="width:100%" required>
              @error('numero') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-top:0.8rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Piso</label>
              <input type="text" name="piso" value="{{ old('piso', $direccion->piso) }}" class="sort-select" style="width:100%">
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Dpto</label>
              <input type="text" name="departamento" value="{{ old('departamento', $direccion->departamento) }}" class="sort-select" style="width:100%">
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Código postal</label>
              <input type="text" name="cod_postal" value="{{ old('cod_postal', $direccion->cod_postal) }}" class="sort-select" style="width:100%">
            </div>
          </div>

          <div class="form-field" style="margin-top:0.8rem">
            <label style="display:block;margin-bottom:0.3rem;font-weight:600">Referencia</label>
            <input type="text" name="referencia" value="{{ old('referencia', $direccion->referencia) }}" class="sort-select" style="width:100%">
          </div>

          <div style="display:flex;gap:0.5rem;margin-top:1rem">
            <button type="submit" class="filter-btn is-active">Guardar cambios</button>
            <a href="{{ route('mis-direcciones') }}" class="filter-btn">Cancelar</a>
          </div>
        </form>
      </div>
    </main>

    <footer class="footer">
      <div class="footer__grid">
        <div>
          <p class="footer__brand">AURA CLOTHES</p>
          <p class="footer__body">Prendas de lana, algodón y lino de uso diario, hechas en talleres pequeños.</p>
        </div>
        <div>
          <h3 class="footer__heading">Navegación</h3>
          <ul class="footer__list">
            <li><a href="{{ route('inicio') }}">Inicio</a></li>
            <li><a href="{{ route('productos') }}">Productos</a></li>
            <li><a href="{{ route('carrito') }}">Carrito</a></li>
            <li><a href="{{ route('mis-pedidos') }}">Mis pedidos</a></li>
            <li><a href="{{ route('mis-direcciones') }}">Mis direcciones</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer__heading">Ayuda</h3>
          <ul class="footer__list">
            <li><a href="#">Envíos y entregas</a></li>
            <li><a href="#">Cambios y devoluciones</a></li>
            <li><a href="{{ route('contacto') }}">Contacto</a></li>
            <li><a href="{{ route('quienes-somos') }}">Quiénes somos</a></li>
          </ul>
        </div>
        <div>
          <h3 class="footer__heading">Contacto</h3>
          <p class="footer__body">Lun a vie 9–18 hs · Sáb 9–13 hs</p>
          <ul class="footer__list footer__list--inline">
            <li><a href="#">Instagram</a></li>
            <li><a href="#">Facebook</a></li>
            <li><a href="#">Pinterest</a></li>
          </ul>
        </div>
      </div>
      <div class="footer__bottom">
        <p>© 2026 AURA CLOTHES. Todos los derechos reservados.</p>
        <ul class="footer__legal">
          <li><a href="#">Términos</a></li>
          <li><a href="#">Privacidad</a></li>
        </ul>
      </div>
    </footer>
  </body>
</html>