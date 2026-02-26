<?php
/**
 * Plantilla base (fallback).
 * WordPress requiere este archivo. Redirige a la portada.
 *
 * @package Echos
 */

get_header();
?>

<main class="echos-main">
  <div class="container" style="padding: 100px 0; text-align: center;">
    <h1>ECHOS</h1>
    <p>Selecciona una página con su plantilla asignada desde el panel de WordPress.</p>
    <a class="btn btn--orange" href="<?php echo esc_url( home_url( '/' ) ); ?>">
      <span>Ir al inicio</span>
      <span class="btn__icon" aria-hidden="true">→</span>
    </a>
  </div>
</main>

<?php
get_footer();
