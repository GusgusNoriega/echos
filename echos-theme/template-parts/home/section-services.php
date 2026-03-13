<?php
/**
 * Home section: Services.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$services = isset( $args['services'] ) && is_array( $args['services'] ) ? $args['services'] : array();
$items    = isset( $services['items'] ) && is_array( $services['items'] ) ? $services['items'] : array();
$variants = array( 'stage', 'lights', 'booth' );
?>
<section class="dark-block dark-block--services" id="servicios">
	<div class="container services">
		<div class="services__left">
			<h2 class="section-title section-title--light"><?php echo esc_html( isset( $services['title'] ) ? $services['title'] : '' ); ?></h2>
			<p class="section-sub section-sub--light"><?php echo esc_html( isset( $services['subtitle'] ) ? $services['subtitle'] : '' ); ?></p>

			<a class="btn btn--orange" href="<?php echo esc_url( isset( $services['cta_url'] ) ? $services['cta_url'] : '#servicios' ); ?>">
				<span><?php echo esc_html( isset( $services['cta_text'] ) ? $services['cta_text'] : '' ); ?></span>
				<span class="btn__icon" aria-hidden="true">
					<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
				</span>
			</a>
		</div>

		<div class="services__right" aria-label="Lista de servicios">
			<?php foreach ( $items as $item ) : ?>
				<?php
				$image   = echos_home_resolve_image_url( isset( $item['image'] ) ? $item['image'] : '' );
				$label   = isset( $item['label'] ) ? $item['label'] : '';
				$url     = isset( $item['url'] ) ? $item['url'] : '#';
				$variant = isset( $item['variant'] ) ? sanitize_key( $item['variant'] ) : 'stage';
				if ( ! in_array( $variant, $variants, true ) ) {
					$variant = 'stage';
				}
				?>
				<a class="service-item" href="<?php echo esc_url( $url ); ?>">
					<div class="service-item__thumb thumb thumb--<?php echo esc_attr( $variant ); ?>" aria-hidden="true" style="--thumb-image: url('<?php echo esc_url( $image ); ?>');"></div>
					<div class="service-item__label"><?php echo esc_html( $label ); ?></div>
					<div class="service-item__arrow" aria-hidden="true">
						<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
