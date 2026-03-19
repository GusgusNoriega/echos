/*
 * Global fullscreen loader for form submissions.
 * Blocks interactions while a form request is in progress.
 */
(function () {
  "use strict";

  if (window.echosFormLoading) {
    return;
  }

  var OVERLAY_ID = "echosFormLoader";
  var lockCount = 0;

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

  window.echosFormLoading = {
    lock: lock,
    unlock: unlock,
    isLocked: isLocked,
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", createOverlay);
  } else {
    createOverlay();
  }
})();
