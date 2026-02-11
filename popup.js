/* Popup aislado (prefijo epopup)
   - Se abre automáticamente al entrar (DOMContentLoaded)
   - Cierra por: botón, click en fondo, Escape
   - Bloquea el scroll del body mientras está abierto
*/

(() => {
  const root = document.getElementById("epopup");
  if (!root) return;

  const dialog = root.querySelector(".epopup__dialog");
  const closeTargets = [...root.querySelectorAll("[data-epopup-close]")];
  const form = document.getElementById("epopupForm");

  let lastFocused = null;

  function openPopup(){
    lastFocused = document.activeElement;
    root.classList.add("is-open");
    root.setAttribute("aria-hidden", "false");
    document.body.classList.add("epopup--lock");

    // Enfocar el diálogo (mejor para teclado/lector)
    window.requestAnimationFrame(() => {
      dialog?.focus?.();
    });
  }

  function closePopup(){
    root.classList.remove("is-open");
    root.setAttribute("aria-hidden", "true");
    document.body.classList.remove("epopup--lock");
    if (lastFocused && typeof lastFocused.focus === "function") lastFocused.focus();
  }

  // Click en backdrop o botón X
  closeTargets.forEach((el) => {
    el.addEventListener("click", (e) => {
      e.preventDefault();
      closePopup();
    });
  });

  // Escape
  window.addEventListener("keydown", (e) => {
    if (root.getAttribute("aria-hidden") === "true") return;
    if (e.key === "Escape"){
      e.preventDefault();
      closePopup();
    }
  });

  // Envío (demo): valida y cierra
  form?.addEventListener("submit", (e) => {
    e.preventDefault();

    const empresa = form.querySelector('input[name="empresa"]');
    const email = form.querySelector('input[name="email"]');

    const ok = !!empresa?.value?.trim() && !!email?.value?.trim();
    if (!ok){
      // Usar validación nativa si está disponible
      form.reportValidity?.();
      return;
    }

    // UX demo (sin back-end)
    alert("¡Gracias! Te enviaremos tu descuento.");
    form.reset();
    closePopup();
  });

  // Abrir automáticamente al entrar a la página
  window.addEventListener("DOMContentLoaded", () => {
    openPopup();
  });
})();

