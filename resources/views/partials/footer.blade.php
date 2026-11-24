<footer class="footer">
  <div class="footer__grid">
    <div>
      <p class="footer__brand">AURA CLOTHES</p>
      <p class="footer__body">Prendas de lana, algodón y lino de uso diario, hechas en talleres pequeños.</p>
    </div>
    <div>
      <h2 class="footer__heading">Navegación</h2>
      <ul class="footer__list">
        <li><a href="{{ route('inicio') }}">Inicio</a></li>
        <li><a href="{{ route('nuevo') }}">Nuevo</a></li>
        <li><a href="{{ route('productos') }}">Productos</a></li>
        <li><a href="{{ route('carrito') }}">Carrito</a></li>
      </ul>
    </div>
    <div>
      <h2 class="footer__heading">Ayuda</h2>
      <ul class="footer__list">
        <li><a href="{{ route('paginas.envios') }}">Envíos y entregas</a></li>
        <li><a href="{{ route('paginas.cambios') }}">Cambios y devoluciones</a></li>
        <li><a href="{{ route('contacto') }}">Contacto</a></li>
        <li><a href="{{ route('quienes-somos') }}">Quiénes somos</a></li>
      </ul>
    </div>
    <div>
      <h2 class="footer__heading">Contacto y Redes</h2>
      <p class="footer__body">Lun a vie 9–18 hs · Sáb 9–13 hs</p>
      <ul class="footer__list footer__list--inline">
        <li><a href="https://instagram.com" target="_blank" rel="noopener noreferrer">Instagram</a></li>
        <li><a href="https://facebook.com" target="_blank" rel="noopener noreferrer">Facebook</a></li>
        <li><a href="https://pinterest.com" target="_blank" rel="noopener noreferrer">Pinterest</a></li>
      </ul>
    </div>
  </div>
  <div class="footer__bottom">
    <p>© 2026 AURA CLOTHES. Todos los derechos reservados.</p>
    <ul class="footer__legal">
      <li><a href="{{ route('paginas.terminos') }}">Términos</a></li>
      <li><a href="{{ route('paginas.privacidad') }}">Privacidad</a></li>
    </ul>
  </div>
</footer>
