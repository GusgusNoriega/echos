<?php
/**
 * Template Name: Proyectos
 * Description: Página de proyectos ECHOS.
 *
 * @package Echos
 */

get_header();

$img  = get_template_directory_uri() . '/assets/img/inicio/';
$home = esc_url( home_url( '/' ) );
?>

  <!-- TOPBAR / NAVEGACIÓN -->
  <header class="proyectos-header">
    <div class="topbar topbar--static">
      <div class="container topbar__inner">
        <a class="brand" href="<?php echo $home; ?>">
          <img class="brand__logo" src="<?php echo $img; ?>logo.png" alt="ECHOS" />
          <span class="sr-only">ECHOS — Infraestructura para eventos</span>
        </a>

        <nav class="nav">
          <a href="<?php echo $home; ?>#servicios">Servicios</a>
          <a href="<?php echo get_permalink(); ?>" class="nav--active">Proyectos</a>
          <a href="<?php echo $home; ?>#conocenos">Conócenos</a>
        </nav>

        <a class="cta" href="<?php echo $home; ?>#contacto">
          <span>Cotiza tu proyecto</span>
          <span class="cta__icon" aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </header>

  <!-- HERO: NUESTROS PROYECTOS -->
  <section class="proyectos-hero">
    <div class="proyectos-hero__bg" aria-hidden="true"></div>
    <div class="container proyectos-hero__inner">
      <h1 class="proyectos-hero__title">
        NUESTROS <span class="proyectos-hero__accent">PROYECTOS</span>
      </h1>
      <p class="proyectos-hero__desc">
        Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam
        lobortis lacus sit. Nulla id massa eget massa.
      </p>
    </div>
  </section>

  <!-- LOS MÁS DESTACADOS — slider -->
  <section class="destacados">
    <div class="container">
      <div class="destacados__head">
        <h2 class="destacados__title">LOS MAS DESTACADOS</h2>
        <div class="destacados__arrows">
          <button class="destacados__arrow destacados__arrow--prev" type="button" aria-label="Anterior">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
          </button>
          <button class="destacados__arrow destacados__arrow--next" type="button" aria-label="Siguiente">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
          </button>
        </div>
      </div>

      <div class="destacados__viewport">
        <div class="destacados__track">

          <!-- Card 1 -->
          <div class="destacados__card">
            <div class="destacados__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
            <div class="destacados__info">
              <div class="destacados__info-text">
                <span class="destacados__name">BCP Lanzamiento</span>
                <span class="destacados__date">05 de junio, 2025</span>
              </div>
              <a href="#" class="destacados__link" aria-label="Ver proyecto">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              </a>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="destacados__card">
            <div class="destacados__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
            <div class="destacados__info">
              <div class="destacados__info-text">
                <span class="destacados__name">BCP Lanzamiento</span>
                <span class="destacados__date">05 de junio, 2025</span>
              </div>
              <a href="#" class="destacados__link" aria-label="Ver proyecto">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              </a>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="destacados__card">
            <div class="destacados__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
            <div class="destacados__info">
              <div class="destacados__info-text">
                <span class="destacados__name">Evento Corporativo</span>
                <span class="destacados__date">12 de mayo, 2025</span>
              </div>
              <a href="#" class="destacados__link" aria-label="Ver proyecto">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              </a>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="destacados__card">
            <div class="destacados__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
            <div class="destacados__info">
              <div class="destacados__info-text">
                <span class="destacados__name">Evento Corporativo</span>
                <span class="destacados__date">12 de mayo, 2025</span>
              </div>
              <a href="#" class="destacados__link" aria-label="Ver proyecto">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              </a>
            </div>
          </div>

          <!-- Card 5 -->
          <div class="destacados__card">
            <div class="destacados__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
            <div class="destacados__info">
              <div class="destacados__info-text">
                <span class="destacados__name">Feria Internacional</span>
                <span class="destacados__date">28 de abril, 2025</span>
              </div>
              <a href="#" class="destacados__link" aria-label="Ver proyecto">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              </a>
            </div>
          </div>

          <!-- Card 6 -->
          <div class="destacados__card">
            <div class="destacados__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
            <div class="destacados__info">
              <div class="destacados__info-text">
                <span class="destacados__name">Feria Internacional</span>
                <span class="destacados__date">28 de abril, 2025</span>
              </div>
              <a href="#" class="destacados__link" aria-label="Ver proyecto">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
              </a>
            </div>
          </div>

        </div>
      </div>

      <div class="destacados__dots"></div>
    </div>
  </section>

  <!-- ÚLTIMOS PROYECTOS — grid con filtros -->
  <section class="ultimos-proyectos">
    <div class="container">
      <h2 class="ultimos-proyectos__title">ULTIMOS PROYECTOS</h2>

      <!-- Filtros -->
      <div class="ultimos-proyectos__filters">
        <button class="ultimos-proyectos__filter is-active" data-filter="todos" type="button">Todos</button>
        <button class="ultimos-proyectos__filter" data-filter="eventos" type="button">Eventos</button>
        <button class="ultimos-proyectos__filter" data-filter="entretenimiento" type="button">Entretenimiento</button>
        <button class="ultimos-proyectos__filter" data-filter="corporativo" type="button">Corporativo</button>
      </div>

      <!-- Grid de cards -->
      <div class="ultimos-proyectos__grid">

        <!-- Card 1 -->
        <article class="up-card" data-category="eventos">
          <div class="up-card__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
          <span class="up-card__badge">Eventos</span>
          <div class="up-card__info">
            <div class="up-card__info-text">
              <span class="up-card__name">BCP Lanzamiento</span>
              <span class="up-card__date">05 de junio, 2025</span>
            </div>
            <a href="#" class="up-card__link" aria-label="Ver proyecto">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </article>

        <!-- Card 2 -->
        <article class="up-card" data-category="entretenimiento">
          <div class="up-card__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
          <span class="up-card__badge">Entretenimiento</span>
          <div class="up-card__info">
            <div class="up-card__info-text">
              <span class="up-card__name">BCP Lanzamiento</span>
              <span class="up-card__date">05 de junio, 2025</span>
            </div>
            <a href="#" class="up-card__link" aria-label="Ver proyecto">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </article>

        <!-- Card 3 -->
        <article class="up-card" data-category="eventos">
          <div class="up-card__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
          <span class="up-card__badge">Eventos</span>
          <div class="up-card__info">
            <div class="up-card__info-text">
              <span class="up-card__name">Ecoferia Madre Tierra</span>
              <span class="up-card__date">05 de junio, 2025</span>
            </div>
            <a href="#" class="up-card__link" aria-label="Ver proyecto">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </article>

        <!-- Card 4 -->
        <article class="up-card" data-category="corporativo">
          <div class="up-card__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
          <span class="up-card__badge">Corporativo</span>
          <div class="up-card__info">
            <div class="up-card__info-text">
              <span class="up-card__name">Congreso Anual</span>
              <span class="up-card__date">15 de mayo, 2025</span>
            </div>
            <a href="#" class="up-card__link" aria-label="Ver proyecto">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </article>

        <!-- Card 5 -->
        <article class="up-card" data-category="eventos">
          <div class="up-card__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
          <span class="up-card__badge">Eventos</span>
          <div class="up-card__info">
            <div class="up-card__info-text">
              <span class="up-card__name">Festival de Luces</span>
              <span class="up-card__date">20 de abril, 2025</span>
            </div>
            <a href="#" class="up-card__link" aria-label="Ver proyecto">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </article>

        <!-- Card 6 -->
        <article class="up-card" data-category="entretenimiento">
          <div class="up-card__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
          <span class="up-card__badge">Entretenimiento</span>
          <div class="up-card__info">
            <div class="up-card__info-text">
              <span class="up-card__name">Show Musical</span>
              <span class="up-card__date">10 de abril, 2025</span>
            </div>
            <a href="#" class="up-card__link" aria-label="Ver proyecto">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </article>

        <!-- Card 7 -->
        <article class="up-card" data-category="corporativo">
          <div class="up-card__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
          <span class="up-card__badge">Corporativo</span>
          <div class="up-card__info">
            <div class="up-card__info-text">
              <span class="up-card__name">Lanzamiento Producto</span>
              <span class="up-card__date">01 de marzo, 2025</span>
            </div>
            <a href="#" class="up-card__link" aria-label="Ver proyecto">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </article>

        <!-- Card 8 -->
        <article class="up-card" data-category="eventos">
          <div class="up-card__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
          <span class="up-card__badge">Eventos</span>
          <div class="up-card__info">
            <div class="up-card__info-text">
              <span class="up-card__name">Gala Benéfica</span>
              <span class="up-card__date">15 de febrero, 2025</span>
            </div>
            <a href="#" class="up-card__link" aria-label="Ver proyecto">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </article>

        <!-- Card 9 -->
        <article class="up-card" data-category="entretenimiento">
          <div class="up-card__img" style="background-image:url('<?php echo $img; ?>baner1.jpg')"></div>
          <span class="up-card__badge">Entretenimiento</span>
          <div class="up-card__info">
            <div class="up-card__info-text">
              <span class="up-card__name">Concierto Sinfónico</span>
              <span class="up-card__date">28 de enero, 2025</span>
            </div>
            <a href="#" class="up-card__link" aria-label="Ver proyecto">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
            </a>
          </div>
        </article>

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
