<footer class="footer">
    <div class="container">
      <div class="footer__panel">
        <div class="footer__top">
          <div class="footer__social">
            <div class="footer__label">¡Síguenos en nuestras<br />redes sociales!</div>
            <div class="footer__icons" aria-label="Redes sociales">
              <a href="#" class="soc" aria-label="Instagram">◯</a>
              <a href="#" class="soc" aria-label="Facebook">◯</a>
              <a href="#" class="soc" aria-label="TikTok">◯</a>
              <a href="#" class="soc" aria-label="LinkedIn">◯</a>
            </div>
          </div>

          <div class="footer__links">
            <div class="col">
              <div class="col__title">ECHOS</div>
              <a href="#clientes">Productos</a>
              <a href="#servicios">Servicios</a>
              <a href="#proyectos">Proyectos</a>
              <a href="#conocenos">Conócenos</a>
            </div>
            <div class="col">
              <div class="col__title">Legal</div>
              <a href="#">Políticas de Privacidad</a>
              <a href="#">Términos y condiciones</a>
            </div>
          </div>
        </div>

        <div class="footer__brand" aria-hidden="true">
          <div class="mega-logo">
            <img src="img/inicio/logo-footer.png" class="logo-footer" alt="">
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- POPUP (sección interna aislada) -->
  <section class="epopup" id="epopup" aria-hidden="true">
    <div class="epopup__backdrop" data-epopup-close aria-hidden="true"></div>

    <div class="epopup__dialog" role="dialog" aria-modal="true" aria-labelledby="epopupTitle" >
      <button class="epopup__close" type="button" aria-label="Cerrar" data-epopup-close>
        ×
      </button>

      <div class="epopup__grid">
        <div class="epopup__media" aria-hidden="true">
          <img class="epopup__img" src="img/popup/image-popup.jpg" alt="" loading="lazy" />
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
              <span class="sr-only">Correo electrónico</span>
              <input
                class="epopup__input"
                type="email"
                name="email"
                placeholder="Ingresa tu correo electrónico"
                autocomplete="email"
                required
              />
            </label>

            <button class="epopup__btn" type="submit">
              <span>Suscribirme</span>
              <span class="epopup__btnIcon" aria-hidden="true">→</span>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <script src="app.js"></script>
  <script src="popup.js"></script>
</body>
</html>
