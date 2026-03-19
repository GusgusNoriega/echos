/* Popup standalone (prefix epopup)
   - Opens on page load (DOMContentLoaded)
   - Closes by button, backdrop click, Escape
   - Locks body scroll while open
*/

(() => {
  const root = document.getElementById("epopup");
  if (!root) return;

  const dialog = root.querySelector(".epopup__dialog");
  const closeTargets = [...root.querySelectorAll("[data-epopup-close]")];
  const form = document.getElementById("epopupForm");
  const submitButton = form ? form.querySelector('button[type="submit"]') : null;

  const config = window.echosFormsConfig || {};
  const ajaxUrl = config.ajaxUrl || "/wp-admin/admin-ajax.php";
  const nonce = config.nonce || "";
  const messages = config.messages || {};
  const formLoading = window.echosFormLoading || null;

  let lastFocused = null;

  function openPopup(){
    lastFocused = document.activeElement;
    root.classList.add("is-open");
    root.setAttribute("aria-hidden", "false");
    document.body.classList.add("epopup--lock");

    window.requestAnimationFrame(() => {
      dialog?.focus?.();
    });
  }

  function closePopup(){
    root.classList.remove("is-open");
    root.setAttribute("aria-hidden", "true");
    document.body.classList.remove("epopup--lock");

    if (lastFocused && typeof lastFocused.focus === "function") {
      lastFocused.focus();
    }
  }

  // Click on backdrop or X button.
  closeTargets.forEach((el) => {
    el.addEventListener("click", (e) => {
      e.preventDefault();
      closePopup();
    });
  });

  // Escape key.
  window.addEventListener("keydown", (e) => {
    if (root.getAttribute("aria-hidden") === "true") return;

    if (e.key === "Escape"){
      e.preventDefault();
      closePopup();
    }
  });

  form?.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (formLoading && formLoading.isLocked()) {
      return;
    }

    if (!form.checkValidity()){
      if (typeof form.reportValidity === "function") {
        form.reportValidity();
      }
      return;
    }

    const data = new FormData(form);
    data.append("action", "echos_submit_form");
    data.append("nonce", nonce);
    data.append("page_url", window.location.href);
    data.append("page_title", document.title || "");

    if (submitButton) {
      submitButton.disabled = true;
    }
    if (formLoading) {
      formLoading.lock();
    }

    try {
      const response = await fetch(ajaxUrl, {
        method: "POST",
        body: data,
        credentials: "same-origin",
      });

      let json = null;
      try {
        json = await response.json();
      } catch (parseError) {
        json = null;
      }

      if (!response.ok || !json || !json.success) {
        const errorMessage = json && json.data && json.data.message
          ? json.data.message
          : (messages.error || "No se pudo enviar el formulario.");
        throw new Error(errorMessage);
      }

      const successMessage = json.data && json.data.message
        ? json.data.message
        : (messages.success || "Formulario enviado correctamente.");

      alert(successMessage);
      form.reset();
      closePopup();
    } catch (error) {
      const fallback = messages.error || "No se pudo enviar el formulario.";
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

  // Open automatically when page finishes loading.
  window.addEventListener("DOMContentLoaded", () => {
    openPopup();
  });
})();

