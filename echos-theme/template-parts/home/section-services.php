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

$default_image = get_template_directory_uri() . '/assets/img/inicio/baner1.jpg';
$items_limit   = ! empty( $items ) ? count( $items ) : 3;
$items_limit   = max( 1, min( 24, absint( $items_limit ) ) );

$service_posts = get_posts(
	array(
		'post_type'      => 'servicio',
		'post_status'    => 'publish',
		'posts_per_page' => $items_limit,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
	)
);

if ( ! empty( $service_posts ) ) {
	$template_variant_map = array(
		'page-templates/template-servicios-infraestructura.php' => 'stage',
		'page-templates/template-servicios-iluminacion.php'     => 'lights',
		'page-templates/template-servicios-stands.php'          => 'booth',
	);

	$dynamic_items = array();

	foreach ( $service_posts as $index => $service_post ) {
		if ( ! $service_post instanceof WP_Post ) {
			continue;
		}

		$service_id    = $service_post->ID;
		$image         = get_the_post_thumbnail_url( $service_id, 'full' );
		$template_slug = get_page_template_slug( $service_id );
		$variant       = isset( $template_variant_map[ $template_slug ] ) ? $template_variant_map[ $template_slug ] : '';

		if ( '' === $variant ) {
			$terms = wp_get_post_terms( $service_id, 'categoria_servicio' );
			if ( ! is_wp_error( $terms ) && ! empty( $terms ) && $terms[0] instanceof WP_Term ) {
				$slug = sanitize_title( $terms[0]->slug );
				if ( false !== strpos( $slug, 'infra' ) ) {
					$variant = 'stage';
				} elseif ( false !== strpos( $slug, 'ilumin' ) || false !== strpos( $slug, 'light' ) ) {
					$variant = 'lights';
				} elseif ( false !== strpos( $slug, 'stand' ) || false !== strpos( $slug, 'feria' ) ) {
					$variant = 'booth';
				}
			}
		}

		if ( '' === $variant ) {
			$variant = $variants[ $index % count( $variants ) ];
		}

		if ( '' === trim( (string) $image ) ) {
			$image = $default_image;
		}

		$dynamic_items[] = array(
			'image'   => $image,
			'label'   => get_the_title( $service_id ),
			'url'     => get_permalink( $service_id ),
			'variant' => $variant,
		);
	}

	if ( ! empty( $dynamic_items ) ) {
		$items = $dynamic_items;
	}
}
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
