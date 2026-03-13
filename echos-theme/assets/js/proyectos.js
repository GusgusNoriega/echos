/**
 * Destacados slider.
 * Desktop: 2 cards per page.
 * Mobile (<= 768px): 1 card per page.
 */
(function () {
  'use strict';

  const track = document.querySelector('.destacados__track');
  const cards = document.querySelectorAll('.destacados__card');
  const prevBtn = document.querySelector('.destacados__arrow--prev');
  const nextBtn = document.querySelector('.destacados__arrow--next');
  const dotsBox = document.querySelector('.destacados__dots');

  if (!track || cards.length === 0) return;

  let currentPage = 0;
  let perPage = 2;
  let totalPages = 1;
  let gap = 24;

  function measure() {
    const isMobile = window.matchMedia('(max-width: 768px)').matches;
    perPage = isMobile ? 1 : 2;
    gap = isMobile ? 16 : 24;
    totalPages = Math.ceil(cards.length / perPage);

    if (currentPage >= totalPages) currentPage = totalPages - 1;
  }

  function renderDots() {
    if (!dotsBox) return;

    dotsBox.innerHTML = '';
    for (let i = 0; i < totalPages; i++) {
      const dot = document.createElement('button');
      dot.className = 'destacados__dot' + (i === currentPage ? ' is-active' : '');
      dot.setAttribute('type', 'button');
      dot.setAttribute('aria-label', 'Ir a la pagina ' + (i + 1));
      dot.addEventListener('click', function () {
        goTo(i);
      });
      dotsBox.appendChild(dot);
    }
  }

  function updateDots() {
    if (!dotsBox) return;

    const dots = dotsBox.querySelectorAll('.destacados__dot');
    dots.forEach(function (dot, index) {
      dot.classList.toggle('is-active', index === currentPage);
    });
  }

  function updateArrows() {
    if (prevBtn) {
      prevBtn.style.color = currentPage === 0 ? '#b0b0b0' : '';
    }
    if (nextBtn) {
      nextBtn.style.color = currentPage === totalPages - 1 ? '#b0b0b0' : '';
    }
  }

  function goTo(page) {
    if (page < 0 || page >= totalPages) return;

    currentPage = page;

    const viewportWidth = track.parentElement.offsetWidth;
    const cardWidth = (viewportWidth - gap * (perPage - 1)) / perPage;
    const offset = currentPage * perPage * (cardWidth + gap);

    track.style.transform = 'translateX(-' + offset + 'px)';

    updateDots();
    updateArrows();
  }

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

  let startX = 0;
  let isDragging = false;

  track.addEventListener(
    'touchstart',
    function (event) {
      startX = event.touches[0].clientX;
      isDragging = true;
    },
    { passive: true }
  );

  track.addEventListener(
    'touchend',
    function (event) {
      if (!isDragging) return;

      isDragging = false;
      const diff = event.changedTouches[0].clientX - startX;
      if (Math.abs(diff) > 50) {
        if (diff < 0) goTo(currentPage + 1);
        else goTo(currentPage - 1);
      }
    },
    { passive: true }
  );

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
 * Legacy client-side filters.
 * Runs only if filter controls are buttons.
 */
(function () {
  'use strict';

  const filterBtns = Array.from(
    document.querySelectorAll('.ultimos-proyectos__filter')
  ).filter(function (element) {
    return element.tagName === 'BUTTON';
  });
  const cards = document.querySelectorAll('.up-card');

  if (!filterBtns.length || !cards.length) return;

  function filterCards(category) {
    cards.forEach(function (card) {
      const cardCat = card.getAttribute('data-category');

      if (category === 'todos' || cardCat === category) {
        card.classList.remove('is-hidden');
        card.classList.add('is-showing');

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

  function setActiveFilter(activeBtn) {
    filterBtns.forEach(function (btn) {
      btn.classList.remove('is-active');
    });
    activeBtn.classList.add('is-active');
  }

  filterBtns.forEach(function (btn) {
    btn.addEventListener('click', function () {
      const filter = btn.getAttribute('data-filter');
      setActiveFilter(btn);
      filterCards(filter);
    });
  });
})();