<!doctype html>
<html lang="es">
  <head>
    <!-- figma:head-start -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Crear cuenta | AURA CLOTHES</title>
    <!-- figma:head-end -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/registro.css') }}" />
  </head>
  <body>
    @include('partials.header')

    <main class="registration-main">
      <section class="registration-panel" aria-labelledby="registration-title">
        <div class="registration-heading">
          <p class="registration-kicker">NUEVA CUENTA</p>
          <h1 id="registration-title">Crear una cuenta</h1>
          <p>Completá tus datos para registrarte en AURA CLOTHES.</p>
        </div>

        <div class="success-message" id="registration-success" hidden>
          <span class="success-message__mark" aria-hidden="true">AC</span>
          <h2>Datos recibidos</h2>
          <p>El formulario se completó correctamente.</p>
          <button class="btn btn--primary" id="registration-reset" type="button">Completar otro registro</button>
          <a class="text-link" href="{{ route('cuenta') }}">Volver a iniciar sesión</a>
        </div>

        @if(session('success'))
          <div class="success-message">
            <span class="success-message__mark" aria-hidden="true">AC</span>
            <h2>{{ session('success') }}</h2>
          </div>
        @endif

        @if($errors->any())
          <div class="error-summary" style="color:#b00020;margin-bottom:1rem;">
            <p>Hay errores en el formulario. Revisá los campos marcados.</p>
            @error('registro') <p>{{ $message }}</p> @enderror
          </div>
        @endif

        <form id="registration-form" method="POST" action="{{ route('registro.store') }}">
            @csrf
          <fieldset>
            <legend>Datos de acceso</legend>
            <div class="form-grid">
              <div class="form-field">
                <label for="name">Nombre de usuario</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" autocomplete="username" required />
                @error('name') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" autocomplete="new-password" required />
                @error('password') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="password_confirmation">Repetir contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" required />
                @error('password_confirmation') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field form-field--wide">
                <label for="email">Correo</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" autocomplete="email" required />
                @error('email') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
            </div>

          </fieldset>

          <fieldset>
            <legend>Datos personales</legend>
            <div class="form-grid">
              <div class="form-field">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" autocomplete="given-name" required />
                @error('nombre') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="nombre2">Segundo nombre</label>
                <input type="text" id="nombre2" name="nombre2" value="{{ old('nombre2') }}" autocomplete="additional-name" />
                @error('nombre2') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" autocomplete="family-name" required />
                @error('apellido') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="fecha_nacimiento">Fecha de nacimiento</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" autocomplete="bday" required />
                @error('fecha_nacimiento') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="tipo_persona_id">Tipo de persona</label>
                <select id="tipo_persona_id" name="tipo_persona_id" required>
                  <option value="" disabled @selected(! old('tipo_persona_id'))>Seleccionar</option>
                  @foreach($tiposPersona ?? [] as $tipoPersona)
                    <option value="{{ $tipoPersona->id }}" @selected(old('tipo_persona_id') == $tipoPersona->id)>{{ $tipoPersona->descripcion }}</option>
                  @endforeach





                </select>
                @error('tipo_persona_id') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="cuit">CUIT</label>
                <input type="text" id="cuit" name="cuit" value="{{ old('cuit') }}" inputmode="numeric" placeholder="XX-XXXXXXXX-X" />
                @error('cuit') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend>Documento y contacto</legend>
            <div class="form-grid">
              <div class="form-field">
                <label for="tipo_documento_id">Tipo de documento</label>
                <select id="tipo_documento_id" name="tipo_documento_id" required>
                  <option value="" disabled @selected(! old('tipo_documento_id'))>Seleccionar</option>
                  @foreach($tiposDocumento ?? [] as $tipoDocumento)
                    <option value="{{ $tipoDocumento->id }}" @selected(old('tipo_documento_id') == $tipoDocumento->id)>{{ $tipoDocumento->descripcion }}</option>
                  @endforeach
</select>
                @error('tipo_documento_id') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="numero_documento">Número de documento</label>
                <input type="text" id="numero_documento" name="numero_documento" value="{{ old('numero_documento') }}" required />
                @error('numero_documento') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="telefono">Teléfono</label>
                <input type="tel" id="telefono" name="telefono" value="{{ old('telefono') }}" autocomplete="tel" required />
                @error('telefono') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="email_contacto">Email de contacto</label>
                <input type="email" id="email_contacto" name="email_contacto" value="{{ old('email_contacto') }}" autocomplete="email" required />
                @error('email_contacto') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
            </div>
          </fieldset>

          <fieldset>
            <legend>Dirección</legend>
            <div class="form-grid">
              <div class="form-field form-field--wide">
                <label for="calle">Calle</label>
                <input type="text" id="calle" name="calle" value="{{ old('calle') }}" autocomplete="street-address" required />
                @error('calle') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="numero">Número</label>
                <input type="text" id="numero" name="numero" value="{{ old('numero') }}" required />
                @error('numero') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="piso">Piso</label>
                <input type="text" id="piso" name="piso" value="{{ old('piso') }}" />
                @error('piso') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="departamento">Departamento</label>
                <input type="text" id="departamento" name="departamento" value="{{ old('departamento') }}" />
                @error('departamento') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="cod_postal">Código postal</label>
                <input type="text" id="cod_postal" name="cod_postal" value="{{ old('cod_postal') }}" />
                @error('cod_postal') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="provincia_id">Provincia</label>
                <select id="provincia_id" name="provincia_id" required>
                  <option value="" disabled @selected(! old('provincia_id'))>Seleccionar</option>
                  @foreach($provincias ?? [] as $provincia)
                    <option value="{{ $provincia->id }}" @selected(old('provincia_id') == $provincia->id)>{{ $provincia->descripcion }}</option>
                  @endforeach
                </select>
                @error('provincia_id') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field">
                <label for="localidad_id">Localidad</label>
                <select id="localidad_id" name="localidad_id" required>
                  <option value="" disabled @selected(! old('localidad_id'))>Seleccionar</option>
                  @foreach($localidades ?? [] as $localidad)
                    <option value="{{ $localidad->id }}" data-provincia="{{ $localidad->provincia_id }}" @selected(old('localidad_id') == $localidad->id)>{{ $localidad->descripcion }}</option>
                  @endforeach
                </select>
                @error('localidad_id') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
              <div class="form-field form-field--wide">
                <label for="referencia">Referencia</label>
                <input type="text" id="referencia" name="referencia" value="{{ old('referencia') }}" />
                @error('referencia') <span class="field-error" style="color:#b00020;font-size:.85rem;">{{ $message }}</span> @enderror
              </div>
            </div>
          </fieldset>

          <div class="form-actions">
            <button class="btn btn--primary" type="submit">Crear cuenta</button>
            <a class="btn btn--secondary" href="{{ route('cuenta') }}">Ya tengo una cuenta</a>
          </div>
        </form>
      </section>
    </main>

    <footer class="footer">
      <div class="footer__inner">
        <p class="footer__brand">AURA CLOTHES</p>
        <p>© 2026 AURA CLOTHES. Todos los derechos reservados.</p>
        <div class="footer__links">
          <a href="{{ route('paginas.terminos') }}">Términos</a>
          <a href="{{ route('paginas.privacidad') }}">Privacidad</a>
        </div>
      </div>
    </footer>

    <script src="{{ asset('js/provincias-localidades.js') }}"></script>
    <script type="module" src="{{ asset('js/registro.js') }}"></script>
    <!-- figma:body-end -->
  </body>
</html>