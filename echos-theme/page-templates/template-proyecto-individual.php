<?php
/**
 * Template Name: Proyecto Individual
 * Description: Página de proyecto individual ECHOS.
 *
 * @package Echos
 */

get_header();

$img  = get_template_directory_uri() . '/assets/img/inicio/';
$home = esc_url( home_url( '/' ) );
?>

  <!-- TOPBAR / NAVEGACIÓN -->
  <header class="proyecto-ind-header">
    <div class="topbar topbar--static">
      <div class="container topbar__inner">
        <a class="brand" href="<?php echo $home; ?>">
          <img class="brand__logo" src="<?php echo $img; ?>logo.png" alt="ECHOS" />
          <span class="sr-only">ECHOS — Infraestructura para eventos</span>
        </a>

        <nav class="nav">
          <a href="<?php echo $home; ?>#servicios">Servicios</a>
          <a href="<?php echo $home; ?>proyectos/">Proyectos</a>
          <a href="<?php echo $home; ?>#conocenos">Conócenos</a>
        </nav>

        <a class="cta" href="<?php echo $home; ?>#contacto">
          <span>Cotiza tu proyecto</span>
          <span class="cta__icon" aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </header>

  <!-- HERO: PROYECTO INDIVIDUAL -->
  <section class="proy-ind-hero">
    <div class="proy-ind-hero__bg" style="background-image:url('<?php echo $img; ?>baner1.jpg')" aria-hidden="true"></div>
    <div class="container proy-ind-hero__inner">
      <h1 class="proy-ind-hero__title">
        proyecto <span class="proy-ind-hero__accent"> individual</span>
      </h1>
      <p class="proy-ind-hero__desc">
        Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam
        lobortis lacus sit. Nulla id massa eget massa.
      </p>
    </div>
  </section>

  <!-- DETALLE DEL PROYECTO -->
  <section class="proy-ind-detalle">
    <div class="container proy-ind-detalle__inner">

      <!-- Etiqueta + Fecha -->
      <div class="proy-ind-detalle__meta">
        <span class="proy-ind-detalle__tag">Entretenimiento</span>
        <time class="proy-ind-detalle__date" datetime="2025-06-05">05 de junio, 2025</time>
      </div>

      <!-- Título -->
      <h2 class="proy-ind-detalle__title">
        Lorem ipsum dolor sit amet consectetur. Dolor parturient.
      </h2>

      <!-- Separador naranja -->
      <hr class="proy-ind-detalle__sep" />

      <!-- Párrafo introductorio -->
      <p class="proy-ind-detalle__text">
        Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla
        id massa eget massa. Turpis aliquam felis est p
      </p>

      <!-- Párrafo destacado con borde izquierdo -->
      <blockquote class="proy-ind-detalle__highlight">
        <p>
          Lorem ipsum dolor sit amet consectetur. Tristique gravida posuere leo venenatis nunc vel.
          Venenatis ipsum imperdiet augue adipiscing posuere. Vulputate amet viverra lorem
          pharetra nisi. Nulla vitae aenean mi nec sit id ornare volutpat. Dui montes dolor in tortor
          massa. Diam sapien at proin pellentesque. Laoreet quis nunc volutpat dui molestie nisl.
          Odio mi habitant
        </p>
      </blockquote>

      <!-- Párrafo final -->
      <p class="proy-ind-detalle__text">
        netus condimentum neque mattis dui cursus volutpat. In et accumsan augue magna
        lacinia faucibus. Leo nibh tincidunt cras sit arcu tristique senectus. Cursus vel pharetra
        viverra feugiat consequat. Nunc cursus diam dignissim eleifend in sed turpis. Tellus ut
        vivamus urna aliquam nibh. Lacinia lacus lacus faucibus vulputate sed.
      </p>

      <!-- CTA -->
      <div class="proy-ind-detalle__cta-wrap">
        <a class="proy-ind-detalle__cta" href="<?php echo $home; ?>#contacto">
          <span>Cotizar proyecto</span>
          <span class="proy-ind-detalle__cta-icon" aria-hidden="true">→</span>
        </a>
      </div>

    </div>
  </section>

  <!-- SECCIÓN VIDEO -->
  <section class="proy-ind-video">
    <div class="container proy-ind-video__inner">
      <div class="proy-ind-video__wrapper"
           data-video-id="dQw4w9WgXcQ"
           role="button"
           tabindex="0"
           aria-label="Reproducir video del proyecto">

        <!-- Imagen de portada personalizada -->
        <img class="proy-ind-video__thumb"
             src="<?php echo $img; ?>baner1.jpg"
             alt="Video del proyecto"
             loading="lazy" />

        <!-- Overlay oscuro -->
        <div class="proy-ind-video__overlay" aria-hidden="true"></div>

        <!-- Botón play -->
        <button class="proy-ind-video__play" type="button" aria-label="Reproducir video">
          <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="40" cy="40" r="39" fill="white"/>
            <polygon points="32,24 58,40 32,56" fill="#1a1a1a"/>
          </svg>
        </button>

      </div>
    </div>
  </section>
  
 <!-- PRODUCTOS UTILIZADOS -->
  <section class="proy-ind-productos">
    <div class="container proy-ind-productos__inner">

      <h2 class="proy-ind-productos__title">Productos utilizados</h2>

      <div class="proy-ind-productos__grid">

        <!-- Card 1 -->
        <div class="proy-ind-productos__card">
          <div class="proy-ind-productos__card-header">
            <span class="proy-ind-productos__card-name">Esferas kinetic</span>
            <span class="proy-ind-productos__card-arrow" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="7" y1="17" x2="17" y2="7"/>
                <polyline points="7 7 17 7 17 17"/>
              </svg>
            </span>
          </div>
          <div class="proy-ind-productos__card-body">
            <h3 class="proy-ind-productos__card-subtitle">Características</h3>
            <ul class="proy-ind-productos__card-list">
              <li>Angulo de visión 360°.</li>
              <li>Dimensiones por Unidades 30 cm</li>
              <li>Frecuencia actualización - 75Hz.</li>
              <li>Color pixel LED - RGB</li>
              <li>Señal Control - HDMI - DVI - Madrix 5</li>
            </ul>
          </div>
        </div>

        <!-- Card 2 -->
        <div class="proy-ind-productos__card">
          <div class="proy-ind-productos__card-header">
            <span class="proy-ind-productos__card-name">Esferas kinetic</span>
            <span class="proy-ind-productos__card-arrow" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="7" y1="17" x2="17" y2="7"/>
                <polyline points="7 7 17 7 17 17"/>
              </svg>
            </span>
          </div>
          <div class="proy-ind-productos__card-body">
            <h3 class="proy-ind-productos__card-subtitle">Características</h3>
            <ul class="proy-ind-productos__card-list">
              <li>Angulo de visión 360°.</li>
              <li>Dimensiones por Unidades 30 cm</li>
              <li>Frecuencia actualización - 75Hz.</li>
              <li>Color pixel LED - RGB</li>
              <li>Señal Control - HDMI - DVI - Madrix 5</li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- GALERÍA DE IMÁGENES -->
  <section class="proy-ind-galeria">
    <div class="container proy-ind-galeria__inner">
      <div class="proy-ind-galeria__grid">

        <!-- Imagen 1 -->
        <div class="proy-ind-galeria__card">
          <img class="proy-ind-galeria__img"
               src="<?php echo $img; ?>baner1.jpg"
               alt="Galería del proyecto"
               loading="lazy" />
        </div>

        <!-- Imagen 2 -->
        <div class="proy-ind-galeria__card">
          <img class="proy-ind-galeria__img"
               src="<?php echo $img; ?>baner1.jpg"
               alt="Galería del proyecto"
               loading="lazy" />
        </div>

        <!-- Imagen 3 -->
        <div class="proy-ind-galeria__card">
          <img class="proy-ind-galeria__img"
               src="<?php echo $img; ?>baner1.jpg"
               alt="Galería del proyecto"
               loading="lazy" />
        </div>

        <!-- Imagen 4 -->
        <div class="proy-ind-galeria__card">
          <img class="proy-ind-galeria__img"
               src="<?php echo $img; ?>baner1.jpg"
               alt="Galería del proyecto"
               loading="lazy" />
        </div>

      </div>
    </div>
  </section>

  <!-- CONOCE OTROS PROYECTOS — Slider -->
  <section class="proy-ind-otros">
    <div class="container proy-ind-otros__inner">

      <h2 class="proy-ind-otros__title">Conoce otros proyectos</h2>

      <!-- Navegación del slider -->
      <div class="proy-ind-otros__nav">
        <button class="proy-ind-otros__arrow proy-ind-otros__arrow--prev" type="button" aria-label="Anterior">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12"/>
            <polyline points="12 19 5 12 12 5"/>
          </svg>
          <span>Anterior</span>
        </button>
        <button class="proy-ind-otros__arrow proy-ind-otros__arrow--next" type="button" aria-label="Siguiente">
          <span>Siguiente</span>
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="5" y1="12" x2="19" y2="12"/>
            <polyline points="12 5 19 12 12 19"/>
          </svg>
        </button>
      </div>

      <!-- Track del slider -->
      <div class="proy-ind-otros__viewport">
        <div class="proy-ind-otros__track">

          <!-- Card 1 -->
          <a href="#" class="proy-ind-otros__card">
            <div class="proy-ind-otros__card-img-wrap">
              <img class="proy-ind-otros__card-img"
                   src="<?php echo $img; ?>baner1.jpg"
                   alt="BCP Lanzamiento"
                   loading="lazy" />
              <span class="proy-ind-otros__card-badge">Eventos</span>
            </div>
            <div class="proy-ind-otros__card-info">
              <div class="proy-ind-otros__card-text">
                <span class="proy-ind-otros__card-name">BCP Lanzamiento</span>
                <span class="proy-ind-otros__card-date">05 de junio, 2025</span>
              </div>
              <span class="proy-ind-otros__card-link" aria-hidden="true">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="7" y1="17" x2="17" y2="7"/>
                  <polyline points="7 7 17 7 17 17"/>
                </svg>
              </span>
            </div>
          </a>

          <!-- Card 2 -->
          <a href="#" class="proy-ind-otros__card">
            <div class="proy-ind-otros__card-img-wrap">
              <img class="proy-ind-otros__card-img"
                   src="<?php echo $img; ?>baner1.jpg"
                   alt="BCP Lanzamiento"
                   loading="lazy" />
              <span class="proy-ind-otros__card-badge">Eventos</span>
            </div>
            <div class="proy-ind-otros__card-info">
              <div class="proy-ind-otros__card-text">
                <span class="proy-ind-otros__card-name">BCP Lanzamiento</span>
                <span class="proy-ind-otros__card-date">05 de junio, 2025</span>
              </div>
              <span class="proy-ind-otros__card-link" aria-hidden="true">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="7" y1="17" x2="17" y2="7"/>
                  <polyline points="7 7 17 7 17 17"/>
                </svg>
              </span>
            </div>
          </a>

          <!-- Card 3 -->
          <a href="#" class="proy-ind-otros__card">
            <div class="proy-ind-otros__card-img-wrap">
              <img class="proy-ind-otros__card-img"
                   src="<?php echo $img; ?>baner1.jpg"
                   alt="BCP Lanzamiento"
                   loading="lazy" />
              <span class="proy-ind-otros__card-badge">Eventos</span>
            </div>
            <div class="proy-ind-otros__card-info">
              <div class="proy-ind-otros__card-text">
                <span class="proy-ind-otros__card-name">BCP Lanzamiento</span>
                <span class="proy-ind-otros__card-date">05 de junio, 2025</span>
              </div>
              <span class="proy-ind-otros__card-link" aria-hidden="true">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="7" y1="17" x2="17" y2="7"/>
                  <polyline points="7 7 17 7 17 17"/>
                </svg>
              </span>
            </div>
          </a>

          <!-- Card 4 -->
          <a href="#" class="proy-ind-otros__card">
            <div class="proy-ind-otros__card-img-wrap">
              <img class="proy-ind-otros__card-img"
                   src="<?php echo $img; ?>baner1.jpg"
                   alt="BCP Lanzamiento"
                   loading="lazy" />
              <span class="proy-ind-otros__card-badge">Eventos</span>
            </div>
            <div class="proy-ind-otros__card-info">
              <div class="proy-ind-otros__card-text">
                <span class="proy-ind-otros__card-name">BCP Lanzamiento</span>
                <span class="proy-ind-otros__card-date">05 de junio, 2025</span>
              </div>
              <span class="proy-ind-otros__card-link" aria-hidden="true">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="7" y1="17" x2="17" y2="7"/>
                  <polyline points="7 7 17 7 17 17"/>
                </svg>
              </span>
            </div>
          </a>

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

<?php
get_footer();
