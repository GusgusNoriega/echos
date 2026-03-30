(function () {
  "use strict";

  var doc = window.document;

  function getFileName(url) {
    var value = String(url || "").trim();
    if (!value) {
      return "";
    }

    try {
      var parsed = new URL(value, window.location.origin);
      var path = parsed.pathname || "";
      var parts = path.split("/").filter(Boolean);
      return parts.length ? decodeURIComponent(parts[parts.length - 1]) : "";
    } catch (error) {
      var clean = value.split("?")[0].split("#")[0];
      var fallbackParts = clean.split("/").filter(Boolean);
      return fallbackParts.length ? fallbackParts[fallbackParts.length - 1] : "";
    }
  }

  function updateFieldState(field) {
    if (!field) {
      return;
    }

    var input = field.querySelector("[data-product-file-input]");
    var label = field.querySelector("[data-product-file-current]");
    if (!input || !label) {
      return;
    }

    var fileName = getFileName(input.value || "");
    if (fileName) {
      label.textContent = "Archivo seleccionado: " + fileName;
      return;
    }

    label.textContent = label.getAttribute("data-empty-label") || "Ningun archivo seleccionado.";
  }

  function openMediaFrame(field) {
    if (!window.wp || !wp.media || !field) {
      return;
    }

    var input = field.querySelector("[data-product-file-input]");
    if (!input) {
      return;
    }

    var frame = wp.media({
      title: (window.echosProductAdmin && window.echosProductAdmin.mediaTitle) || "Seleccionar archivo",
      button: {
        text: (window.echosProductAdmin && window.echosProductAdmin.mediaButton) || "Usar archivo"
      },
      multiple: false
    });

    frame.on("select", function () {
      var selection = frame.state().get("selection").first();
      if (!selection) {
        return;
      }

      var attachment = selection.toJSON();
      input.value = attachment && attachment.url ? attachment.url : "";
      updateFieldState(field);
    });

    frame.open();
  }

  doc.addEventListener("click", function (event) {
    var pickButton = event.target.closest("[data-product-file-pick]");
    if (pickButton) {
      event.preventDefault();
      openMediaFrame(pickButton.closest("[data-product-file-field]"));
      return;
    }

    var clearButton = event.target.closest("[data-product-file-clear]");
    if (clearButton) {
      event.preventDefault();
      var field = clearButton.closest("[data-product-file-field]");
      if (!field) {
        return;
      }

      var input = field.querySelector("[data-product-file-input]");
      if (input) {
        input.value = "";
      }
      updateFieldState(field);
    }
  });

  doc.addEventListener("input", function (event) {
    var input = event.target.closest("[data-product-file-input]");
    if (!input) {
      return;
    }

    updateFieldState(input.closest("[data-product-file-field]"));
  });

  doc.querySelectorAll("[data-product-file-field]").forEach(updateFieldState);
})();
