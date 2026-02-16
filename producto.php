<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ECH*S — Esfera Cinética</title>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="producto.css" />
  <link rel="stylesheet" href="popup.css" />
</head>
<body>

  <!-- TOPBAR / NAVEGACIÓN -->
  <header class="prod-header">
    <div class="topbar topbar--static">
      <div class="container topbar__inner">
        <a class="brand" href="index.php">
          <img class="brand__logo" src="img/inicio/logo.png" alt="ECHOS" />
          <span class="sr-only">ECHOS — Infraestructura para eventos</span>
        </a>

        <nav class="nav">
          <a href="index.php#servicios">Servicios</a>
          <a href="index.php#proyectos">Proyectos</a>
          <a href="index.php#conocenos">Conócenos</a>
        </nav>

        <a class="cta" href="index.php#contacto">
          <span>Cotiza tu proyecto</span>
          <span class="cta__icon" aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </header>

  <!-- HERO PRODUCTO -->
  <section class="prod-hero">
    <div class="prod-hero__bg" aria-hidden="true"></div>
    <div class="container prod-hero__inner">
      <div class="prod-hero__copy">
        <h1 class="prod-hero__title">ESFERA CINETICA</h1>
        <p class="prod-hero__desc">
          Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla id massa eget massa. Turpis aliquam felis est p
        </p>
        <a class="btn btn--orange" href="index.php#contacto">
          <span>Cotizar</span>
          <span class="btn__icon" aria-hidden="true">→</span>
        </a>
      </div>
      <div class="prod-hero__media">
        <img src="img/inicio/baner1.jpg" alt="Esfera Cinética LED" class="prod-hero__img" />
      </div>
    </div>
  </section>

  <!-- CARACTERÍSTICAS -->
  <section class="prod-specs" id="caracteristicas">
    <div class="container">
      <h2 class="prod-specs__title">CARACTERISTICAS</h2>
      <div class="prod-specs__inner">
        <div class="prod-specs__content">
          <div class="prod-specs__gallery">
            <img src="img/inicio/baner1.jpg" alt="Esfera Cinética detalle" class="prod-specs__img" />
            <p class="prod-specs__caption">
              Lorem ipsum dolor sit amet consectetur. Ipsum nisl aenean nibh ac et. Proin donec adipiscing magnis euismod. Felis eget egestas risus pharetra vel. A mattis elementum mi in. Dui dolor
            </p>
          </div>
          <div class="prod-specs__list">
            <div class="spec-card">
              <div class="spec-card__header">
                <span class="spec-card__dot"></span>
                <strong>Color pixel LED - RGB</strong>
              </div>
              <p class="spec-card__text">Lorem ipsum dolor sit amet consectetur. Lorem urna viverra porttitor quis fringilla massa cursus. Commodo sed venenatis</p>
            </div>
            <div class="spec-card">
              <div class="spec-card__header">
                <span class="spec-card__dot"></span>
                <strong>Señal Control - HDMI - DVI - Madrix 5</strong>
              </div>
              <p class="spec-card__text">Lorem ipsum dolor sit amet consectetur. Lorem urna viverra porttitor quis fringilla massa cursus. Commodo sed venenatis</p>
            </div>
            <div class="spec-card">
              <div class="spec-card__header">
                <span class="spec-card__dot"></span>
                <strong>Ángulo de visión 360º.</strong>
              </div>
              <p class="spec-card__text">Lorem ipsum dolor sit amet consectetur. Lorem urna viverra porttitor quis fringilla massa cursus. Commodo sed venenatis</p>
            </div>
            <div class="spec-card">
              <div class="spec-card__header">
                <span class="spec-card__dot"></span>
                <strong>Dimensiones por Unidades 30 cm</strong>
              </div>
              <p class="spec-card__text">Lorem ipsum dolor sit amet consectetur. Lorem urna viverra porttitor quis fringilla massa cursus. Commodo sed venenatis</p>
            </div>
            <div class="spec-card">
              <div class="spec-card__header">
                <span class="spec-card__dot"></span>
                <strong>Frecuencia actualización - 75Hz.</strong>
              </div>
              <p class="spec-card__text">Lorem ipsum dolor sit amet consectetur. Lorem urna viverra porttitor quis fringilla massa cursus. Commodo sed venenatis</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FICHA TÉCNICA -->
  <section class="prod-ficha" id="ficha">
    <div class="container">
      <div class="prod-ficha__card">
        <div class="prod-ficha__inner">
          <div class="prod-ficha__media">
            <div class="prod-ficha__device">
              <img src="img/inicio/baner1.jpg" alt="Ficha técnica Esfera Cinética" class="prod-ficha__img" />
            </div>
          </div>
          <div class="prod-ficha__content">
            <h2 class="prod-ficha__title">FICHA TECNICA</h2>
            <p class="prod-ficha__text">
              Lorem ipsum dolor sit amet consectetur. Ipsum nisl aenean nibh ac et. Proin donec adipiscing magnis euismod. Felis eget egestas risus pharetra vel. A mattis elementum mi in. Dui dolor
            </p>
            <a class="btn-ficha-download" href="#" download>
              <span>Descargar ficha técnica</span>
              <svg class="btn-ficha-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                <polyline points="7 10 12 15 17 10"></polyline>
                <line x1="12" y1="15" x2="12" y2="3"></line>
              </svg>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- IDEAL PARA -->
  <section class="prod-ideal" id="ideal">
    <div class="container prod-ideal__inner">
      <h2 class="prod-ideal__title">IDEAL PARA</h2>
      <div class="prod-ideal__content">
        <p>
          Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin vari nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat aue pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellente molestie tortor. Turpis non ultricies tempus scelerisque at mus massa al.
        </p>
        <p>
          Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin vari nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat aue pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellente molestie tortor. Turpis non ultricies tempus scelerisque at mus massa al.
        </p>
      </div>
    </div>
  </section>

  <!-- GALERÍA DE EXPERIENCIAS -->
  <section class="prod-gallery" id="galeria">
    <div class="container">
      <h2 class="prod-gallery__title">GALERIA DE EXPERIENCIAS</h2>
      <div class="prod-gallery__grid">
        <div class="prod-gallery__row">
          <div class="prod-gallery__item prod-gallery__item--lg">
            <img src="img/inicio/baner1.jpg" alt="Experiencia 1" />
          </div>
          <div class="prod-gallery__item prod-gallery__item--sm">
            <img src="img/inicio/baner1.jpg" alt="Experiencia 2" />
          </div>
        </div>
        <div class="prod-gallery__row">
          <div class="prod-gallery__item prod-gallery__item--sm">
            <img src="img/inicio/baner1.jpg" alt="Experiencia 3" />
          </div>
          <div class="prod-gallery__item prod-gallery__item--lg">
            <img src="img/inicio/baner1.jpg" alt="Experiencia 4" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- PRODUCTOS RECOMENDADOS -->
  <section class="prod-recomendados" id="recomendados">
    <div class="container">
      <div class="prod-recomendados__header">
        <h2 class="prod-recomendados__title">PRODUCTOS RECOMENDADOS</h2>
        <div class="prod-recomendados__nav">
          <button class="prod-recomendados__arrow prod-recomendados__arrow--prev" aria-label="Anterior">←</button>
          <button class="prod-recomendados__arrow prod-recomendados__arrow--next" aria-label="Siguiente">→</button>
        </div>
      </div>
      <div class="prod-recomendados__slider">
        <div class="prod-recomendados__track">
          <div class="prod-recomendados__card">
            <img src="img/inicio/baner1.jpg" alt="Esfera Kinetic" class="prod-recomendados__img" />
            <div class="prod-recomendados__info">
              <div class="prod-recomendados__text">
                <strong>Esfera Kinetic</strong>
                <p>Esfera cinética interactiva que se expande, gira y flu...</p>
              </div>
              <a href="#" class="prod-recomendados__btn" aria-label="Ver producto">+</a>
            </div>
          </div>
          <div class="prod-recomendados__card">
            <img src="img/inicio/baner1.jpg" alt="Sistema Trust Aluminio" class="prod-recomendados__img" />
            <div class="prod-recomendados__info">
              <div class="prod-recomendados__text">
                <strong>Sistema Trust Aluminio</strong>
                <p>Esfera cinética interactiva que se expande, gira y flu...</p>
              </div>
              <a href="#" class="prod-recomendados__btn" aria-label="Ver producto">↗</a>
            </div>
          </div>
          <div class="prod-recomendados__card">
            <img src="img/inicio/baner1.jpg" alt="Panel LED" class="prod-recomendados__img" />
            <div class="prod-recomendados__info">
              <div class="prod-recomendados__text">
                <strong>Panel LED</strong>
                <p>Esfera cinética interactiva que se expande, gira y flu...</p>
              </div>
              <a href="#" class="prod-recomendados__btn" aria-label="Ver producto">+</a>
            </div>
          </div>
          <div class="prod-recomendados__card">
            <img src="img/inicio/baner1.jpg" alt="Pantalla Holográfica" class="prod-recomendados__img" />
            <div class="prod-recomendados__info">
              <div class="prod-recomendados__text">
                <strong>Pantalla Holográfica</strong>
                <p>Esfera cinética interactiva que se expande, gira y flu...</p>
              </div>
              <a href="#" class="prod-recomendados__btn" aria-label="Ver producto">↗</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA FINAL -->
  <section class="prod-cta">
    <div class="container">
      <div class="prod-cta__card">
        <h2 class="prod-cta__title">¿LISTO PARA COMENZAR?</h2>
        <p class="prod-cta__text">Todo gran proyecto comienza con una conversación.</p>
        <div class="prod-cta__buttons">
          <a class="btn-cta-dark" href="https://wa.me/" target="_blank" rel="noopener">
            <span>Conversemos ahora</span>
            <span class="btn-cta-dark__icon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.025.507 3.932 1.396 5.608L.05 23.708a.6.6 0 00.735.728L6.53 22.64A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.6a9.56 9.56 0 01-5.175-1.516l-.372-.222-3.843.985 1.028-3.752-.243-.387A9.56 9.56 0 012.4 12c0-5.302 4.298-9.6 9.6-9.6s9.6 4.298 9.6 9.6-4.298 9.6-9.6 9.6z"/></svg>
            </span>
          </a>
          <a class="btn-cta-dark" href="mailto:contacto@echosperu.com.pe" target="_blank" rel="noopener">
            <span>echosperu.com.pe</span>
            <span class="btn-cta-dark__icon" aria-hidden="true">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 4L12 13 2 4"/></svg>
            </span>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <script src="producto.js"></script>
<?php require_once __DIR__ . '/footer.php'; ?>
