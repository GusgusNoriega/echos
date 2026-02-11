<?php require_once __DIR__ . '/header.php'; ?>


  <!-- CLIENTES -->
  <section class="clients" id="clientes">
    <div class="container">
      <h2 class="section-title center">NUESTROS CLIENTES</h2>
      <p class="section-sub center">
        Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla
      </p>

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

  <!-- QUIENES SOMOS -->
  <section class="dark-block" id="conocenos">
    <div class="container who">
      <div class="who__left">
        <h2 class="who__title">¿QUIENES SOMOS?</h2>
        <p class="who__text">
          Somos una empresa de infraestructura para eventos, brindamos soluciones efectivas, creativas
          en diseño y estructuración de eventos corporativos y sociales.
        </p>

        <a class="btn btn--orange" href="#conocenos">
          <span>Conócenos</span>
          <span class="btn__icon" aria-hidden="true">→</span>
        </a>
      </div>

      <div class="who__right">
        <div class="photo-card">
          <div class="photo-card__img" aria-hidden="true"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- PROYECTOS -->
  <section class="projects" id="proyectos">
    <div class="container">
      <div class="projects__head">
        <div>
          <h2 class="section-title">NUESTROS PROYECTOS</h2>
          <p class="section-sub">
            Mira cómo convertimos espacios en experiencias extraordinarias.
          </p>
        </div>

        <div class="projects__arrows">
          <button class="icon-btn" type="button" id="projPrev" aria-label="Anterior">←</button>
          <button class="icon-btn" type="button" id="projNext" aria-label="Siguiente">→</button>
        </div>
      </div>

      <div class="projects__rail" id="projectsRail" aria-label="Carrusel de proyectos">
        <!-- Card 1 -->
        <article class="proj-card">
          <div class="proj-card__media media media--blue">
            <span class="chip">Eventos</span>
          </div>
          <div class="proj-card__meta">
            <div>
              <div class="proj-card__title">BCP Lanzamiento</div>
              <div class="proj-card__date">05 de junio, 2025</div>
            </div>
            <button class="proj-card__go" type="button" aria-label="Ver proyecto">↗</button>
          </div>
        </article>

        <!-- Card 2 -->
        <article class="proj-card">
          <div class="proj-card__media media media--red">
            <span class="chip">Eventos</span>
          </div>
          <div class="proj-card__meta">
            <div>
              <div class="proj-card__title">BCP Lanzamiento</div>
              <div class="proj-card__date">05 de junio, 2025</div>
            </div>
            <button class="proj-card__go" type="button" aria-label="Ver proyecto">↗</button>
          </div>
        </article>

        <!-- Card 3 -->
        <article class="proj-card">
          <div class="proj-card__media media media--green">
            <span class="chip">Entretenimiento</span>
          </div>
          <div class="proj-card__meta">
            <div>
              <div class="proj-card__title">Ecoferia Madre Tierra</div>
              <div class="proj-card__date">05 de junio, 2025</div>
            </div>
            <button class="proj-card__go" type="button" aria-label="Ver proyecto">↗</button>
          </div>
        </article>

        <!-- Card 4 -->
        <article class="proj-card">
          <div class="proj-card__media media media--purple">
            <span class="chip">Eventos</span>
          </div>
          <div class="proj-card__meta">
            <div>
              <div class="proj-card__title">BCP Lanzamiento</div>
              <div class="proj-card__date">05 de junio, 2025</div>
            </div>
            <button class="proj-card__go" type="button" aria-label="Ver proyecto">↗</button>
          </div>
        </article>
      </div>

      <div class="projects__cta">
        <a class="btn btn--orange" href="#proyectos">
          <span>Ver todos los proyectos</span>
          <span class="btn__icon" aria-hidden="true">→</span>
        </a>
      </div>
    </div>
  </section>

  <!-- SERVICIOS -->
  <section class="dark-block" id="servicios">
    <div class="container services">
      <div class="services__left">
        <h2 class="section-title section-title--light">NUESTROS SERVICIOS</h2>
        <p class="section-sub section-sub--light">
          Lorem ipsum dolor sit amet consectetur. Enim suspendisse eget viverra integer tortor morbi bi
        </p>

        <a class="btn btn--orange" href="#servicios">
          <span>Ver todos los servicios</span>
          <span class="btn__icon" aria-hidden="true">→</span>
        </a>
      </div>

      <div class="services__right" aria-label="Lista de servicios">
        <a class="service-item" href="#contacto">
          <div class="service-item__thumb thumb thumb--stage" aria-hidden="true"></div>
          <div class="service-item__label">Infraestructura</div>
          <div class="service-item__arrow" aria-hidden="true">↗</div>
        </a>

        <a class="service-item" href="#contacto">
          <div class="service-item__thumb thumb thumb--lights" aria-hidden="true"></div>
          <div class="service-item__label">Iluminación inteligente</div>
          <div class="service-item__arrow" aria-hidden="true">↗</div>
        </a>

        <a class="service-item" href="#contacto">
          <div class="service-item__thumb thumb thumb--booth" aria-hidden="true"></div>
          <div class="service-item__label">Stands para ferias</div>
          <div class="service-item__arrow" aria-hidden="true">↗</div>
        </a>
      </div>
    </div>
  </section>

  <!-- CONTACTO -->
  <section class="contact" id="contacto">
    <div class="container">
      <div class="contact__panel">
        <div class="contact__left">
          <h2 class="contact__title">CUENTANOS SOBRE<br />TU PROYECTO</h2>
          <p class="contact__text">
            Únete a nosotros y haz que tu próxima activación brille con propósito e impacto.
          </p>

          <div class="contact__actions">
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

        <div class="contact__right">
          <div class="form-card">
            <div class="form-card__hint">Selecciona el servicio en el que estás interesado</div>

            <div class="tabs" role="tablist" aria-label="Servicios">
              <button class="tab is-active" type="button" data-service="Infraestructura">Infraestructura</button>
              <button class="tab" type="button" data-service="Iluminación">Iluminación</button>
              <button class="tab" type="button" data-service="Stands">Stands</button>
            </div>

            <form id="quoteForm" class="form">
              <input class="input" name="nombre" placeholder="Nombre" required />
              <input class="input" name="empresa" placeholder="Empresa" required />
              <input class="input" name="email" placeholder="Email corporativo" type="email" required />
              <input class="input" name="telefono" placeholder="Teléfono" />
              <textarea class="textarea" name="detalle" placeholder="Cuéntanos sobre su evento y necesidades específicas"></textarea>

              <input type="hidden" name="servicio" id="servicioElegido" value="Infraestructura" />

              <div class="form__footer">
                <button class="btn btn--orange btn--wide" type="submit">
                  <span>Enviar mis datos</span>
                  <span class="btn__icon" aria-hidden="true">→</span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  
<?php require_once __DIR__ . '/footer.php'; ?>
