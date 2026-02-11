<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ECH*S — Producto</title>

  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;900&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="popup.css" />
  <link rel="stylesheet" href="producto.css" />
</head>
<body class="product-page">
  <header class="product-header">
    <div class="topbar topbar--solid">
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

        <a class="cta" href="#contacto-proyecto">
          <span>Cotiza tu proyecto</span>
          <span class="cta__icon" aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </header>

  <main>
    <section class="product-hero">
      <div class="container product-hero__grid">
        <div>
          <p class="product-hero__eyebrow">Productos</p>
          <h1 class="product-hero__title">Esfera cinética</h1>
          <p class="product-hero__text">
            Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas.
          </p>
          <p class="product-hero__text">
            Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristique duis lectus molestie tortor. Turpis non ultricies tempus scelerisque at mus massa aliquet praesent.
          </p>

          <a class="btn btn--orange" href="#contacto-proyecto">
            <span>Cotizar</span>
            <span class="btn__icon" aria-hidden="true">→</span>
          </a>
        </div>

        <div class="product-hero__media" aria-hidden="true"></div>
      </div>
    </section>

    <section class="product-contact" id="contacto-proyecto">
      <div class="container product-contact__panel">
        <div>
          <h2 class="product-contact__title">¿Listo para comenzar?</h2>
          <p class="product-contact__desc">Únete a nosotros y haz que tu próxima activación brille con propósito e impacto.</p>
          <p class="product-contact__small">Todo gran proyecto comienza con una conversación.</p>
        </div>

        <div class="product-contact__actions">
          <a class="pill pill--dark" href="#">
            <span class="pill__icon" aria-hidden="true">💬</span>
            <span>Conversemos ahora</span>
          </a>
          <a class="pill pill--dark" href="mailto:contacto@echosperu.com.pe">
            <span class="pill__icon" aria-hidden="true">✉</span>
            <span>echosperu.com.pe</span>
          </a>
        </div>
      </div>
    </section>

    <section class="product-features">
      <div class="container">
        <div class="product-features__head">
          <h2 class="section-title">Características</h2>
          <p class="section-sub">Esfera cinética interactiva que se expande, gira y fluye para galerías de experiencias.</p>
        </div>

        <div class="product-features__grid">
          <article class="feature-card is-highlight">
            <h3>Ideal para</h3>
            <ul>
              <li>Ángulo de visión 360º.</li>
              <li>Color pixel LED RGB.</li>
              <li>Dimensiones por unidades 30 cm.</li>
              <li>Frecuencia de actualización 75Hz.</li>
            </ul>
          </article>

          <article class="feature-card">
            <h3>Sistema</h3>
            <ul>
              <li>Control HDMI, DVI y Madrix.</li>
              <li>Trust aluminio de alta resistencia.</li>
              <li>Montaje modular para espacios inmersivos.</li>
              <li>Configuración adaptable por proyecto.</li>
            </ul>
          </article>

          <article class="feature-card feature-card--media" aria-hidden="true"></article>
        </div>
      </div>
    </section>

    <section class="product-related">
      <div class="container product-related__grid">
        <div>
          <h2 class="section-title">Productos recomendados</h2>
          <div class="related-list">
            <article class="related-card">
              <div class="related-card__media"></div>
              <div class="related-card__content">
                <h3>Lorem ipsum dolor sit amet consectetur</h3>
                <p>Ipsum nisl aenean nibh ac et. Proin donec adipiscing magnis euismod. Felis eget egestas risus pharetra vel.</p>
              </div>
            </article>
            <article class="related-card">
              <div class="related-card__media related-card__media--alt"></div>
              <div class="related-card__content">
                <h3>Lorem ipsum dolor sit amet consectetur</h3>
                <p>Ipsum nisl aenean nibh ac et. Proin donec adipiscing magnis euismod. Felis eget egestas risus pharetra vel.</p>
              </div>
            </article>
          </div>
        </div>

        <aside class="tech-sheet">
          <h3>Ficha técnica</h3>
          <p>Lorem ipsum dolor sit amet consectetur. Ipsum nisl aenean nibh ac et. Proin donec adipiscing magnis euismod.</p>
          <a class="btn btn--orange" href="#">
            <span>Descargar ficha técnica</span>
            <span class="btn__icon" aria-hidden="true">↓</span>
          </a>
        </aside>
      </div>
    </section>
  </main>

<?php require_once __DIR__ . '/footer.php'; ?>
