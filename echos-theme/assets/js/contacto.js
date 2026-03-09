/**
 * Contacto Page — ECHOS
 * Maneja la selección de servicio (tabs) y envío del formulario.
 */
(function () {
  'use strict';

  /* ── Tabs de servicio ── */
  const tabs    = document.querySelectorAll('.contacto-tab');
  const hidden  = document.getElementById('contactoServicio');

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      tabs.forEach(function (t) { t.classList.remove('is-active'); });
      tab.classList.add('is-active');
      if (hidden) {
        hidden.value = tab.getAttribute('data-service');
      }
    });
  });

  /* ── Envío del formulario (placeholder) ── */
  var form = document.getElementById('contactoForm');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      // Aquí se integra la lógica de envío (AJAX, fetch, etc.)
      console.log('Formulario de contacto enviado');
    });
  }
})();
