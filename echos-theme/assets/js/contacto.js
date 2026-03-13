/**
 * Contacto page script.
 * Handles service tabs and form submit placeholder.
 */
(function () {
  'use strict';

  var tabs = Array.prototype.slice.call(document.querySelectorAll('.contacto-tab'));
  var hidden = document.getElementById('contactoServicio');

  function setActiveTab(tab) {
    if (!tab) {
      return;
    }

    tabs.forEach(function (item) {
      item.classList.remove('is-active');
    });

    tab.classList.add('is-active');

    if (hidden) {
      hidden.value = tab.getAttribute('data-service') || '';
    }
  }

  if (tabs.length > 0) {
    var activeTab = tabs.filter(function (tab) {
      return tab.classList.contains('is-active');
    })[0] || tabs[0];

    setActiveTab(activeTab);

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        setActiveTab(tab);
      });
    });
  }

  var form = document.getElementById('contactoForm');
  if (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      // Integrate form submission logic here (AJAX, fetch, plugin, etc.)
      console.log('Formulario de contacto enviado');
    });
  }
})();
