<?php
/**
 * Template Part: Sidebar Menu + Hamburger Button
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$img  = get_template_directory_uri() . '/assets/img/inicio/';
$home = esc_url( home_url( '/' ) );
?>

<button
  class="echos-hamburger"
  id="echosHamburger"
  type="button"
  aria-label="Abrir menu"
  aria-expanded="false"
  aria-controls="echosSidebar"
>
  <span class="echos-hamburger__icon">
    <span class="echos-hamburger__bar"></span>
    <span class="echos-hamburger__bar"></span>
    <span class="echos-hamburger__bar"></span>
  </span>
</button>

<div class="echos-sidebar-backdrop" id="echosSidebarBackdrop" aria-hidden="true"></div>

<aside class="echos-sidebar" id="echosSidebar" aria-hidden="true" role="navigation" aria-label="Menu principal">
  <div class="echos-sidebar__header">
    <a href="<?php echo $home; ?>">
      <img class="echos-sidebar__logo" src="<?php echo esc_url( $img . 'logo.png' ); ?>" alt="ECHOS" />
    </a>
    <button class="echos-sidebar__close" id="echosSidebarClose" type="button" aria-label="Cerrar menu">
      &times;
    </button>
  </div>

  <div class="echos-sidebar__nav">
    <?php
    if ( has_nav_menu( 'primary' ) ) :
      wp_nav_menu(
        array(
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'echos-sidebar-menu',
          'depth'          => 3,
          'walker'         => new Echos_Sidebar_Walker(),
          'fallback_cb'    => false,
        )
      );
    else :
    ?>
      <ul class="echos-sidebar-menu">
        <li><a href="<?php echo $home; ?>">Inicio</a></li>
        <li class="menu-item-has-children">
          <a href="<?php echo $home; ?>#servicios">Servicios
            <button class="echos-submenu-toggle" type="button" aria-label="Expandir submenu">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9" /></svg>
            </button>
          </a>
          <ul>
            <li><a href="#">Infraestructura</a></li>
            <li><a href="#">Iluminacion</a></li>
            <li><a href="#">Stands para ferias</a></li>
          </ul>
        </li>
        <li><a href="<?php echo $home; ?>#proyectos">Proyectos</a></li>
        <li><a href="<?php echo $home; ?>#conocenos">Conocenos</a></li>
        <li><a href="<?php echo $home; ?>#contacto">Contacto</a></li>
      </ul>
    <?php endif; ?>
  </div>

  <div class="echos-sidebar__footer">
    <a class="echos-sidebar__cta" href="<?php echo $home; ?>#contacto">
      <span>Cotiza tu proyecto</span>
      <span class="echos-sidebar__cta-arrow" aria-hidden="true">
        <svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
      </span>
    </a>
    <div class="echos-sidebar__social">
      <a href="#" aria-label="Instagram">IG</a>
      <a href="#" aria-label="Facebook">FB</a>
      <a href="#" aria-label="TikTok">TT</a>
      <a href="#" aria-label="LinkedIn">IN</a>
    </div>
  </div>
</aside>
