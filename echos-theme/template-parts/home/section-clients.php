<?php
/**
 * Home section: Clients.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$clients = isset( $args['clients'] ) && is_array( $args['clients'] ) ? $args['clients'] : array();
$logos   = isset( $clients['logos'] ) && is_array( $clients['logos'] ) ? $clients['logos'] : array();
?>
<section class="clients" id="clientes">
	<div class="container">
		<h2 class="section-title center"><?php echo esc_html( isset( $clients['title'] ) ? $clients['title'] : '' ); ?></h2>
		<p class="section-sub center"><?php echo esc_html( isset( $clients['subtitle'] ) ? $clients['subtitle'] : '' ); ?></p>

		<div class="clients__row" aria-label="Logos de clientes">
			<?php foreach ( $logos as $logo ) : ?>
				<?php
				$image      = echos_home_resolve_image_url( isset( $logo['image'] ) ? $logo['image'] : '' );
				$alt        = isset( $logo['alt'] ) ? $logo['alt'] : '';
				$logo_class = isset( $logo['logo_class'] ) ? (string) $logo['logo_class'] : '';
				$classes    = array( 'clients__logo' );

				if ( '' !== trim( $logo_class ) ) {
					foreach ( preg_split( '/\s+/', trim( $logo_class ) ) as $extra_class ) {
						$classes[] = sanitize_html_class( $extra_class );
					}
				}
				?>
				<img class="<?php echo esc_attr( implode( ' ', array_filter( $classes ) ) ); ?>" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" loading="lazy" />
			<?php endforeach; ?>
		</div>
	</div>
</section>
