<?php
/**
 * Shared render helpers for product templates.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders the final CTA section for product templates.
 *
 * @param array  $cta     CTA data.
 * @param string $variant Variant key: "prod" or "productos".
 * @return void
 */
function echos_product_render_final_cta( $cta, $variant = 'prod' ) {
	$variant = in_array( $variant, array( 'prod', 'productos' ), true ) ? $variant : 'prod';

	$section_class = 'prod' === $variant ? 'prod-cta' : 'productos-cta';
	$card_class    = 'prod' === $variant ? 'prod-cta__card' : 'productos-cta__card';
	$title_class   = 'prod' === $variant ? 'prod-cta__title' : 'productos-cta__title';
	$text_class    = 'prod' === $variant ? 'prod-cta__text' : 'productos-cta__text';
	$buttons_class = 'prod' === $variant ? 'prod-cta__buttons' : 'productos-cta__buttons';
	?>
	<section class="<?php echo esc_attr( $section_class ); ?>">
		<div class="container">
			<div class="<?php echo esc_attr( $card_class ); ?>">
				<h2 class="<?php echo esc_attr( $title_class ); ?>"><?php echo esc_html( isset( $cta['title'] ) ? $cta['title'] : '' ); ?></h2>
				<p class="<?php echo esc_attr( $text_class ); ?>"><?php echo esc_html( isset( $cta['text'] ) ? $cta['text'] : '' ); ?></p>
				<div class="<?php echo esc_attr( $buttons_class ); ?>">
					<a class="btn-cta-dark" href="<?php echo esc_url( isset( $cta['primary_url'] ) ? $cta['primary_url'] : '#' ); ?>" target="_blank" rel="noopener">
						<span><?php echo esc_html( isset( $cta['primary_text'] ) ? $cta['primary_text'] : '' ); ?></span>
						<span class="btn-cta-dark__icon" aria-hidden="true">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.025.507 3.932 1.396 5.608L.05 23.708a.6.6 0 00.735.728L6.53 22.64A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.6a9.56 9.56 0 01-5.175-1.516l-.372-.222-3.843.985 1.028-3.752-.243-.387A9.56 9.56 0 012.4 12c0-5.302 4.298-9.6 9.6-9.6s9.6 4.298 9.6 9.6-4.298 9.6-9.6 9.6z"/></svg>
						</span>
					</a>
					<a class="btn-cta-dark" href="<?php echo esc_url( isset( $cta['secondary_url'] ) ? $cta['secondary_url'] : '#' ); ?>" target="_blank" rel="noopener">
						<span><?php echo esc_html( isset( $cta['secondary_text'] ) ? $cta['secondary_text'] : '' ); ?></span>
						<span class="btn-cta-dark__icon" aria-hidden="true">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 4L12 13 2 4"/></svg>
						</span>
					</a>
				</div>
			</div>
		</div>
	</section>
	<?php
}
