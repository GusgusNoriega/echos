/* -----------------------------
   Hero slider (3 slides)
 ------------------------------ */
const hero = document.getElementById("hero");

// Ahora el slider es scroll horizontal (touch/mouse) con scroll-snap.
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
  // Importante: NO usar scrollIntoView aquí porque puede hacer que el navegador
  // haga scroll vertical de la página para “traer” el slide al viewport.
  // En su lugar, movemos solo el scroll horizontal del contenedor.
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
  // Throttle con rAF para evitar exceso de trabajo.
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
  // Autoplay opcional: solo si no está interactuando.
  timer = window.setInterval(() => {
    if (isUserInteracting) return;
    scrollToSlide(current + 1, "smooth");
  }, 6500);
}

function stop(){
  if (timer) window.clearInterval(timer);
  timer = null;
}

// Dots -> scroll a slide
dots.forEach((dot) => {
  dot.addEventListener("click", () => {
    const idx = Number(dot.dataset.slide);
    scrollToSlide(idx, "smooth");
    start();
  });
});

// Scroll manual (touch/rueda/drag) -> actualizar dots
if (viewport){
  viewport.addEventListener("scroll", onViewportScroll, { passive: true });
  viewport.addEventListener("pointerdown", () => { isUserInteracting = true; });
  viewport.addEventListener("pointerup", () => { isUserInteracting = false; });
  viewport.addEventListener("pointercancel", () => { isUserInteracting = false; });
  viewport.addEventListener("mouseenter", () => { isUserInteracting = true; });
  viewport.addEventListener("mouseleave", () => { isUserInteracting = false; });
}

// init
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
  const step = (card?.offsetWidth || 270) + 16;
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

if (tabs.length && servicio){
  tabs.forEach(t => {
    t.addEventListener("click", () => {
      tabs.forEach(x => x.classList.remove("is-active"));
      t.classList.add("is-active");
      servicio.value = t.dataset.service || t.textContent.trim();
    });
  });
}

/* -----------------------------
   Form submit demo
------------------------------ */
const form = document.getElementById("quoteForm");
if (form){
  form.addEventListener("submit", (e) => {
    e.preventDefault();
    const data = new FormData(form);
    const payload = Object.fromEntries(data.entries());

    // Demo UX: simula envío
    alert(
      `Datos enviados (demo)\n\nServicio: ${payload.servicio}\nNombre: ${payload.nombre}\nEmpresa: ${payload.empresa}\nEmail: ${payload.email}`
    );

    form.reset();
    if (servicio) servicio.value = "Infraestructura";
    tabs.forEach((x,i)=>x.classList.toggle("is-active", i===0));
  });
}
