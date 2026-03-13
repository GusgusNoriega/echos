<?php
/**
 * Home section: About.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$about      = isset( $args['about'] ) && is_array( $args['about'] ) ? $args['about'] : array();
$title      = isset( $about['title'] ) ? $about['title'] : '';
$text       = isset( $about['text'] ) ? $about['text'] : '';
$button     = isset( $about['button_text'] ) ? $about['button_text'] : '';
$button_url = ! empty( $about['button_url'] ) ? $about['button_url'] : '#conocenos';
$image      = echos_home_resolve_image_url( isset( $about['image'] ) ? $about['image'] : '' );
?>
<section class="dark-block dark-block--who" id="conocenos">
	<div class="container who">
		<div class="who__left">
			<h2 class="who__title"><?php echo esc_html( $title ); ?></h2>
			<p class="who__text"><?php echo esc_html( $text ); ?></p>

			<a class="btn btn--orange" href="<?php echo esc_url( $button_url ); ?>">
				<span><?php echo esc_html( $button ); ?></span>
				<span class="btn__icon" aria-hidden="true">
					<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
				</span>
			</a>
		</div>

		<div class="who__right">
			<div class="photo-card">
				<div class="photo-card__img" aria-hidden="true" style="background-image: url('<?php echo esc_url( $image ); ?>');"></div>
			</div>
		</div>
	</div>
</section>
