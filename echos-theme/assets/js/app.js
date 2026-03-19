/* -----------------------------
   Hero slider (3 slides)
 ------------------------------ */
const hero = document.getElementById("hero");

// Slider now uses horizontal scroll + snap.
const viewport = document.getElementById("heroViewport");
const slides = viewport ? [...viewport.querySelectorAll(".hero__slide")] : [];
const dots = hero ? [...hero.querySelectorAll(".dot")] : [];

let current = 0;
let timer = null;
let isUserInteracting = false;
let raf = 0;

function setActiveDot(index){
  dots.forEach((d) => d.classList.remove("is-active"));
  if (dots[index]) dots[index].classList.add("is-active");
}

function scrollToSlide(index, behavior = "smooth"){
  if (!viewport || !slides.length) return;
  const i = (index + slides.length) % slides.length;
  current = i;

  // Do not use scrollIntoView here because it can move page vertically.
  const left = slides[i].offsetLeft;
  viewport.scrollTo({ left, behavior });
  setActiveDot(i);
}

function getNearestIndex(){
  if (!viewport || !slides.length) return 0;
  const left = viewport.scrollLeft;
  const width = viewport.clientWidth || 1;
  return Math.max(0, Math.min(slides.length - 1, Math.round(left / width)));
}

function onViewportScroll(){
  if (raf) return;
  raf = window.requestAnimationFrame(() => {
    raf = 0;
    const idx = getNearestIndex();
    if (idx !== current){
      current = idx;
      setActiveDot(current);
    }
  });
}

function start(){
  stop();
  timer = window.setInterval(() => {
    if (isUserInteracting) return;
    scrollToSlide(current + 1, "smooth");
  }, 6500);
}

function stop(){
  if (timer) window.clearInterval(timer);
  timer = null;
}

// Dots -> scroll to slide.
dots.forEach((dot) => {
  dot.addEventListener("click", () => {
    const idx = Number(dot.dataset.slide);
    scrollToSlide(idx, "smooth");
    start();
  });
});

// Manual scroll -> update dots.
if (viewport){
  viewport.addEventListener("scroll", onViewportScroll, { passive: true });
  viewport.addEventListener("pointerdown", () => { isUserInteracting = true; });
  viewport.addEventListener("pointerup", () => { isUserInteracting = false; });
  viewport.addEventListener("pointercancel", () => { isUserInteracting = false; });
  viewport.addEventListener("mouseenter", () => { isUserInteracting = true; });
  viewport.addEventListener("mouseleave", () => { isUserInteracting = false; });
}

setActiveDot(0);
start();

/* -----------------------------
   Projects carousel arrows
------------------------------ */
const rail = document.getElementById("projectsRail");
const prev = document.getElementById("projPrev");
const next = document.getElementById("projNext");

function scrollByCard(dir){
  if (!rail) return;
  const card = rail.querySelector(".proj-card");
  const railStyles = window.getComputedStyle(rail);
  const gap = parseFloat(railStyles.columnGap || railStyles.gap || "0") || 0;
  const step = (card?.getBoundingClientRect().width || 270) + gap;
  rail.scrollBy({ left: dir * step, behavior: "smooth" });
}

if (prev && next && rail){
  prev.addEventListener("click", () => scrollByCard(-1));
  next.addEventListener("click", () => scrollByCard(1));
}

/* Optional: drag-to-scroll (desktop) */
let isDown = false;
let startX = 0;
let startLeft = 0;

if (rail){
  rail.addEventListener("mousedown", (e) => {
    isDown = true;
    startX = e.pageX;
    startLeft = rail.scrollLeft;
    rail.classList.add("is-dragging");
  });

  window.addEventListener("mouseup", () => {
    isDown = false;
    rail.classList.remove("is-dragging");
  });

  rail.addEventListener("mousemove", (e) => {
    if (!isDown) return;
    const dx = e.pageX - startX;
    rail.scrollLeft = startLeft - dx;
  });
}

/* -----------------------------
   Contact tabs -> hidden input
------------------------------ */
const tabs = [...document.querySelectorAll(".tab")];
const servicio = document.getElementById("servicioElegido");
const defaultService = tabs[0] ? (tabs[0].dataset.service || tabs[0].textContent.trim()) : "";
const homeServiceTitle = document.querySelector("[data-home-service-title]");
const homeServiceDescription = document.querySelector("[data-home-service-description]");
const defaultServiceTitle = homeServiceTitle ? homeServiceTitle.textContent.trim() : "";
const defaultServiceDescription = homeServiceDescription ? homeServiceDescription.textContent.trim() : "";

function setActiveHomeService(tab){
  if (!tab) return;

  tabs.forEach((x) => x.classList.remove("is-active"));
  tab.classList.add("is-active");

  if (servicio){
    servicio.value = tab.dataset.service || tab.textContent.trim();
  }

  if (homeServiceTitle){
    homeServiceTitle.textContent = tab.dataset.serviceTitle || defaultServiceTitle;
  }

  if (homeServiceDescription){
    homeServiceDescription.textContent = tab.dataset.serviceDescription || defaultServiceDescription;
  }
}

if (tabs.length){
  const activeTab = tabs.find((tab) => tab.classList.contains("is-active")) || tabs[0];
  setActiveHomeService(activeTab);

  tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
      setActiveHomeService(tab);
    });
  });
}

/* -----------------------------
   Form submit (AJAX -> WordPress)
------------------------------ */
const form = document.getElementById("quoteForm");
if (form){
  const config = window.echosFormsConfig || {};
  const ajaxUrl = config.ajaxUrl || "/wp-admin/admin-ajax.php";
  const nonce = config.nonce || "";
  const messages = config.messages || {};
  const submitButton = form.querySelector('button[type="submit"]');
  const formLoading = window.echosFormLoading || null;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    if (formLoading && formLoading.isLocked()){
      return;
    }

    if (!form.checkValidity()){
      if (typeof form.reportValidity === "function"){
        form.reportValidity();
      }
      return;
    }

    const data = new FormData(form);
    data.append("action", "echos_submit_form");
    data.append("nonce", nonce);
    data.append("page_url", window.location.href);
    data.append("page_title", document.title || "");

    if (submitButton){
      submitButton.disabled = true;
    }
    if (formLoading){
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

      if (!response.ok || !json || !json.success){
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
      if (servicio) servicio.value = defaultService;
      if (tabs.length){
        setActiveHomeService(tabs[0]);
      }
    } catch (error) {
      const fallback = messages.error || "No se pudo enviar el formulario.";
      alert(error && error.message ? error.message : fallback);
    } finally {
      if (formLoading){
        formLoading.unlock();
      }
      if (submitButton){
        submitButton.disabled = false;
      }
    }
  });
}

