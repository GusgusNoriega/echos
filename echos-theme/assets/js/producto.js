/* ============================================
   Producto Individual — producto.js
   ============================================ */

document.addEventListener('DOMContentLoaded', () => {

  /* --- Scroll suave para links internos --- */
  document.querySelectorAll('a[href^="#"]').forEach(link => {
    link.addEventListener('click', e => {
      const target = document.querySelector(link.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* --- Animación de entrada de las spec-cards --- */
  const specCards = document.querySelectorAll('.spec-card');
  if (specCards.length && 'IntersectionObserver' in window) {
    specCards.forEach(card => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      card.style.transition = 'opacity .5s ease, transform .5s ease';
    });

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const card = entry.target;
          const idx = Array.from(specCards).indexOf(card);
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          }, idx * 100);
          observer.unobserve(card);
        }
      });
    }, { threshold: 0.15 });

    specCards.forEach(card => observer.observe(card));
  }

  /* --- Animación de entrada de galería --- */
  const galleryItems = document.querySelectorAll('.prod-gallery__item');
  if (galleryItems.length && 'IntersectionObserver' in window) {
    galleryItems.forEach(item => {
      item.style.opacity = '0';
      item.style.transform = 'scale(0.95)';
      item.style.transition = 'opacity .6s ease, transform .6s ease';
    });

    const galleryObs = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const item = entry.target;
          const idx = Array.from(galleryItems).indexOf(item);
          setTimeout(() => {
            item.style.opacity = '1';
            item.style.transform = 'scale(1)';
          }, idx * 120);
          galleryObs.unobserve(item);
        }
      });
    }, { threshold: 0.1 });

    galleryItems.forEach(item => galleryObs.observe(item));
  }

  /* --- Header con sombra al hacer scroll --- */
  const header = document.querySelector('.prod-header');
  if (header) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 10) {
        header.style.boxShadow = '0 4px 20px rgba(0,0,0,.35)';
      } else {
        header.style.boxShadow = 'none';
      }
    }, { passive: true });
  }

  /* --- Slider Productos Recomendados --- */
  const recTrack = document.querySelector('.prod-recomendados__track');
  const recPrev  = document.querySelector('.prod-recomendados__arrow--prev');
  const recNext  = document.querySelector('.prod-recomendados__arrow--next');

  if (recTrack && recPrev && recNext) {
    let recIndex = 0;
    const recCards = recTrack.querySelectorAll('.prod-recomendados__card');
    const gap = 24; // must match CSS gap

    function getItemsPerView() {
      return window.innerWidth <= 520 ? 1 : 2;
    }

    function getMaxIndex() {
      const perView = getItemsPerView();
      return Math.max(0, recCards.length - perView);
    }

    function updateSlider() {
      if (!recCards.length) return;
      const cardWidth = recCards[0].offsetWidth;
      const offset = recIndex * (cardWidth + gap);
      recTrack.style.transform = `translateX(-${offset}px)`;
    }

    recNext.addEventListener('click', () => {
      if (recIndex < getMaxIndex()) {
        recIndex++;
      } else {
        recIndex = 0;
      }
      updateSlider();
    });

    recPrev.addEventListener('click', () => {
      if (recIndex > 0) {
        recIndex--;
      } else {
        recIndex = getMaxIndex();
      }
      updateSlider();
    });

    window.addEventListener('resize', () => {
      if (recIndex > getMaxIndex()) recIndex = getMaxIndex();
      updateSlider();
    });
  }

});
