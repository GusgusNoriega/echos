<?php
/**
 * Home section: Hero.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero   = isset( $args['hero'] ) && is_array( $args['hero'] ) ? $args['hero'] : array();
$slides = isset( $hero['slides'] ) && is_array( $hero['slides'] ) ? $hero['slides'] : array();

if ( empty( $slides ) ) {
	return;
}

$cta_url = ! empty( $hero['cta_url'] ) ? $hero['cta_url'] : '#contacto';
?>
<header class="hero" id="hero">
	<div class="hero__viewport" id="heroViewport" aria-label="Slider principal">
		<?php foreach ( $slides as $slide ) : ?>
			<?php
			$image       = echos_home_resolve_image_url( isset( $slide['image'] ) ? $slide['image'] : '' );
			$accent      = isset( $slide['accent'] ) ? $slide['accent'] : '';
			$title       = isset( $slide['title'] ) ? $slide['title'] : '';
			$description = isset( $slide['description'] ) ? $slide['description'] : '';
			?>
			<article class="hero__slide" style="--hero-image: url('<?php echo esc_url( $image ); ?>');">
				<div class="hero__bg" aria-hidden="true"></div>
				<div class="container hero__content">
					<div class="hero__copy">
						<h1 class="hero__title">
							<?php if ( '' !== trim( (string) $accent ) ) : ?>
								<span class="hero__title--accent"><?php echo esc_html( $accent ); ?></span><br />
							<?php endif; ?>
							<?php echo wp_kses_post( echos_home_multiline_text( $title ) ); ?>
						</h1>
						<p class="hero__desc"><?php echo esc_html( $description ); ?></p>
					</div>
				</div>
			</article>
		<?php endforeach; ?>
	</div>

	<div class="hero__overlay" aria-hidden="true"></div>

	<?php get_template_part( 'template-parts/topbar', null, array( 'cta_url' => $cta_url ) ); ?>

	<div class="hero__dots" role="tablist" aria-label="Slider">
		<?php foreach ( $slides as $index => $slide ) : ?>
			<button class="dot <?php echo 0 === $index ? 'is-active' : ''; ?>" type="button" aria-label="Slide <?php echo esc_attr( $index + 1 ); ?>" data-slide="<?php echo esc_attr( $index ); ?>"></button>
		<?php endforeach; ?>
	</div>
</header>
