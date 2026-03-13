/**
 * Nosotros - Historia timeline slider.
 *
 * @package Echos
 */
(function () {
  'use strict';

  var section = document.querySelector('.nosotros-historia');
  if (!section) {
    return;
  }

  var card = section.querySelector('.nosotros-historia__card');
  var badge = section.querySelector('.nosotros-historia__badge');
  var slideTitle = section.querySelector('.nosotros-historia__slide-title');
  var slideDesc = section.querySelector('.nosotros-historia__slide-desc');
  var prevBtn = section.querySelector('.nosotros-historia__arrow--prev');
  var nextBtn = section.querySelector('.nosotros-historia__arrow--next');
  var bgPrev = section.querySelector('.nosotros-historia__bg-year--prev');
  var bgNext = section.querySelector('.nosotros-historia__bg-year--next');
  var bgFar = section.querySelector('.nosotros-historia__bg-year--far');

  if (!card || !badge || !slideTitle || !slideDesc) {
    return;
  }

  function fallbackSlides() {
    return [
      {
        year: '2018',
        title: 'Lanzamiento de ECHOS',
        description: 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisi quis mauris viverra. Blandit vestibulum tempus lectus consequ.',
      },
      {
        year: '2019',
        title: 'Expansion nacional',
        description: 'Lorem ipsum dolor sit amet consectetur. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation.',
      },
    ];
  }

  function normalizeSlides(rawSlides) {
    if (!Array.isArray(rawSlides)) {
      return [];
    }

    return rawSlides
      .filter(function (slide) {
        return slide && typeof slide === 'object';
      })
      .map(function (slide) {
        return {
          year: String(slide.year || '').trim(),
          title: String(slide.title || '').trim(),
          description: String(slide.description || '').trim(),
        };
      })
      .filter(function (slide) {
        return slide.year !== '' || slide.title !== '' || slide.description !== '';
      });
  }

  function parseSlidesFromDataAttr() {
    var raw = section.getAttribute('data-history-slides');
    if (!raw) {
      return [];
    }

    try {
      return normalizeSlides(JSON.parse(raw));
    } catch (error) {
      return [];
    }
  }

  var slides = parseSlidesFromDataAttr();
  if (!slides.length) {
    slides = fallbackSlides();
  }

  var current = 0;

  function setText(node, value) {
    if (!node) {
      return;
    }

    node.textContent = value || '';
  }

  function render() {
    var slide = slides[current] || { year: '', title: '', description: '' };

    setText(badge, slide.year);
    setText(slideTitle, slide.title);
    setText(slideDesc, slide.description);

    setText(bgPrev, slide.year);
    setText(bgNext, slides[current + 1] ? slides[current + 1].year : '');
    setText(bgFar, slides[current + 2] ? slides[current + 2].year : '');

    if (prevBtn) {
      prevBtn.disabled = current <= 0;
    }

    if (nextBtn) {
      nextBtn.disabled = current >= slides.length - 1;
    }

    card.classList.remove('is-sliding');
    void card.offsetWidth;
    card.classList.add('is-sliding');
  }

  if (prevBtn) {
    prevBtn.addEventListener('click', function () {
      if (current > 0) {
        current -= 1;
        render();
      }
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener('click', function () {
      if (current < slides.length - 1) {
        current += 1;
        render();
      }
    });
  }

  render();
})();
