document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('form').forEach(form => {
    const provinciaSelect = form.querySelector('select[name="provincia_id"]');
    const localidadSelect = form.querySelector('select[name="localidad_id"]');

    if (!provinciaSelect || !localidadSelect) return;

    const opciones = Array.from(localidadSelect.querySelectorAll('option[data-provincia]'));

    function filtrarLocalidades() {
      const provId = String(provinciaSelect.value);
      let valorActualEsValido = false;

      opciones.forEach(opt => {
        const coincide = provId !== '' && opt.getAttribute('data-provincia') === provId;
        if (coincide) {
          opt.hidden = false;
          opt.disabled = false;
          if (opt.selected) {
            valorActualEsValido = true;
          }
        } else {
          opt.hidden = true;
          opt.disabled = true;
          if (opt.selected) {
            opt.selected = false;
          }
        }
      });

      if (!valorActualEsValido && provId !== '') {
        const primeraValida = opciones.find(opt => opt.getAttribute('data-provincia') === provId);
        // Si no hay seleccionada válida, dejamos la opción vacía inicial si existe
        const defaultOpt = localidadSelect.querySelector('option[value=""]');
        if (defaultOpt) {
          defaultOpt.selected = true;
        }
      }
    }

    provinciaSelect.addEventListener('change', () => {
      filtrarLocalidades();
    });

    // Ejecutar al cargar la página para aplicar el filtro inicial si ya hay provincia seleccionada
    filtrarLocalidades();
  });
});
