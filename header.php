<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>ECH*S — Inicio</title>

  <!-- Google Fonts (alternativa gratuita similar a “Universo”) -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;700;900&display=swap" rel="stylesheet" />

  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="popup.css" />
</head>
   <body>
  <!-- HERO / HEADER -->
  <header class="hero" id="hero">
    <div class="hero__viewport" id="heroViewport" aria-label="Slider principal">
      <!-- Slide 1 -->
      <article class="hero__slide" style="--hero-image: url('img/inicio/baner1.jpg');">
        <div class="hero__bg" aria-hidden="true"></div>
        <div class="container hero__content">
          <div class="hero__copy">
            <h1 class="hero__title">
              <span class="hero__title--accent">CREAMOS</span><br />
              ESPECTÁCULOS<br />
              MEMORABLES
            </h1>
            <p class="hero__desc">
              Infraestructura, diseño y ejecución para eventos que conectan con tu audiencia.
            </p>
          </div>
        </div>
      </article>

      <!-- Slide 2 -->
      <article class="hero__slide" style="--hero-image: url('img/inicio/baner1.jpg');">
        <div class="hero__bg" aria-hidden="true"></div>
        <div class="container hero__content">
          <div class="hero__copy">
            <h1 class="hero__title">
              <span class="hero__title--accent">DISEÑAMOS</span><br />
              EXPERIENCIAS<br />
              A MEDIDA
            </h1>
            <p class="hero__desc">
              Transformamos espacios en escenarios con identidad, luz y detalle técnico.
            </p>
          </div>
        </div>
      </article>

      <!-- Slide 3 -->
      <article class="hero__slide" style="--hero-image: url('img/inicio/baner1.jpg');">
        <div class="hero__bg" aria-hidden="true"></div>
        <div class="container hero__content">
          <div class="hero__copy">
            <h1 class="hero__title">
              <span class="hero__title--accent">PRODUCIMOS</span><br />
              EVENTOS<br />
              IMPACTANTES
            </h1>
            <p class="hero__desc">
              Equipo, montaje y operación para que todo salga perfecto de principio a fin.
            </p>
          </div>
        </div>
      </article>
    </div>

    <div class="hero__overlay" aria-hidden="true"></div>

    <div class="topbar">
      <div class="container topbar__inner">
        <a class="brand" href="#">
          <img class="brand__logo" src="img/inicio/logo.png" alt="ECHOS" />
          <span class="sr-only">ECHOS — Infraestructura para eventos</span>
        </a>

        <nav class="nav">
          <a href="#servicios">Servicios</a>
          <a href="#proyectos">Proyectos</a>
          <a href="#conocenos">Conócenos</a>
        </nav>

        <a class="cta" href="#contacto">
          <span>Cotiza tu proyecto</span>
          <span class="cta__icon" aria-hidden="true">→</span>
        </a>
      </div>
    </div>

    <div class="hero__dots" role="tablist" aria-label="Slider">
      <button class="dot is-active" type="button" aria-label="Slide 1" data-slide="0"></button>
      <button class="dot" type="button" aria-label="Slide 2" data-slide="1"></button>
      <button class="dot" type="button" aria-label="Slide 3" data-slide="2"></button>
    </div>
  </header>
