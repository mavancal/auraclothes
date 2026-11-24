<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mis direcciones — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/productos.css') }}">
  </head>
  <body>

    @include('partials.header')

    <main id="contenido">
      <div class="section">
        <h1 style="font-size:2.2rem;margin:0 0 2rem">Mis direcciones</h1>

        @if (session('success'))
          <p style="color:green;margin-bottom:1rem">{{ session('success') }}</p>
        @endif
        @error('direccion')
          <p style="color:red;margin-bottom:1rem">{{ $message }}</p>
        @enderror

        {{-- Listado --}}
        <h2 style="font-size:1.2rem;margin-bottom:1rem">Direcciones guardadas</h2>
        @if ($direcciones->isEmpty())
          <p class="empty-msg">No tenés direcciones guardadas.</p>
        @else
          <ul class="product-grid" style="grid-template-columns:1fr">
            @foreach ($direcciones as $direccion)
              <li class="product-card" style="padding:1rem">
                <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:0.5rem">
                  <p class="product-card__name" style="margin:0">
                    {{ $direccion->calle }} {{ $direccion->numero }}{{ $direccion->piso ? ', Piso '.$direccion->piso : '' }}{{ $direccion->departamento ? ' Dpto '.$direccion->departamento : '' }}
                  </p>
                  <div style="display:flex;gap:0.5rem;align-items:center;flex-wrap:wrap">
                    @if ($direccion->es_principal)
                      <span style="background:#e6f4ea;color:#1e4620;padding:0.2rem 0.6rem;border-radius:4px;font-size:0.8rem">Principal</span>
                    @else
                      <form method="POST" action="{{ route('mis-direcciones.principal', $direccion->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="filter-btn">Marcar como principal</button>
                      </form>
                    @endif

                    @if ($direccion->pedidos_exists)
                      <span style="font-size:0.8rem;color:#888" title="Ya se usó en un pedido, por eso no se puede modificar ni eliminar">Usada en pedidos</span>
                    @else
                      <a href="{{ route('mis-direcciones.edit', $direccion->id) }}" class="filter-btn">Editar</a>
                      <form method="POST" action="{{ route('mis-direcciones.destroy', $direccion->id) }}" onsubmit="return confirm('¿Seguro que querés eliminar esta dirección?');" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="filter-btn" style="color:#b00020;">Eliminar</button>
                      </form>
                    @endif
                  </div>
                </div>
                <p style="font-size:0.85rem;margin:0.3rem 0;color:#666">
                  {{ $direccion->localidad->descripcion ?? '' }}{{ $direccion->localidad?->provincia ? ', '.$direccion->localidad->provincia->descripcion : '' }}
                  @if ($direccion->cod_postal) · CP {{ $direccion->cod_postal }} @endif
                </p>
                @if ($direccion->referencia)
                  <p style="font-size:0.8rem;color:#888;margin:0.2rem 0">Ref: {{ $direccion->referencia }}</p>
                @endif
              </li>
            @endforeach
          </ul>
        @endif

        {{-- Formulario para agregar --}}
        <h2 style="font-size:1.2rem;margin:2rem 0 1rem">Agregar nueva dirección</h2>
        <form method="POST" action="{{ route('mis-direcciones.store') }}" style="max-width:600px">
          @csrf

          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Provincia</label>
              <select name="provincia_id" class="sort-select" style="width:100%" required>
                <option value="">Seleccioná</option>
                @foreach ($provincias as $provincia)
                  <option value="{{ $provincia->id }}" {{ old('provincia_id') == $provincia->id ? 'selected' : '' }}>{{ $provincia->descripcion }}</option>
                @endforeach
              </select>
              @error('provincia_id') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>

            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Localidad</label>
              <select name="localidad_id" class="sort-select" style="width:100%" required>
                <option value="">Seleccioná</option>
                @foreach ($localidades as $localidad)
                  <option value="{{ $localidad->id }}" data-provincia="{{ $localidad->provincia_id }}" {{ old('localidad_id') == $localidad->id ? 'selected' : '' }}>{{ $localidad->descripcion }}</option>
                @endforeach
              </select>
              @error('localidad_id') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>
          </div>

          <div style="display:grid;grid-template-columns:2fr 1fr;gap:1rem;margin-top:0.8rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Calle</label>
              <input type="text" name="calle" value="{{ old('calle') }}" class="sort-select" style="width:100%" required>
              @error('calle') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Número</label>
              <input type="text" name="numero" value="{{ old('numero') }}" class="sort-select" style="width:100%" required>
              @error('numero') <span style="color:red;font-size:0.8rem">{{ $message }}</span> @enderror
            </div>
          </div>

          <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;margin-top:0.8rem">
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Piso</label>
              <input type="text" name="piso" value="{{ old('piso') }}" class="sort-select" style="width:100%">
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Dpto</label>
              <input type="text" name="departamento" value="{{ old('departamento') }}" class="sort-select" style="width:100%">
            </div>
            <div class="form-field">
              <label style="display:block;margin-bottom:0.3rem;font-weight:600">Código postal</label>
              <input type="text" name="cod_postal" value="{{ old('cod_postal') }}" class="sort-select" style="width:100%">
            </div>
          </div>

          <div class="form-field" style="margin-top:0.8rem">
            <label style="display:block;margin-bottom:0.3rem;font-weight:600">Referencia</label>
            <input type="text" name="referencia" value="{{ old('referencia') }}" class="sort-select" style="width:100%">
          </div>

          <div class="form-field" style="margin-top:0.8rem">
            <label style="display:flex;align-items:center;gap:0.4rem">
              <input type="checkbox" name="es_principal" value="1" {{ old('es_principal') ? 'checked' : '' }}>
              Marcar como dirección principal
            </label>
          </div>

          <button type="submit" class="filter-btn is-active" style="margin-top:1rem">Agregar dirección</button>
        </form>
      </div>
    </main>

    @include('partials.footer')
    <script src="{{ asset('js/provincias-localidades.js') }}"></script>
  </body>
</html>