/*
 * Global fullscreen loader for form submissions.
 * Blocks interactions while a form request is in progress.
 * Also persists URL UTM params and injects them into form submissions.
 */
(function () {
  "use strict";

  if (window.echosFormLoading) {
    return;
  }

  var OVERLAY_ID = "echosFormLoader";
  var UTM_STORAGE_KEY = "echos_form_utm_data";
  var UTM_FIELD_NAME = "utm_data";
  var UTM_PREFIX = "utm_";
  var FORM_SOURCE_SELECTOR = 'input[name="form_source"]';
  var lockCount = 0;
  var activeUtmData = {};

  function createOverlay() {
    if (!document.body) {
      return null;
    }

    var existing = document.getElementById(OVERLAY_ID);
    if (existing) {
      return existing;
    }

    var overlay = document.createElement("div");
    overlay.id = OVERLAY_ID;
    overlay.className = "echos-form-loader";
    overlay.setAttribute("aria-hidden", "true");

    var spinner = document.createElement("div");
    spinner.className = "echos-form-loader__spinner";
    spinner.setAttribute("aria-hidden", "true");

    var label = document.createElement("div");
    label.className = "echos-form-loader__label";
    label.textContent = "Enviando...";

    overlay.appendChild(spinner);
    overlay.appendChild(label);
    document.body.appendChild(overlay);

    return overlay;
  }

  function getOverlay() {
    return document.getElementById(OVERLAY_ID) || createOverlay();
  }

  function setActive(active) {
    var overlay = getOverlay();
    if (!overlay) {
      return;
    }

    if (active) {
      overlay.classList.add("is-active");
      overlay.setAttribute("aria-hidden", "false");
      document.documentElement.classList.add("echos-form-loader-open");
      document.body.classList.add("echos-form-loader-open");
      return;
    }

    overlay.classList.remove("is-active");
    overlay.setAttribute("aria-hidden", "true");
    document.documentElement.classList.remove("echos-form-loader-open");
    document.body.classList.remove("echos-form-loader-open");
  }

  function lock() {
    lockCount += 1;
    setActive(true);
  }

  function unlock() {
    lockCount = Math.max(0, lockCount - 1);
    if (lockCount === 0) {
      setActive(false);
    }
  }

  function isLocked() {
    return lockCount > 0;
  }

  function sanitizeUtmValue(value) {
    if (typeof value !== "string" && typeof value !== "number" && typeof value !== "boolean") {
      return "";
    }

    return String(value).trim().slice(0, 512);
  }

  function hasUtmData(data) {
    return !!data && Object.keys(data).length > 0;
  }

  function copyUtmData(data) {
    var copy = {};

    if (!data || typeof data !== "object") {
      return copy;
    }

    Object.keys(data).forEach(function (key) {
      var normalizedKey = String(key || "").trim().toLowerCase();
      if (normalizedKey.indexOf(UTM_PREFIX) !== 0) {
        return;
      }

      var normalizedValue = sanitizeUtmValue(data[key]);
      if (!normalizedValue) {
        return;
      }

      copy[normalizedKey] = normalizedValue;
    });

    return copy;
  }

  function getStoredUtmData() {
    var raw = "";

    try {
      raw = window.localStorage.getItem(UTM_STORAGE_KEY) || "";
    } catch (error) {
      return {};
    }

    if (!raw) {
      return {};
    }

    try {
      return copyUtmData(JSON.parse(raw));
    } catch (error) {
      return {};
    }
  }

  function getCurrentUrlUtmData() {
    var params;
    var data = {};

    try {
      params = new URLSearchParams(window.location.search || "");
    } catch (error) {
      return data;
    }

    params.forEach(function (value, key) {
      var normalizedKey = String(key || "").trim().toLowerCase();
      if (normalizedKey.indexOf(UTM_PREFIX) !== 0) {
        return;
      }

      var normalizedValue = sanitizeUtmValue(value);
      if (!normalizedValue) {
        return;
      }

      data[normalizedKey] = normalizedValue;
    });

    return data;
  }

  function persistUtmData(data) {
    try {
      if (!hasUtmData(data)) {
        window.localStorage.removeItem(UTM_STORAGE_KEY);
        return;
      }

      window.localStorage.setItem(UTM_STORAGE_KEY, JSON.stringify(copyUtmData(data)));
    } catch (error) {
      // localStorage can fail in some browser privacy modes.
    }
  }

  function refreshUtmData() {
    var currentUrlUtmData = getCurrentUrlUtmData();

    if (hasUtmData(currentUrlUtmData)) {
      activeUtmData = currentUrlUtmData;
      persistUtmData(activeUtmData);
      return activeUtmData;
    }

    activeUtmData = getStoredUtmData();
    return activeUtmData;
  }

  function serializeUtmData(data) {
    var sanitized = copyUtmData(data);
    if (!hasUtmData(sanitized)) {
      return "";
    }

    var params = new URLSearchParams();
    Object.keys(sanitized).sort().forEach(function (key) {
      params.set(key, sanitized[key]);
    });

    return params.toString();
  }

  function shouldHydrateForm(form) {
    if (!form || typeof form.querySelector !== "function") {
      return false;
    }

    return !!form.querySelector(FORM_SOURCE_SELECTOR);
  }

  function setUtmFieldValue(form) {
    if (!shouldHydrateForm(form)) {
      return;
    }

    var fieldSelector = 'input[name="' + UTM_FIELD_NAME + '"]';
    var field = form.querySelector(fieldSelector);
    var serializedUtmData = serializeUtmData(activeUtmData);

    if (!serializedUtmData) {
      if (field && field.parentNode) {
        field.parentNode.removeChild(field);
      }
      return;
    }

    if (!field) {
      field = document.createElement("input");
      field.type = "hidden";
      field.name = UTM_FIELD_NAME;
      form.appendChild(field);
    }

    field.value = serializedUtmData;
  }

  function hydrateTrackedForms() {
    var forms = document.querySelectorAll("form");
    if (!forms || forms.length === 0) {
      return;
    }

    Array.prototype.forEach.call(forms, function (form) {
      setUtmFieldValue(form);
    });
  }

  function onFormSubmitCapture(event) {
    var form = event && event.target;
    if (!form || !form.tagName || form.tagName.toUpperCase() !== "FORM") {
      return;
    }

    refreshUtmData();
    setUtmFieldValue(form);
  }

  function initUtmTracking() {
    refreshUtmData();
    hydrateTrackedForms();
    document.addEventListener("submit", onFormSubmitCapture, true);
  }

  window.echosFormLoading = {
    lock: lock,
    unlock: unlock,
    isLocked: isLocked,
  };

  window.echosFormUtm = {
    getData: function () {
      refreshUtmData();
      return copyUtmData(activeUtmData);
    },
    getSerialized: function () {
      refreshUtmData();
      return serializeUtmData(activeUtmData);
    },
    hydrateForm: function (form) {
      refreshUtmData();
      setUtmFieldValue(form);
    },
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", function () {
      createOverlay();
      initUtmTracking();
    });
  } else {
    createOverlay();
    initUtmTracking();
  }
})();
