<?php
/**
 * Template Name: Productos
 * Description: Listado de productos ECHOS.
 *
 * @package Echos
 */

get_header();

$img  = get_template_directory_uri() . '/assets/img/inicio/';
$home = esc_url( home_url( '/' ) );
?>

  <!-- TOPBAR / NAVEGACIÓN -->
  <header class="prod-header">
    <div class="topbar topbar--static">
      <div class="container topbar__inner">
        <a class="brand" href="<?php echo $home; ?>">
          <img class="brand__logo" src="<?php echo $img; ?>logo.png" alt="ECHOS" />
          <span class="sr-only">ECHOS — Infraestructura para eventos</span>
        </a>

        <nav class="nav">
          <a href="<?php echo $home; ?>#servicios">Servicios</a>
          <a href="<?php echo get_permalink(); ?>" class="nav--active">Productos</a>
          <a href="<?php echo $home; ?>#proyectos">Proyectos</a>
          <a href="<?php echo $home; ?>#conocenos">Conócenos</a>
        </nav>

        <a class="cta" href="<?php echo $home; ?>#contacto">
          <span>Cotiza tu proyecto</span>
          <span class="cta__icon" aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </header>

  <!-- TÍTULO DE SECCIÓN -->
  <section class="productos-hero">
    <div class="productos-hero__bg" aria-hidden="true"></div>
    <div class="container productos-hero__inner">
      <h1 class="productos-hero__title">NUESTROS PRODUCTOS</h1>
      <p class="productos-hero__desc">
        Descubre nuestra línea completa de soluciones tecnológicas para eventos y espectáculos.
      </p>
    </div>
  </section>

  <!-- GRID DE PRODUCTOS -->
  <section class="productos-grid-section">
    <div class="container">
      <div class="productos-grid">

        <!-- Card 1 -->
        <a href="#" class="producto-card">
          <img src="<?php echo $img; ?>baner1.jpg" alt="Esfera Kinetic" class="producto-card__img" />
          <div class="producto-card__info">
            <div class="producto-card__text">
              <strong>Esfera Kinetic</strong>
              <p>Esfera cinética interactiva que se expande, gira y fluye con animaciones LED.</p>
            </div>
            <span class="producto-card__btn" aria-label="Ver producto">+</span>
          </div>
        </a>

        <!-- Card 2 -->
        <a href="#" class="producto-card">
          <img src="<?php echo $img; ?>baner1.jpg" alt="Sistema Trust Aluminio" class="producto-card__img" />
          <div class="producto-card__info">
            <div class="producto-card__text">
              <strong>Sistema Trust Aluminio</strong>
              <p>Estructura modular de aluminio para montajes escénicos de gran formato.</p>
            </div>
            <span class="producto-card__btn" aria-label="Ver producto">+</span>
          </div>
        </a>

        <!-- Card 3 -->
        <a href="#" class="producto-card">
          <img src="<?php echo $img; ?>baner1.jpg" alt="Panel LED" class="producto-card__img" />
          <div class="producto-card__info">
            <div class="producto-card__text">
              <strong>Panel LED</strong>
              <p>Pantallas LED de alta resolución ideales para conciertos y eventos corporativos.</p>
            </div>
            <span class="producto-card__btn" aria-label="Ver producto">+</span>
          </div>
        </a>

        <!-- Card 4 -->
        <a href="#" class="producto-card">
          <img src="<?php echo $img; ?>baner1.jpg" alt="Pantalla Holográfica" class="producto-card__img" />
          <div class="producto-card__info">
            <div class="producto-card__text">
              <strong>Pantalla Holográfica</strong>
              <p>Tecnología holográfica transparente para experiencias inmersivas y futuristas.</p>
            </div>
            <span class="producto-card__btn" aria-label="Ver producto">+</span>
          </div>
        </a>

        <!-- Card 5 -->
        <a href="#" class="producto-card">
          <img src="<?php echo $img; ?>baner1.jpg" alt="Iluminación Robótica" class="producto-card__img" />
          <div class="producto-card__info">
            <div class="producto-card__text">
              <strong>Iluminación Robótica</strong>
              <p>Cabezas móviles y luminarias inteligentes con control DMX de alta precisión.</p>
            </div>
            <span class="producto-card__btn" aria-label="Ver producto">+</span>
          </div>
        </a>

        <!-- Card 6 -->
        <a href="#" class="producto-card">
          <img src="<?php echo $img; ?>baner1.jpg" alt="Sistema de Audio" class="producto-card__img" />
          <div class="producto-card__info">
            <div class="producto-card__text">
              <strong>Sistema de Audio</strong>
              <p>Equipos de sonido profesional line array para cobertura de alta fidelidad.</p>
            </div>
            <span class="producto-card__btn" aria-label="Ver producto">+</span>
          </div>
        </a>

        <!-- Card 7 -->
        <a href="#" class="producto-card">
          <img src="<?php echo $img; ?>baner1.jpg" alt="Piso LED Interactivo" class="producto-card__img" />
          <div class="producto-card__info">
            <div class="producto-card__text">
              <strong>Piso LED Interactivo</strong>
              <p>Superficie LED con sensores de presión para experiencias interactivas únicas.</p>
            </div>
            <span class="producto-card__btn" aria-label="Ver producto">+</span>
          </div>
        </a>

        <!-- Card 8 -->
        <a href="#" class="producto-card">
          <img src="<?php echo $img; ?>baner1.jpg" alt="Mapping Proyección" class="producto-card__img" />
          <div class="producto-card__info">
            <div class="producto-card__text">
              <strong>Mapping Proyección</strong>
              <p>Video mapping sobre superficies arquitectónicas con proyectores de alta potencia.</p>
            </div>
            <span class="producto-card__btn" aria-label="Ver producto">+</span>
          </div>
        </a>

      </div>
    </div>
  </section>

  <!-- CTA FINAL -->
  <section class="productos-cta">
    <div class="container">
      <div class="productos-cta__card">
        <h2 class="productos-cta__title">¿LISTO PARA COMENZAR?</h2>
        <p class="productos-cta__text">Todo gran proyecto comienza con una conversación.</p>
        <div class="productos-cta__buttons">
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
