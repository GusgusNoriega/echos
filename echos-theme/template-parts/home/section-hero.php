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
		<?php foreach ( $slides as $index => $slide ) : ?>
			<?php
			$image       = echos_home_resolve_image_url( isset( $slide['image'] ) ? $slide['image'] : '' );
			$video_embed = echos_home_build_youtube_embed_url( isset( $slide['video'] ) ? $slide['video'] : '' );
			$accent      = isset( $slide['accent'] ) ? $slide['accent'] : '';
			$title       = isset( $slide['title'] ) ? $slide['title'] : '';
			$description = isset( $slide['description'] ) ? $slide['description'] : '';
			?>
			<article class="hero__slide<?php echo '' !== $video_embed ? ' has-video' : ''; ?>" style="--hero-image: url('<?php echo esc_url( $image ); ?>');">
				<div class="hero__bg" aria-hidden="true"></div>
				<?php if ( '' !== $video_embed ) : ?>
					<div class="hero__video" aria-hidden="true">
						<iframe
							src="<?php echo esc_url( $video_embed ); ?>"
							title="<?php echo esc_attr( sprintf( 'Video de fondo slide %d', $index + 1 ) ); ?>"
							loading="<?php echo 0 === (int) $index ? 'eager' : 'lazy'; ?>"
							allow="autoplay; encrypted-media; picture-in-picture"
							referrerpolicy="strict-origin-when-cross-origin"
							tabindex="-1"
						></iframe>
					</div>
				<?php endif; ?>
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
