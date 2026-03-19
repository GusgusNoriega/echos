/**
 * Contact page script.
 * Handles service tabs and AJAX submit.
 */
(function () {
  'use strict';

  var tabs = Array.prototype.slice.call(document.querySelectorAll('.contacto-tab'));
  var hidden = document.getElementById('contactoServicio');
  var serviceTitle = document.querySelector('[data-contact-service-title]');
  var serviceDescription = document.querySelector('[data-contact-service-description]');
  var defaultServiceTitle = serviceTitle ? serviceTitle.textContent.trim() : '';
  var defaultServiceDescription = serviceDescription ? serviceDescription.textContent.trim() : '';

  function setActiveTab(tab) {
    if (!tab) {
      return;
    }

    tabs.forEach(function (item) {
      item.classList.remove('is-active');
    });

    tab.classList.add('is-active');

    if (hidden) {
      hidden.value = tab.getAttribute('data-service') || tab.textContent.trim();
    }

    if (serviceTitle) {
      serviceTitle.textContent = tab.getAttribute('data-service-title') || defaultServiceTitle;
    }

    if (serviceDescription) {
      serviceDescription.textContent = tab.getAttribute('data-service-description') || defaultServiceDescription;
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
  if (!form) {
    return;
  }

  var config = window.echosFormsConfig || {};
  var ajaxUrl = config.ajaxUrl || '/wp-admin/admin-ajax.php';
  var nonce = config.nonce || '';
  var messages = config.messages || {};
  var submitButton = form.querySelector('button[type="submit"]');
  var formLoading = window.echosFormLoading || null;

  form.addEventListener('submit', async function (event) {
    event.preventDefault();

    if (formLoading && formLoading.isLocked()) {
      return;
    }

    if (!form.checkValidity()) {
      if (typeof form.reportValidity === 'function') {
        form.reportValidity();
      }
      return;
    }

    var data = new FormData(form);
    data.append('action', 'echos_submit_form');
    data.append('nonce', nonce);
    data.append('page_url', window.location.href);
    data.append('page_title', document.title || '');

    if (submitButton) {
      submitButton.disabled = true;
    }
    if (formLoading) {
      formLoading.lock();
    }

    try {
      var response = await fetch(ajaxUrl, {
        method: 'POST',
        body: data,
        credentials: 'same-origin'
      });

      var json = null;
      try {
        json = await response.json();
      } catch (parseError) {
        json = null;
      }

      if (!response.ok || !json || !json.success) {
        var errorMessage = json && json.data && json.data.message
          ? json.data.message
          : (messages.error || 'No se pudo enviar el formulario.');
        throw new Error(errorMessage);
      }

      var successMessage = json.data && json.data.message
        ? json.data.message
        : (messages.success || 'Formulario enviado correctamente.');

      alert(successMessage);
      form.reset();

      if (tabs.length > 0) {
        setActiveTab(tabs[0]);
      }
    } catch (error) {
      var fallback = messages.error || 'No se pudo enviar el formulario.';
      alert(error && error.message ? error.message : fallback);
    } finally {
      if (formLoading) {
        formLoading.unlock();
      }
      if (submitButton) {
        submitButton.disabled = false;
      }
    }
  });
})();

