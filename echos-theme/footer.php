<footer class="footer">
  <div class="container">
    <div class="footer__panel">
      <div class="footer__top">
        <div class="footer__social">
          <div class="footer__label">Siguenos en nuestras<br />redes sociales!</div>
          <div class="footer__icons" aria-label="Redes sociales">
            <a href="#" class="soc" aria-label="Instagram">IG</a>
            <a href="#" class="soc" aria-label="Facebook">FB</a>
            <a href="#" class="soc" aria-label="TikTok">TT</a>
            <a href="#" class="soc" aria-label="LinkedIn">IN</a>
          </div>
        </div>

        <div class="footer__links">
          <div class="col">
            <div class="col__title">ECHOS</div>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>#clientes">Productos</a>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>#servicios">Servicios</a>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>#proyectos">Proyectos</a>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>#conocenos">Conocenos</a>
          </div>
          <div class="col">
            <div class="col__title">Legal</div>
            <a href="#">Politicas de privacidad</a>
            <a href="#">Terminos y condiciones</a>
          </div>
        </div>
      </div>

      <div class="footer__brand" aria-hidden="true">
        <div class="mega-logo">
          <img src="<?php echo echos_asset( 'img/inicio/logo-footer.png' ); ?>" class="logo-footer" alt="ECHOS Logo" />
        </div>
      </div>
    </div>
  </div>
</footer>

<!-- POPUP -->
<section class="epopup" id="epopup" aria-hidden="true">
  <div class="epopup__backdrop" data-epopup-close aria-hidden="true"></div>

  <div class="epopup__dialog" role="dialog" aria-modal="true" aria-labelledby="epopupTitle">
    <button class="epopup__close" type="button" aria-label="Cerrar" data-epopup-close>
      &times;
    </button>

    <div class="epopup__grid">
      <div class="epopup__media" aria-hidden="true">
        <img class="epopup__img" src="<?php echo echos_asset( 'img/popup/image-popup.jpg' ); ?>" alt="" loading="lazy" />
      </div>

      <div class="epopup__content">
        <h2 class="epopup__title" id="epopupTitle">CONSIGUE UN 20%<br />DE DESCUENTO</h2>
        <p class="epopup__text">
          Lorem ipsum dolor sit amet consectetur. Gravida suspendisse quis a quis. Amet rutrum.
        </p>

        <form class="epopup__form" id="epopupForm" novalidate>
          <label class="epopup__field">
            <span class="sr-only">Nombre de empresa</span>
            <input class="epopup__input" name="empresa" placeholder="Nombre de empresa" autocomplete="organization" required />
          </label>

          <label class="epopup__field">
            <span class="sr-only">Correo electronico</span>
            <input
              class="epopup__input"
              type="email"
              name="email"
              placeholder="Ingresa tu correo electronico"
              autocomplete="email"
              required
            />
          </label>

          <button class="epopup__btn" type="submit">
            <span>Suscribirme</span>
            <span class="epopup__btnIcon" aria-hidden="true">
              <svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
            </span>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php get_template_part( 'template-parts/sidebar-menu' ); ?>

<?php wp_footer(); ?>
</body>
</html>
