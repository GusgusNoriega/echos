/**
 * Destacados Slider — proyectos.js
 *
 * Slider de tarjetas para la sección "Los Más Destacados".
 * Desktop: 2 cards visibles, avanza de 2 en 2.
 * Mobile (≤768px): 1 card visible, avanza de 1 en 1.
 */
(function () {
  'use strict';

  const track   = document.querySelector('.destacados__track');
  const cards   = document.querySelectorAll('.destacados__card');
  const prevBtn = document.querySelector('.destacados__arrow--prev');
  const nextBtn = document.querySelector('.destacados__arrow--next');
  const dotsBox = document.querySelector('.destacados__dots');

  if (!track || cards.length === 0) return;

  let currentPage  = 0;
  let perPage       = 2;
  let totalPages    = 1;
  let gap           = 24;

  /* ---- helpers ---- */

  /** Recalcula perPage, gap y totalPages según el viewport */
  function measure() {
    const isMobile = window.matchMedia('(max-width: 768px)').matches;
    perPage    = isMobile ? 1 : 2;
    gap        = isMobile ? 16 : 24;
    totalPages = Math.ceil(cards.length / perPage);

    // Clamp la página actual
    if (currentPage >= totalPages) currentPage = totalPages - 1;
  }

  /** Genera los dots según totalPages */
  function renderDots() {
    dotsBox.innerHTML = '';
    for (let i = 0; i < totalPages; i++) {
      const dot = document.createElement('button');
      dot.className = 'destacados__dot' + (i === currentPage ? ' is-active' : '');
      dot.setAttribute('type', 'button');
      dot.setAttribute('aria-label', 'Ir a la página ' + (i + 1));
      dot.addEventListener('click', function () {
        goTo(i);
      });
      dotsBox.appendChild(dot);
    }
  }

  /** Actualiza la clase activa de los dots */
  function updateDots() {
    const dots = dotsBox.querySelectorAll('.destacados__dot');
    dots.forEach(function (d, i) {
      d.classList.toggle('is-active', i === currentPage);
    });
  }

  /** Actualiza el estilo de las flechas */
  function updateArrows() {
    if (prevBtn) {
      prevBtn.style.color = currentPage === 0 ? '#b0b0b0' : '';
    }
    if (nextBtn) {
      nextBtn.style.color = currentPage === totalPages - 1 ? '#b0b0b0' : '';
    }
  }

  /** Mueve el track a la página indicada */
  function goTo(page) {
    if (page < 0 || page >= totalPages) return;
    currentPage = page;

    // Ancho de una card (sin gap)
    const viewportWidth = track.parentElement.offsetWidth;
    const cardWidth     = (viewportWidth - gap * (perPage - 1)) / perPage;
    const offset        = currentPage * perPage * (cardWidth + gap);

    track.style.transform = 'translateX(-' + offset + 'px)';
    updateDots();
    updateArrows();
  }

  /* ---- events ---- */

  if (prevBtn) {
    prevBtn.addEventListener('click', function () {
      goTo(currentPage - 1);
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', function () {
      goTo(currentPage + 1);
    });
  }

  /* ---- Touch / swipe support ---- */
  let startX = 0;
  let isDragging = false;

  track.addEventListener('touchstart', function (e) {
    startX = e.touches[0].clientX;
    isDragging = true;
  }, { passive: true });

  track.addEventListener('touchend', function (e) {
    if (!isDragging) return;
    isDragging = false;
    const diff = e.changedTouches[0].clientX - startX;
    if (Math.abs(diff) > 50) {
      if (diff < 0) goTo(currentPage + 1);
      else          goTo(currentPage - 1);
    }
  }, { passive: true });

  /* ---- Init & resize ---- */

  function init() {
    measure();
    renderDots();
    goTo(currentPage);
  }

  init();

  let resizeTimer;
  window.addEventListener('resize', function () {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(init, 150);
  });
})();

/**
 * Últimos Proyectos — Filtros
 *
 * Filtra las tarjetas de la sección "Últimos Proyectos"
 * según la categoría seleccionada en los botones.
 */
(function () {
  'use strict';

  const filterBtns = document.querySelectorAll('.ultimos-proyectos__filter');
  const cards      = document.querySelectorAll('.up-card');

  if (!filterBtns.length || !cards.length) return;

  /**
   * Filtra las cards según la categoría dada.
   * @param {string} category — valor del data-filter del botón
   */
  function filterCards(category) {
    cards.forEach(function (card) {
      const cardCat = card.getAttribute('data-category');

      if (category === 'todos' || cardCat === category) {
        card.classList.remove('is-hidden');
        card.classList.add('is-showing');

        // Quitar la clase de animación al finalizar
        card.addEventListener('animationend', function handler() {
          card.classList.remove('is-showing');
          card.removeEventListener('animationend', handler);
        });
      } else {
        card.classList.add('is-hidden');
        card.classList.remove('is-showing');
      }
    });
  }

  /**
   * Actualiza el estado activo de los botones de filtro.
   * @param {HTMLElement} activeBtn — el botón que fue clickeado
   */
  function setActiveFilter(activeBtn) {
    filterBtns.forEach(function (btn) {
      btn.classList.remove('is-active');
    });
    activeBtn.classList.add('is-active');
  }

  // Eventos de click en cada botón
  filterBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      const filter = btn.getAttribute('data-filter');
      setActiveFilter(btn);
      filterCards(filter);
    });
  });
})();
