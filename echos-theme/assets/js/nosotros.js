/**
 * Nosotros — Historia Timeline Slider
 *
 * @package Echos
 */
(function () {
  'use strict';

  /* ── Datos del timeline ── */
  var slides = [
    {
      year: '2018',
      title: 'Lanzamiento de ECHOS',
      desc: 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisi quis mauris viverra. Blandit vestibulum tempus lectus consequ',
    },
    {
      year: '2019',
      title: 'Expansión nacional',
      desc: 'Lorem ipsum dolor sit amet consectetur. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation.',
    },
    {
      year: '2020',
      title: 'Innovación tecnológica',
      desc: 'Lorem ipsum dolor sit amet consectetur. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur excepteur sint.',
    },
    {
      year: '2022',
      title: 'Nuevos servicios',
      desc: 'Lorem ipsum dolor sit amet consectetur. Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum.',
    },
    {
      year: '2024',
      title: 'Liderazgo en el mercado',
      desc: 'Lorem ipsum dolor sit amet consectetur. Ut enim ad minima veniam quis nostrum exercitationem ullam corporis suscipit laboriosam nisi ut aliquid commodi.',
    },
  ];

  var current = 0;

  /* ── Nodos del DOM ── */
  var card      = document.querySelector('.nosotros-historia__card');
  var badge     = document.querySelector('.nosotros-historia__badge');
  var slideTitle = document.querySelector('.nosotros-historia__slide-title');
  var slideDesc  = document.querySelector('.nosotros-historia__slide-desc');
  var prevBtn   = document.querySelector('.nosotros-historia__arrow--prev');
  var nextBtn   = document.querySelector('.nosotros-historia__arrow--next');

  /* Años de fondo */
  var bgPrev = document.querySelector('.nosotros-historia__bg-year--prev');
  var bgNext = document.querySelector('.nosotros-historia__bg-year--next');
  var bgFar  = document.querySelector('.nosotros-historia__bg-year--far');

  if (!card || !prevBtn || !nextBtn) return;

  /* ── Renderizar slide ── */
  function render() {
    var s = slides[current];

    badge.textContent     = s.year;
    slideTitle.textContent = s.title;
    slideDesc.textContent  = s.desc;

    /* Años de fondo */
    bgPrev.textContent = s.year;

    if (current + 1 < slides.length) {
      bgNext.textContent = slides[current + 1].year;
      bgFar.textContent  = current + 2 < slides.length ? slides[current + 2].year : '';
    } else {
      bgNext.textContent = '';
      bgFar.textContent  = '';
    }

    /* Estado botones */
    prevBtn.disabled = current === 0;
    nextBtn.disabled = current === slides.length - 1;

    /* Animación */
    card.classList.remove('is-sliding');
    // forzar reflow
    void card.offsetWidth;
    card.classList.add('is-sliding');
  }

  /* ── Eventos ── */
  prevBtn.addEventListener('click', function () {
    if (current > 0) {
      current--;
      render();
    }
  });

  nextBtn.addEventListener('click', function () {
    if (current < slides.length - 1) {
      current++;
      render();
    }
  });

  /* ── Init ── */
  render();
})();
