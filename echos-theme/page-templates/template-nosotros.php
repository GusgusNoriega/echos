<?php
/**
 * Template Name: Nosotros
 * Description: Página "Nosotros" de ECHOS.
 *
 * @package Echos
 */

get_header();

$img  = get_template_directory_uri() . '/assets/img/inicio/';
$home = esc_url( home_url( '/' ) );
?>

  <!-- TOPBAR / NAVEGACIÓN -->
  <header class="nosotros-header">
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

  <!-- HERO: NOSOTROS -->
  <section class="nosotros-hero">
    <div class="nosotros-hero__bg" style="background-image:url('<?php echo $img; ?>baner1.jpg')" aria-hidden="true"></div>
    <div class="container nosotros-hero__inner">
      <h1 class="nosotros-hero__title">
        somos una empresa de <span class="nosotros-hero__accent">infraestructura de eventos</span>
      </h1>
      <p class="nosotros-hero__desc">
        Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam
      </p>
    </div>
  </section>

  <!-- IMAGEN EQUIPO -->
  <section class="nosotros-imagen">
    <div class="container nosotros-imagen__inner">
      <div class="nosotros-imagen__wrap">
        <img class="nosotros-imagen__img"
             src="<?php echo $img; ?>baner1.jpg"
             alt="Equipo ECHOS"
             loading="lazy" />
      </div>
    </div>
  </section>

  <!-- DESCRIPCIÓN EMPRESA -->
  <section class="nosotros-descripcion">
    <div class="container nosotros-descripcion__inner">
      <p class="nosotros-descripcion__text">
        Somos una empresa con más de 15 años de experiencia en el rubro. Partiendo desde soluciones estructurales arquitectónicas, sistema modular Octanorm para ferias y exposiciones, ahora iluminación tecnológica led para eventos. Contamos con equipos profesionales para cubrir toda magnitud de eventos sociales y corporativos.
      </p>
      <p class="nosotros-descripcion__text">
        Revolucionamos las formas de entretenimiento presentando diversas opciones que ofrecemos para que nuestros socios sean tendencia en el mercado.
      </p>
    </div>
  </section>



  <!-- NUESTRA HISTORIA — Timeline Slider -->
  <section class="nosotros-historia">
    <div class="nosotros-historia__bg-years" aria-hidden="true">
      <span class="nosotros-historia__bg-year nosotros-historia__bg-year--prev">2018</span>
      <span class="nosotros-historia__bg-year nosotros-historia__bg-year--next">2018</span>
      <span class="nosotros-historia__bg-year nosotros-historia__bg-year--far">2020</span>
    </div>

    <div class="container nosotros-historia__inner">
      <h2 class="nosotros-historia__title">NUESTRA HISTORIA</h2>

      <div class="nosotros-historia__card">
        <!-- Badge año -->
        <span class="nosotros-historia__badge">2018</span>

        <!-- Navegación flechas -->
        <div class="nosotros-historia__nav">
          <button class="nosotros-historia__arrow nosotros-historia__arrow--prev" aria-label="Anterior">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          </button>
          <button class="nosotros-historia__arrow nosotros-historia__arrow--next" aria-label="Siguiente">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </button>
        </div>

        <!-- Contenido del slide -->
        <div class="nosotros-historia__content">
          <h3 class="nosotros-historia__slide-title">Lanzamiento de ECHOS</h3>
          <p class="nosotros-historia__slide-desc">
            Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisi quis mauris viverra. Blandit vestibulum tempus lectus consequ
          </p>
        </div>
      </div>
    </div>
  </section>

    <!-- MISIÓN Y VISIÓN -->
  <section class="nosotros-mv">
    <div class="container nosotros-mv__inner">
      <div class="nosotros-mv__grid">

        <!-- Card Misión -->
        <div class="nosotros-mv__card">
          <div class="nosotros-mv__header">
            <h3 class="nosotros-mv__title">MISION</h3>
            <div class="nosotros-mv__icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                <circle cx="12" cy="12" r="1"/>
              </svg>
            </div>
          </div>
          <p class="nosotros-mv__desc">
            Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas
          </p>
        </div>

        <!-- Card Visión -->
        <div class="nosotros-mv__card">
          <div class="nosotros-mv__header">
            <h3 class="nosotros-mv__title">VISION</h3>
            <div class="nosotros-mv__icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M4 20L10 8l4 6 2-3 4 9"/>
                <path d="M14 10l2-2 1.5 1.5"/>
                <line x1="16" y1="8" x2="16" y2="5"/>
                <path d="M15 5h2l-1-2-1 2z"/>
              </svg>
            </div>
          </div>
          <p class="nosotros-mv__desc">
            Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas
          </p>
        </div>

      </div>
    </div>
  </section>

  <!-- ¿CÓMO TRABAJAMOS? — Proceso -->
  <section class="nosotros-proceso">
    <div class="container nosotros-proceso__inner">
      <h2 class="nosotros-proceso__title">¿COMO TRABAJAMOS?</h2>
      <p class="nosotros-proceso__desc">
        Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla id
      </p>

      <div class="nosotros-proceso__grid">
        <!-- Card 01 -->
        <div class="nosotros-proceso__card">
          <span class="nosotros-proceso__number">01</span>
          <h3 class="nosotros-proceso__card-title">Consultoría inicial</h3>
          <p class="nosotros-proceso__card-desc">Análisis de necesidades y objetivos del evento</p>
        </div>

        <!-- Card 02 -->
        <div class="nosotros-proceso__card">
          <span class="nosotros-proceso__number">02</span>
          <h3 class="nosotros-proceso__card-title">Diseño y propuesta</h3>
          <p class="nosotros-proceso__card-desc">Desarrollo de propuesta técnica y presupuesto detallado</p>
        </div>

        <!-- Card 03 -->
        <div class="nosotros-proceso__card">
          <span class="nosotros-proceso__number">03</span>
          <h3 class="nosotros-proceso__card-title">Planificación</h3>
          <p class="nosotros-proceso__card-desc">Cronograma de instalación y coordinación logística</p>
        </div>

        <!-- Card 04 -->
        <div class="nosotros-proceso__card">
          <span class="nosotros-proceso__number">04</span>
          <h3 class="nosotros-proceso__card-title">Implementación</h3>
          <p class="nosotros-proceso__card-desc">Instalación, pruebas y puesta en marcha</p>
        </div>
      </div>
    </div>
  </section>

  <!-- CLIENTES — Logos -->
  <section class="nosotros-clientes">
    <div class="container">
      <div class="clients__row" aria-label="Logos de clientes (ficticios)">
        <div class="logo logo--bcp">BCP</div>
        <div class="logo logo--ipsos">Ipsos</div>
        <div class="logo logo--bcp">BCP</div>
        <div class="logo logo--ipsos">Ipsos</div>
        <div class="logo logo--bcp">BCP</div>
        <div class="logo logo--bcp">BCP</div>
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

  <!-- CONTENIDO NOSOTROS -->
  <main class="nosotros" id="nosotros">
    <div class="container">
      <?php
      if ( have_posts() ) :
        while ( have_posts() ) :
          the_post();
          the_content();
        endwhile;
      endif;
      ?>
    </div>
  </main>

<?php
get_footer();
