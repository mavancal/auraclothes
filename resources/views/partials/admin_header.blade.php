{{-- Barra superior y menú del panel de administración (se usa en todas las vistas de vistas_admin) --}}
<header class="topbar">
  <div class="topbar__inner">
    <div class="logo" aria-label="AURA CLOTHES, Administración">
      <span class="logo__mark">AC</span>
      <span class="logo__word">ADMINISTRACIÓN</span>
    </div>
    <div class="topbar__actions">
      <span style="margin-right:.75rem;">{{ auth()->user()->name }}</span>
      <form method="POST" action="{{ route('sesion.cerrar') }}" style="display:inline;">
        @csrf
        <button class="btn btn--outline" type="submit">Salir de la cuenta</button>
      </form>
    </div>
  </div>
</header>

<nav class="mainnav" aria-label="Navegación de administración">
  <ul class="mainnav__list">
    <li><a class="mainnav__link" href="{{ route('inicio') }}">Ir a la tienda</a></li>
    <li><a class="mainnav__link {{ request()->routeIs('panel_productos_admin*') ? 'is-active' : '' }}" href="{{ route('panel_productos_admin') }}">Productos</a></li>
    <li><a class="mainnav__link {{ request()->routeIs('panel_pedidos_admin*') ? 'is-active' : '' }}" href="{{ route('panel_pedidos_admin') }}">Pedidos</a></li>
  </ul>
</nav>