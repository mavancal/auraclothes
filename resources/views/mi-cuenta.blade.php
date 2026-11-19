<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mi cuenta — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main id="contenido">
      <div class="section">
        <h1 style="font-size:2.2rem;margin:0 0 2rem">Mi cuenta</h1>

        @if (session('success'))
          <p style="color:green;margin-bottom:1rem">{{ session('success') }}</p>
        @endif

        {{-- Datos personales (solo lectura + editables) --}}
        <h2 style="font-size:1.2rem;margin-bottom:1rem">Datos personales</h2>
        <form method="POST" action="{{ route('mi-cuenta.datos') }}" style="max-width:600px">
          @csrf
          @method('PATCH')

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Nombre de usuario</label>
              <input type="text" value="{{ $user->name }}" class="sort-select" style="width:100%" disabled>
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Correo (login)</label>
              <input type="text" value="{{ $user->email }}" class="sort-select" style="width:100%" disabled>
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:0.8rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Nombre</label>
              <input type="text" value="{{ $contacto->nombre }}" class="sort-select" style="width:100%" disabled>
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Apellido</label>
              <input type="text" value="{{ $contacto->apellido }}" class="sort-select" style="width:100%" disabled>
            </div>
          </div>

          <div class="form-field" style="margin-top:0.8rem">
            <label style="display:block;margin-bottom:0.3rem;font-weight:600">Segundo nombre (editable)</label>
            <input type="text" name="nombre2" value="{{ old('nombre2', $contacto->nombre2) }}" class="sort-select" style="width:100%">
            @error('nombre2') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:0.8rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Teléfono (editable)</label>
              <input type="text" name="telefono" value="{{ old('telefono', $contacto->telefono) }}" class="sort-select" style="width:100%">
              @error('telefono') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Email de contacto (editable)</label>
              <input type="email" name="email_contacto" value="{{ old('email_contacto', $contacto->email_contacto) }}" class="sort-select" style="width:100%">
              @error('email_contacto') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-top:0.8rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Documento</label>
              <input type="text" value="{{ $contacto->tipoDocumento?->descripcion }} {{ $contacto->numero_documento }}" class="sort-select" style="width:100%" disabled>
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">CUIT</label>
              <input type="text" value="{{ $contacto->cuit }}" class="sort-select" style="width:100%" disabled>
            </div>
          </div>

          <div class="form-field" style="margin-top:0.8rem">
            <label style="display:block;margin-bottom:0.3rem;font-weight:600">Fecha de nacimiento</label>
            <input type="text" value="{{ $contacto->fecha_nacimiento }}" class="sort-select" style="width:100%" disabled>
          </div>

          <button type="submit" class="filter-btn is-active" style="margin-top:1rem">Guardar datos</button>
        </form>

        {{-- Cambio de contraseña --}}
        <h2 style="font-size:1.2rem;margin:2.5rem 0 1rem">Cambiar contraseña</h2>
        <form method="POST" action="{{ route('mi-cuenta.password') }}" style="max-width:600px">
          @csrf
          @method('PUT')

          <div class="form-field" style="margin-bottom:0.8rem">
            <label style="display:block;margin-bottom:0.3rem;font-weight:600">Contraseña actual</label>
            <input type="password" name="password_actual" class="sort-select" style="width:100%" required>
            @error('password_actual') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
          </div>

          <div class="form-field" style="margin-bottom:0.8rem">
            <label style="display:block;margin-bottom:0.3rem;font-weight:600">Nueva contraseña</label>
            <input type="password" name="password" class="sort-select" style="width:100%" required>
            @error('password') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
          </div>

          <div class="form-field" style="margin-bottom:0.8rem">
            <label style="display:block;margin-bottom:0.3rem;font-weight:600">Confirmar nueva contraseña</label>
            <input type="password" name="password_confirmation" class="sort-select" style="width:100%" required>
          </div>

          <button type="submit" class="filter-btn is-active" style="margin-top:0.5rem">Cambiar contraseña</button>
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
            <li><a href="{{ route('mi-cuenta') }}">Mi cuenta</a></li>
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