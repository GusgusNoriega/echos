<?php
/**
 * Template Part: Topbar Navigation
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$defaults = array(
    'modifier'  => '',
    'cta_url'   => home_url( '/#contacto' ),
    'cta_label' => __( 'Cotiza tu proyecto', 'echos' ),
);

$args = wp_parse_args( isset( $args ) && is_array( $args ) ? $args : array(), $defaults );

$img  = get_template_directory_uri() . '/assets/img/inicio/';
$home = esc_url( home_url( '/' ) );

$topbar_classes = array( 'topbar' );

if ( ! empty( $args['modifier'] ) && is_string( $args['modifier'] ) ) {
    $extra_classes = preg_split( '/\s+/', trim( $args['modifier'] ) );
    $extra_classes = array_filter( $extra_classes );

    foreach ( $extra_classes as $class_name ) {
        $topbar_classes[] = sanitize_html_class( $class_name );
    }
}
?>
<div class="<?php echo esc_attr( implode( ' ', $topbar_classes ) ); ?>">
    <div class="container topbar__inner">
        <a class="brand" href="<?php echo $home; ?>">
            <img class="brand__logo" src="<?php echo esc_url( $img . 'logo.png' ); ?>" alt="ECHOS" />
            <span class="sr-only"><?php esc_html_e( 'ECHOS - Infraestructura para eventos', 'echos' ); ?></span>
        </a>

        <nav class="nav" aria-label="<?php esc_attr_e( 'Navegacion principal', 'echos' ); ?>">
            <?php if ( has_nav_menu( 'primary' ) ) : ?>
                <?php
                wp_nav_menu(
                    array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'nav__list',
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    )
                );
                ?>
            <?php else : ?>
                <ul class="nav__list">
                    <li><a href="<?php echo esc_url( $home . '#servicios' ); ?>">Servicios</a></li>
                    <li><a href="<?php echo esc_url( $home . '#proyectos' ); ?>">Proyectos</a></li>
                    <li><a href="<?php echo esc_url( $home . '#conocenos' ); ?>">Conocenos</a></li>
                </ul>
            <?php endif; ?>
        </nav>

        <a class="cta" href="<?php echo esc_url( $args['cta_url'] ); ?>">
            <span><?php echo esc_html( $args['cta_label'] ); ?></span>
            <span class="cta__icon" aria-hidden="true"><svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg></span>
        </a>
    </div>
</div>
