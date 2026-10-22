document.addEventListener('DOMContentLoaded', () => {

  // --- Formulario de Productos ---
  const formProducto = document.getElementById('form-producto');
  if (formProducto) {
    formProducto.addEventListener('submit', function(e) {
      e.preventDefault();
      
      const formData = new FormData(this);
      const data = {
        sku: formData.get('sku'),
        nombre: formData.get('nombre'),
        descripcion: formData.get('descripcion'),
        imagen_url: formData.get('imagen_url'),
        precio: parseFloat(formData.get('precio')),
        precio_oferta: formData.get('precio_oferta') ? parseFloat(formData.get('precio_oferta')) : null,
        categoria: formData.get('categoria'),
        coleccion: formData.get('coleccion'),
        activo: formData.get('activo') === 'on' // El checkbox envía 'on' si está marcado
      };

      console.log('Nuevo Producto guardado:', data);
      alert(`Producto "${data.nombre}" guardado con éxito.`);
      this.reset();
    });
  }

  // --- Formulario de Colecciones ---
  const formColeccion = document.getElementById('form-coleccion');
  if (formColeccion) {
    formColeccion.addEventListener('submit', function(e) {
      e.preventDefault();
      const nombreColeccion = new FormData(this).get('nombre_coleccion');
      console.log('Nueva Colección guardada:', nombreColeccion);
      alert(`Colección "${nombreColeccion}" agregada con éxito.`);
      this.reset();
    });
  }

  // --- Formulario de Categorías ---
  const formCategoria = document.getElementById('form-categoria');
  if (formCategoria) {
    formCategoria.addEventListener('submit', function(e) {
      e.preventDefault();
      const nombreCategoria = new FormData(this).get('nombre_categoria');
      console.log('Nueva Categoría guardada:', nombreCategoria);
      alert(`Categoría "${nombreCategoria}" agregada con éxito.`);
      this.reset();
    });
  }
});

// Función simple para el botón de "Salir de la cuenta"
function logout() {
  const confirmar = confirm('¿Estás seguro de que deseas cerrar sesión?');
  if (confirmar) {
    console.log('Sesión cerrada.');
    // En Laravel aquí harías una redirección a una ruta de logout, ej: window.location.href = '/logout';
  }
}