<!doctype html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Usuarios — Panel de Administración — AURA CLOTHES</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&family=Roboto:wght@400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/estilos_vista_admin/panel_productos_admin.css') }}" />
  </head>
  <body>

    @include('partials.admin_header')

    <main class="section admin-container">
      <h1 class="page-title">Gestión de Usuarios y Personal</h1>

      @if (session('success'))
        <div style="background:#e6f4ea;color:#1e4620;padding:1rem;border-radius:4px;margin-bottom:1.5rem;">
          {{ session('success') }}
        </div>
      @endif

      @if (session('error'))
        <div style="background:#fce8e6;color:#b00020;padding:1rem;border-radius:4px;margin-bottom:1.5rem;">
          {{ session('error') }}
        </div>
      @endif

      @if ($errors->any())
        <div style="background:#fce8e6;color:#b00020;padding:1rem;border-radius:4px;margin-bottom:1.5rem;">
          <ul style="margin:0;padding-left:1.2rem;">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="admin-grid" style="grid-template-columns: 1fr 2fr; gap: 2rem;">
        {{-- Formulario para crear nuevo usuario / empleado --}}
        <section class="admin-card">
          <h2 class="card-title">Nuevo Usuario o Personal</h2>
          <form method="POST" action="{{ route('panel_usuarios_admin.store') }}" class="admin-form">
            @csrf
            <div class="form-group">
              <label for="name">Nombre de usuario *</label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="usuario123" />
            </div>

            <div class="form-group">
              <label for="email">Correo electrónico *</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="correo@ejemplo.com" />
            </div>

            <div class="form-group">
              <label for="password">Contraseña *</label>
              <input type="password" id="password" name="password" required placeholder="Mínimo 8 caracteres" />
            </div>

            <div class="form-group">
              <label for="rol_id">Rol asignado *</label>
              <select id="rol_id" name="rol_id" required>
                @foreach ($roles as $rol)
                  <option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
                    {{ $rol->nombre_rol }} (Nivel {{ $rol->nivel_permiso }})
                  </option>
                @endforeach
              </select>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" placeholder="Opcional" />
              </div>
              <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" value="{{ old('apellido') }}" placeholder="Opcional" />
              </div>
            </div>

            <button type="submit" class="btn btn--primary" style="margin-top:1rem;width:100%;">Crear Usuario</button>
          </form>
        </section>

        {{-- Listado de usuarios --}}
        <section class="admin-card">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1rem;flex-wrap:wrap;gap:1rem;">
            <h2 class="card-title" style="margin:0;">Usuarios registrados ({{ $usuarios->total() }})</h2>

            <form method="GET" action="{{ route('panel_usuarios_admin') }}" style="display:flex;gap:0.5rem;align-items:center;">
              <input type="text" name="q" value="{{ $filtros['q'] }}" placeholder="Buscar nombre o correo..." style="padding:0.4rem;border:1px solid #ccc;border-radius:4px;" />
              <select name="rol_id" style="padding:0.4rem;border:1px solid #ccc;border-radius:4px;">
                <option value="">Todos los roles</option>
                @foreach ($roles as $rol)
                  <option value="{{ $rol->id }}" {{ $filtros['rol_id'] == $rol->id ? 'selected' : '' }}>{{ $rol->nombre_rol }}</option>
                @endforeach
              </select>
              <button type="submit" class="btn btn--primary" style="padding:0.4rem 0.8rem;">Filtrar</button>
              <a href="{{ route('panel_usuarios_admin') }}" class="btn btn--secondary" style="padding:0.4rem 0.8rem;">Limpiar</a>
            </form>
          </div>

          <table style="width:100%;border-collapse:collapse;font-size:0.9rem;">
            <thead>
              <tr style="border-bottom:2px solid #ddd;text-align:left;">
                <th style="padding:0.6rem;">ID</th>
                <th style="padding:0.6rem;">Usuario / Nombre</th>
                <th style="padding:0.6rem;">Email</th>
                <th style="padding:0.6rem;">Rol actual</th>
                <th style="padding:0.6rem;">Estado</th>
                <th style="padding:0.6rem;text-align:right;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($usuarios as $u)
                <tr style="border-bottom:1px solid #eee;">
                  <td style="padding:0.6rem;">{{ $u->id }}</td>
                  <td style="padding:0.6rem;">
                    <strong>{{ $u->name }}</strong><br>
                    <small style="color:#666;">{{ $u->contacto?->nombre_completo ?? 'Sin contacto' }}</small>
                  </td>
                  <td style="padding:0.6rem;">{{ $u->email }}</td>
                  <td style="padding:0.6rem;">
                    <form method="POST" action="{{ route('panel_usuarios_admin.rol', $u) }}" style="display:inline-flex;gap:0.3rem;align-items:center;">
                      @csrf
                      @method('PATCH')
                      <select name="rol_id" onchange="this.form.submit()" style="padding:0.25rem 0.4rem;border:1px solid #ccc;border-radius:4px;font-size:0.85rem;">
                        @foreach ($roles as $rol)
                          <option value="{{ $rol->id }}" {{ $u->roles->contains($rol->id) ? 'selected' : '' }}>
                            {{ $rol->nombre_rol }}
                          </option>
                        @endforeach
                      </select>
                    </form>
                  </td>
                  <td style="padding:0.6rem;">
                    @if ($u->activo)
                      <span style="background:#e6f4ea;color:#1e4620;padding:0.2rem 0.5rem;border-radius:4px;font-size:0.8rem;">Activo</span>
                    @else
                      <span style="background:#fce8e6;color:#b00020;padding:0.2rem 0.5rem;border-radius:4px;font-size:0.8rem;">Inactivo</span>
                    @endif
                  </td>
                  <td style="padding:0.6rem;text-align:right;">
                    @if ($u->id !== auth()->id())
                      <form method="POST" action="{{ route('panel_usuarios_admin.activo', $u) }}" style="display:inline;" onsubmit="return confirm('¿Seguro que querés cambiar el estado de este usuario?');">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn--outline" style="padding:0.25rem 0.6rem;font-size:0.8rem;color:{{ $u->activo ? '#b00020' : '#1e4620' }};border-color:currentColor;">
                          {{ $u->activo ? 'Desactivar' : 'Activar' }}
                        </button>
                      </form>
                    @else
                      <small style="color:#888;">(Tu cuenta)</small>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="6" style="padding:1rem;text-align:center;color:#666;">No se encontraron usuarios.</td>
                </tr>
              @endforelse
            </tbody>
          </table>

          <div style="margin-top:1.5rem;">
            {{ $usuarios->links() }}
          </div>
        </section>
      </div>
    </main>

  </body>
</html>
