<?php
/**
 * Template Name: Contacto
 * Description: Página de contacto de ECHOS — formulario de cotización.
 *
 * @package Echos
 */

get_header();

$img  = get_template_directory_uri() . '/assets/img/inicio/';
$home = esc_url( home_url( '/' ) );
?>

<div class="contacto-page">

  <!-- TOPBAR / NAVEGACIÓN -->
  <header class="contacto-header">
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

  <!-- SECCIÓN CONTACTO -->
  <section class="contacto-section">
    <!-- Decoración geométrica inferior izquierda -->
    <div class="contacto-deco" aria-hidden="true"></div>

    <div class="container">
      <div class="contacto-grid">

        <!-- LADO IZQUIERDO -->
        <div class="contacto-left">
          <h1 class="contacto-title">DEJANOS CONOCER LOS DETALLES DE TU PROYECTO</h1>

          <p class="contacto-desc">
            Selecciona el servicio en el que estás interesado y rellene sus datos de contacto completos.
          </p>

          <div class="contacto-actions">
            <a class="contacto-pill" href="https://wa.me/" target="_blank" rel="noopener">
              <span>Conversemos ahora</span>
              <span class="contacto-pill__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="currentColor">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                  <path d="M12 0C5.373 0 0 5.373 0 12c0 2.025.507 3.932 1.396 5.608L.05 23.708a.6.6 0 00.735.728L6.53 22.64A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.6a9.56 9.56 0 01-5.175-1.516l-.372-.222-3.843.985 1.028-3.752-.243-.387A9.56 9.56 0 012.4 12c0-5.302 4.298-9.6 9.6-9.6s9.6 4.298 9.6 9.6-4.298 9.6-9.6 9.6z"/>
                </svg>
              </span>
            </a>

            <a class="contacto-pill" href="mailto:contacto@echosperu.com.pe">
              <span>echosperu.com.pe</span>
              <span class="contacto-pill__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="4" width="20" height="16" rx="2"/>
                  <path d="M22 4L12 13 2 4"/>
                </svg>
              </span>
            </a>
          </div>

          <div class="contacto-social">
            <div class="contacto-social-label">¡Síguenos en redes sociales!</div>
            <div class="contacto-social-icons" aria-label="Redes sociales">
              <!-- Instagram -->
              <a href="#" aria-label="Instagram">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="2" y="2" width="20" height="20" rx="5"/>
                  <circle cx="12" cy="12" r="5"/>
                  <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor" stroke="none"/>
                </svg>
              </a>
              <!-- Facebook -->
              <a href="#" aria-label="Facebook">
                <svg viewBox="0 0 24 24" fill="currentColor">
                  <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
              </a>
              <!-- TikTok -->
              <a href="#" aria-label="TikTok">
                <svg viewBox="0 0 24 24" fill="currentColor">
                  <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 00-.79-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 0010.86 4.48V13a8.28 8.28 0 005.58 2.15V11.7a4.83 4.83 0 01-3.77-1.24V6.69h3.77z"/>
                </svg>
              </a>
              <!-- LinkedIn -->
              <a href="#" aria-label="LinkedIn">
                <svg viewBox="0 0 24 24" fill="currentColor">
                  <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>

        <!-- LADO DERECHO (FORMULARIO) -->
        <div class="contacto-form-wrap">
          <div class="contacto-form-hint">Selecciona el servicio en el que estás interesado</div>

          <div class="contacto-tabs" role="tablist" aria-label="Servicios">
            <button class="contacto-tab" type="button" data-service="Infraestructura">Infraestructura</button>
            <button class="contacto-tab is-active" type="button" data-service="Iluminación">Iluminación</button>
            <button class="contacto-tab" type="button" data-service="Stands">Stands</button>
          </div>

          <form id="contactoForm" class="contacto-form" novalidate>
            <input class="contacto-input" name="nombre" placeholder="Nombre" autocomplete="name" required />
            <input class="contacto-input" name="empresa" placeholder="Empresa" autocomplete="organization" required />
            <input class="contacto-input" name="email" placeholder="Email corporativo" type="email" autocomplete="email" required />
            <input class="contacto-input" name="telefono" placeholder="Teléfono" type="tel" autocomplete="tel" />
            <textarea class="contacto-textarea" name="detalle" placeholder="Cuéntenos sobre su evento y necesidades específicas"></textarea>

            <input type="hidden" name="servicio" id="contactoServicio" value="Iluminación" />

            <div class="contacto-form__footer">
              <button class="contacto-submit" type="submit">
                <span>Enviar mis datos</span>
                <span class="contacto-submit__icon" aria-hidden="true">→</span>
              </button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>

</div>

<?php
get_footer( 'contacto' );
