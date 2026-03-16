/**
 * Proyecto Individual — Video Player
 *
 * Al hacer clic en el wrapper del video, se inyecta un iframe de YouTube
 * con autoplay y se ocultan la imagen, overlay y botón play.
 *
 * @package Echos
 */
(function () {
  'use strict';

  /**
   * Inicializa todos los wrappers de video en la página.
   */
  function initVideoPlayers() {
    var wrappers = document.querySelectorAll('.proy-ind-video__wrapper[data-video-id]');

    wrappers.forEach(function (wrapper) {
      // Click handler
      wrapper.addEventListener('click', function handleClick() {
        playVideo(wrapper);
        wrapper.removeEventListener('click', handleClick);
      });

      // Accesibilidad: Enter o Space también activan el video
      wrapper.addEventListener('keydown', function handleKey(e) {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          playVideo(wrapper);
          wrapper.removeEventListener('keydown', handleKey);
        }
      });
    });
  }

  /**
   * Inyecta el iframe de YouTube y activa la clase .is-playing.
   *
   * @param {HTMLElement} wrapper - El contenedor .proy-ind-video__wrapper
   */
  function playVideo(wrapper) {
    var videoId = wrapper.getAttribute('data-video-id');
    if (!videoId) return;

    // Crear iframe de YouTube con autoplay
    var iframe = document.createElement('iframe');
    iframe.src =
      'https://www.youtube.com/embed/' +
      videoId +
      '?autoplay=1&rel=0&modestbranding=1';
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute(
      'allow',
      'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture'
    );
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('title', 'Video del proyecto');

    // Agregar clase para ocultar thumbnail / overlay / play
    wrapper.classList.add('is-playing');

    // Insertar iframe
    wrapper.appendChild(iframe);
  }

  // Inicializar cuando el DOM esté listo
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initVideoPlayers);
  } else {
    initVideoPlayers();
  }
})();

/**
 * Conoce Otros Proyectos — Slider
 *
 * Muestra 2 cards en desktop y 1 en móvil (≤520px).
 * Las flechas Anterior/Siguiente desplazan el track.
 *
 * @package Echos
 */
(function () {
  'use strict';

  function initOtrosSlider() {
    var track   = document.querySelector('.proy-ind-otros__track');
    var prevBtn = document.querySelector('.proy-ind-otros__arrow--prev');
    var nextBtn = document.querySelector('.proy-ind-otros__arrow--next');

    if (!track || !prevBtn || !nextBtn) return;

    var cards = track.querySelectorAll('.proy-ind-otros__card');
    if (cards.length === 0) return;

    var currentIndex = 0;

    /**
     * Calcula cuántas cards se ven simultáneamente según el viewport.
     */
    function getVisibleCount() {
      return window.innerWidth <= 520 ? 1 : 2;
    }

    /**
     * Calcula el índice máximo posible.
     */
    function getMaxIndex() {
      var visible = getVisibleCount();
      return Math.max(0, cards.length - visible);
    }

    /**
     * Actualiza la posición del track y el estado de los botones.
     */
    function updateSlider() {
      var visible  = getVisibleCount();
      var maxIndex = getMaxIndex();

      // Corregir currentIndex si sobrepasa el máximo tras un resize
      if (currentIndex > maxIndex) {
        currentIndex = maxIndex;
      }

      // Calcular el desplazamiento
      // El gap entre cards se obtiene del CSS (28px desktop, 16px mobile)
      var gap       = visible === 1 ? 16 : 28;
      var cardWidth = (track.parentElement.offsetWidth - gap * (visible - 1)) / visible;
      var offset    = currentIndex * (cardWidth + gap);

      track.style.transform = 'translateX(-' + offset + 'px)';

      // Estado de botones
      prevBtn.disabled = (currentIndex <= 0);
      nextBtn.disabled = (currentIndex >= maxIndex);
    }

    // Evento: Anterior
    prevBtn.addEventListener('click', function () {
      if (currentIndex > 0) {
        currentIndex--;
        updateSlider();
      }
    });

    // Evento: Siguiente
    nextBtn.addEventListener('click', function () {
      if (currentIndex < getMaxIndex()) {
        currentIndex++;
        updateSlider();
      }
    });

    // Re-calcular al cambiar tamaño de ventana
    var resizeTimer;
    window.addEventListener('resize', function () {
      clearTimeout(resizeTimer);
      resizeTimer = setTimeout(updateSlider, 100);
    });

    // Inicializar
    updateSlider();
  }

  // Arrancar cuando el DOM esté listo
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initOtrosSlider);
  } else {
    initOtrosSlider();
  }
})();

/**
 * Productos utilizados - Reveal on scroll
 *
 * By default each card shows the product image.
 * Desktop: reveal on mouse hover.
 * Mobile: reveal on scroll when each card enters viewport.
 *
 * @package Echos
 */
(function () {
  'use strict';

  function initUsedProductsReveal() {
    var items = document.querySelectorAll('.proy-ind-productos__item');
    if (!items.length) return;

    var hasHoverPointer =
      window.matchMedia &&
      window.matchMedia('(hover: hover) and (pointer: fine)').matches;

    // Desktop: reveal only while the mouse is over the card.
    if (hasHoverPointer) {
      items.forEach(function (item) {
        item.addEventListener('mouseenter', function () {
          item.classList.add('is-revealed');
        });

        item.addEventListener('mouseleave', function () {
          item.classList.remove('is-revealed');
        });
      });

      return;
    }

    // Mobile/tablet: reveal while scrolling page (card entering viewport).
    if (!('IntersectionObserver' in window)) {
      return;
    }

    var observer = new IntersectionObserver(
      function (entries, obs) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;

          if (entry.intersectionRatio >= 0.4) {
            entry.target.classList.add('is-revealed');
            obs.unobserve(entry.target);
          }
        });
      },
      {
        threshold: [0.2, 0.4, 0.65],
        rootMargin: '0px 0px -10% 0px',
      }
    );

    items.forEach(function (item) {
      observer.observe(item);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initUsedProductsReveal);
  } else {
    initUsedProductsReveal();
  }
})();
