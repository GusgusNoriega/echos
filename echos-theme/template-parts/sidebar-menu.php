<?php
/**
 * Template Part: Sidebar Menu + Hamburger Button
 * Se incluye en todos los templates vía get_template_part().
 *
 * El menú se administra desde:  Apariencia → Menús → "Menú Principal"
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$img = get_template_directory_uri() . '/assets/img/inicio/';
$home = esc_url( home_url( '/' ) );
?>

<!-- Botón Hamburguesa (fijo inferior izquierdo) -->
<button
  class="echos-hamburger"
  id="echosHamburger"
  type="button"
  aria-label="Abrir menú"
  aria-expanded="false"
  aria-controls="echosSidebar"
>
  <span class="echos-hamburger__icon">
    <span class="echos-hamburger__bar"></span>
    <span class="echos-hamburger__bar"></span>
    <span class="echos-hamburger__bar"></span>
  </span>
</button>

<!-- Backdrop -->
<div class="echos-sidebar-backdrop" id="echosSidebarBackdrop" aria-hidden="true"></div>

<!-- Sidebar Panel -->
<aside class="echos-sidebar" id="echosSidebar" aria-hidden="true" role="navigation" aria-label="Menú principal">

  <!-- Header del sidebar -->
  <div class="echos-sidebar__header">
    <a href="<?php echo $home; ?>">
      <img class="echos-sidebar__logo" src="<?php echo $img; ?>logo.png" alt="ECHOS" />
    </a>
    <button class="echos-sidebar__close" id="echosSidebarClose" type="button" aria-label="Cerrar menú">
      ×
    </button>
  </div>

  <!-- Navegación administrable -->
  <div class="echos-sidebar__nav">
    <?php
    if ( has_nav_menu( 'primary' ) ) :
      wp_nav_menu( array(
        'theme_location' => 'primary',
        'container'      => false,
        'menu_class'     => 'echos-sidebar-menu',
        'depth'          => 3,
        'walker'         => new Echos_Sidebar_Walker(),
        'fallback_cb'    => false,
      ) );
    else :
      // Menú fallback si no se ha configurado uno desde WP admin
    ?>
      <ul class="echos-sidebar-menu">
        <li><a href="<?php echo $home; ?>">Inicio</a></li>
        <li class="menu-item-has-children">
          <a href="<?php echo $home; ?>#servicios">Servicios
            <button class="echos-submenu-toggle" type="button" aria-label="Expandir sub-menú">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
          </a>
          <ul>
            <li><a href="#">Infraestructura</a></li>
            <li><a href="#">Iluminación</a></li>
            <li><a href="#">Stands para Ferias</a></li>
          </ul>
        </li>
        <li><a href="<?php echo $home; ?>#proyectos">Proyectos</a></li>
        <li><a href="<?php echo $home; ?>#conocenos">Conócenos</a></li>
        <li><a href="<?php echo $home; ?>#contacto">Contacto</a></li>
      </ul>
    <?php endif; ?>
  </div>

  <!-- Footer del sidebar -->
  <div class="echos-sidebar__footer">
    <a class="echos-sidebar__cta" href="<?php echo $home; ?>#contacto">
      <span>Cotiza tu proyecto</span>
      <span class="echos-sidebar__cta-arrow" aria-hidden="true">→</span>
    </a>
    <div class="echos-sidebar__social">
      <a href="#" aria-label="Instagram">◯</a>
      <a href="#" aria-label="Facebook">◯</a>
      <a href="#" aria-label="TikTok">◯</a>
      <a href="#" aria-label="LinkedIn">◯</a>
    </div>
  </div>

</aside>
