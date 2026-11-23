<header class="topbar">
  <div class="topbar__inner">
    <button class="icon-btn icon-btn--search" type="button" aria-label="Buscar productos">
      <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="7"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
      <span class="icon-btn__label">Buscar</span>
    </button>

    <a class="logo" href="{{ route('inicio') }}" aria-label="AURA CLOTHES, ir al inicio">
      <span class="logo__mark">AC</span>
      <span class="logo__word">AURA CLOTHES</span>
    </a>

    <div class="topbar__actions">
      @guest
        <a class="icon-btn" href="{{ route('cuenta') }}" aria-label="Mi cuenta">
          <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"></path></svg>
          <span class="icon-btn__label">Cuenta</span>
        </a>
      @endguest

    @auth
      @if (auth()->user()?->tieneNivel(50))
        <a class="icon-btn" href="{{ route('panel_productos_admin') }}" aria-label="Panel de administración">
          <span class="icon-btn__label">Panel</span>
        </a>
      @endif

      <a class="icon-btn" href="{{ route('mi-cuenta') }}" aria-label="Mi cuenta">
        <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="8" r="4"></circle><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"></path></svg>
        <span class="icon-btn__label">Mi cuenta</span>
      </a>

      <span class="icon-btn__label">{{ auth()->user()->name }}</span>
      <form method="POST" action="{{ route('sesion.cerrar') }}" style="display:inline;">
        @csrf
        <button type="submit" class="icon-btn">Cerrar sesión</button>
      </form>
    @endauth

      <a class="icon-btn" href="{{ route('carrito') }}" aria-label="Ver carrito">
        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16l-1.5 10.5a2 2 0 0 1-2 1.5H7.5a2 2 0 0 1-2-1.5L4 6z"></path><path d="M8 6V5a4 4 0 0 1 8 0v1"></path></svg>
        <span class="icon-btn__label">Carrito</span>
      </a>
    </div>
  </div>

<nav class="mainnav" aria-label="Navegación principal">
  <ul class="mainnav__list">
    <li><a class="mainnav__link" href="{{ route('inicio') }}">Inicio</a></li>
    <li><a class="mainnav__link" href="{{ route('nuevo') }}">Nuevo</a></li>
    <li><a class="mainnav__link" href="{{ route('productos') }}">Productos</a></li>
    <li><a class="mainnav__link" href="{{ route('contacto') }}">Contacto</a></li>
    <li><a class="mainnav__link" href="{{ route('quienes-somos') }}">Quiénes somos</a></li>
  </ul>
</nav>

</header>