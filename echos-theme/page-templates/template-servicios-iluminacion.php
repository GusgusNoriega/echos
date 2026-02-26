<?php
/**
 * Template Name: Servicio - Iluminación
 * Description: Página del servicio de Iluminación ECHOS.
 *
 * @package Echos
 */

get_header();

$img  = get_template_directory_uri() . '/assets/img/inicio/';
$home = esc_url( home_url( '/' ) );
?>

  <!-- HEADER / HERO ILUMINACIÓN -->
  <section class="srv-hero">
    <div class="srv-hero__bg" aria-hidden="true"></div>
    <div class="srv-hero__overlay" aria-hidden="true"></div>

    <div class="topbar topbar--srv">
      <div class="container topbar__inner">
        <a class="brand" href="<?php echo $home; ?>">
          <img class="brand__logo" src="<?php echo $img; ?>logo.png" alt="ECHOS" />
          <span class="sr-only">ECHOS — Infraestructura para eventos</span>
        </a>

        <nav class="nav">
          <a href="<?php echo $home; ?>#servicios" class="nav--active">Servicios</a>
          <a href="<?php echo $home; ?>#proyectos">Proyectos</a>
          <a href="<?php echo $home; ?>#conocenos">Conócenos</a>
        </nav>

        <a class="cta" href="<?php echo $home; ?>#contacto">
          <span>Cotiza tu proyecto</span>
          <span class="cta__icon" aria-hidden="true">→</span>
        </a>
      </div>
    </div>

    <div class="srv-hero__content">
      <h1 class="srv-hero__title">ILUMINACION</h1>
      <p class="srv-hero__desc">
        Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla id m
      </p>
      <a class="srv-hero__btn" href="#portafolio">
        <span>Ver portafolio</span>
        <span class="srv-hero__btn-icon" aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 5v14"/>
            <path d="M19 12l-7 7-7-7"/>
          </svg>
        </span>
      </a>
    </div>
  </section>

  <!-- SECCIÓN SISTEMAS (solo texto) -->
  <section class="srv-systems">
    <div class="srv-systems__inner srv-systems__inner--text-only">

      <h2 class="srv-systems__title srv-systems__title--centered">LOREM IPSUM DOLOR</h2>
      <hr class="srv-systems__divider" />

      <div class="srv-systems__paragraphs">
        <p>Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas. Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristi</p>
        <p>Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas. Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristi</p>
        <p>Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas. Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristi</p>
      </div>

    </div>
  </section>

  <!-- SECCIÓN PRODUCTOS -->
  <section class="srv-products">
    <div class="srv-products__deco srv-products__deco--tl" aria-hidden="true"></div>
    <div class="srv-products__deco srv-products__deco--tr" aria-hidden="true"></div>
    <div class="srv-products__deco srv-products__deco--bl" aria-hidden="true"></div>
    <div class="srv-products__deco srv-products__deco--br" aria-hidden="true"></div>

    <div class="srv-products__inner">
      <h2 class="srv-products__title">PRODUCTOS</h2>
      <p class="srv-products__subtitle">Equipamiento de última generación y servicios integrales para eventos de cualquier escala.</p>

      <div class="srv-products__grid">
        <?php for ( $i = 1; $i <= 6; $i++ ) : ?>
        <div class="srv-products__card">
          <div class="srv-products__card-img">
            <img src="<?php echo $img; ?>baner1.jpg" alt="Esfera Kinetic" />
          </div>
          <div class="srv-products__card-label">
            <span>Esfera Kinetic</span>
            <span class="srv-products__card-icon">
              <?php if ( $i === 1 ) : ?>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
              <?php else : ?>
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              <?php endif; ?>
            </span>
          </div>
        </div>
        <?php endfor; ?>
      </div>

      <div class="srv-products__cta-wrap">
        <a class="srv-products__cta" href="#contacto">
          <span>Cotizar servicio</span>
          <span class="srv-products__cta-arrow" aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </section>

  <!-- SECCIÓN SERVICIOS ADICIONALES -->
  <section class="srv-additional">
    <div class="srv-additional__inner">
      <h2 class="srv-additional__title">SERVICIOS ADICIONALES</h2>
      <p class="srv-additional__subtitle">Complementamos nuestros servicio de iluminación con soluciones energéticas confiables para garantizar el suministro eléctrico continuo en su evento.</p>

      <div class="srv-additional__card">
        <div class="srv-additional__card-img">
          <img src="<?php echo $img; ?>baner1.jpg" alt="Grupo Electrógeno" />
        </div>
        <div class="srv-additional__card-body">
          <h3 class="srv-additional__card-title">GRUPO ELECTROGENO</h3>
          <p class="srv-additional__card-desc">Generador de alta potencia para eventos de gran escala y requerimientos energéticos elevados</p>
          <a class="srv-additional__card-btn" href="#contacto">Más información</a>
        </div>
      </div>
    </div>
  </section>

  <!-- SECCIÓN PROYECTOS DESTACADOS -->
  <section class="srv-featured" id="portafolio">
    <div class="srv-featured__inner">

      <div class="srv-featured__header">
        <div class="srv-featured__header-text">
          <h2 class="srv-featured__title">PROYECTOS DESTACADOS</h2>
          <p class="srv-featured__subtitle">Algunos de nuestros trabajos más representativos en diferentes tipos de eventos.</p>
        </div>
        <div class="srv-featured__nav">
          <button class="srv-featured__arrow srv-featured__arrow--prev" aria-label="Anterior">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
          </button>
          <button class="srv-featured__arrow srv-featured__arrow--next" aria-label="Siguiente">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><polyline points="12 5 19 12 12 19"/></svg>
          </button>
        </div>
      </div>

      <div class="srv-featured__slider">
        <div class="srv-featured__track">
          <?php
          $proyectos = array(
            array( 'name' => 'BCP Lanzamiento',      'date' => '05 de junio, 2025',  'badge' => 'Eventos' ),
            array( 'name' => 'BCP Lanzamiento',      'date' => '05 de junio, 2025',  'badge' => 'Entretenimiento' ),
            array( 'name' => 'Ecoferia Madre Tierra', 'date' => '05 de junio, 2025',  'badge' => 'Eventos' ),
            array( 'name' => 'Evento Corporativo',   'date' => '10 de julio, 2025',  'badge' => 'Corporativo' ),
            array( 'name' => 'Festival Musical',     'date' => '20 de agosto, 2025', 'badge' => 'Entretenimiento' ),
          );
          foreach ( $proyectos as $p ) : ?>
          <div class="srv-featured__card">
            <div class="srv-featured__card-img">
              <img src="<?php echo $img; ?>baner1.jpg" alt="<?php echo esc_attr( $p['name'] ); ?>" />
              <span class="srv-featured__badge"><?php echo esc_html( $p['badge'] ); ?></span>
            </div>
            <div class="srv-featured__card-info">
              <div class="srv-featured__card-text">
                <span class="srv-featured__card-name"><?php echo esc_html( $p['name'] ); ?></span>
                <span class="srv-featured__card-date"><?php echo esc_html( $p['date'] ); ?></span>
              </div>
              <span class="srv-featured__card-link">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              </span>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="srv-featured__cta-wrap">
        <a class="srv-featured__cta" href="#proyectos">
          <span>Ver todos los proyectos</span>
          <span class="srv-featured__cta-arrow" aria-hidden="true">→</span>
        </a>
      </div>

    </div>
  </section>

  <!-- SECCIÓN OTROS SERVICIOS -->
  <section class="srv-other">
    <div class="srv-other__inner">
      <h2 class="srv-other__title">OTROS SERVICIOS QUE PODRIAN INTERESARTE</h2>

      <div class="srv-other__grid">
        <a href="#" class="srv-other__card">
          <div class="srv-other__card-bg srv-other__card-bg--iluminacion" aria-hidden="true"></div>
          <div class="srv-other__card-content">
            <h3 class="srv-other__card-title">ILUMINACION</h3>
            <p class="srv-other__card-desc">Lorem ipsum dolor sit amet consectetur. In donec id tortor s</p>
          </div>
          <span class="srv-other__card-arrow" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
          </span>
        </a>

        <a href="#" class="srv-other__card">
          <div class="srv-other__card-bg srv-other__card-bg--stands" aria-hidden="true"></div>
          <div class="srv-other__card-content">
            <h3 class="srv-other__card-title">STANDS PARA FERIAS</h3>
            <p class="srv-other__card-desc">Lorem ipsum dolor sit amet consectetur. In donec id tortor s</p>
          </div>
          <span class="srv-other__card-arrow" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
          </span>
        </a>
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
