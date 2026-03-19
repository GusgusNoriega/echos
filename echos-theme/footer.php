<?php
$footer_data  = echos_footer_get_data();
$social_links = echos_footer_normalize_social_links( isset( $footer_data['social_links'] ) ? $footer_data['social_links'] : array() );
$columns      = echos_footer_normalize_columns( isset( $footer_data['columns'] ) ? $footer_data['columns'] : array() );

$social_label = isset( $footer_data['social_label'] ) ? (string) $footer_data['social_label'] : '';
$brand_image  = isset( $footer_data['brand_image'] ) ? (string) $footer_data['brand_image'] : '';
$brand_alt    = isset( $footer_data['brand_image_alt'] ) ? (string) $footer_data['brand_image_alt'] : 'ECHOS Logo';
$brand_link   = isset( $footer_data['brand_image_link'] ) ? (string) $footer_data['brand_image_link'] : '';
$popup_data   = function_exists( 'echos_popup_get_data' ) ? echos_popup_get_data() : array();
$popup_show   = function_exists( 'echos_popup_should_render' ) ? echos_popup_should_render() : false;
$popup_title  = isset( $popup_data['title'] ) ? (string) $popup_data['title'] : '';
$popup_text   = isset( $popup_data['text'] ) ? (string) $popup_data['text'] : '';
$popup_image  = isset( $popup_data['image'] ) ? (string) $popup_data['image'] : '';

$brand_link_trimmed = trim( $brand_link );
if ( '' !== $brand_link_trimmed ) {
	$home_url = untrailingslashit( home_url( '/' ) );
	if ( untrailingslashit( $brand_link_trimmed ) === $home_url ) {
		$brand_link_trimmed = '';
	}
}
?>

<footer class="footer">
	<div class="container">
		<div class="footer__panel">
			<div class="footer__top">
				<div class="footer__social">
					<div class="footer__label"><?php echo wp_kses_post( echos_footer_multiline_text( $social_label ) ); ?></div>
					<div class="footer__icons" aria-label="<?php esc_attr_e( 'Redes sociales', 'echos' ); ?>">
						<?php foreach ( $social_links as $social ) : ?>
							<?php
							$platform = isset( $social['platform'] ) ? (string) $social['platform'] : 'custom';
							$url      = isset( $social['url'] ) ? (string) $social['url'] : '#';
							$label    = isset( $social['label'] ) ? (string) $social['label'] : echos_footer_default_social_label( $platform );
							?>
							<a href="<?php echo esc_url( $url ); ?>" class="soc" aria-label="<?php echo esc_attr( $label ); ?>">
								<span class="soc__icon" aria-hidden="true">
									<?php echo echos_footer_get_social_icon_markup( $platform ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</span>
							</a>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="footer__links">
					<?php foreach ( $columns as $column ) : ?>
						<?php
						$title = isset( $column['title'] ) ? (string) $column['title'] : '';
						$links = isset( $column['links'] ) && is_array( $column['links'] ) ? $column['links'] : array();
						?>
						<div class="col">
							<?php if ( '' !== trim( $title ) ) : ?>
								<div class="col__title"><?php echo esc_html( $title ); ?></div>
							<?php endif; ?>

							<?php foreach ( $links as $link ) : ?>
								<?php
								$link_label = isset( $link['label'] ) ? (string) $link['label'] : '';
								$link_url   = isset( $link['url'] ) ? (string) $link['url'] : '#';
								if ( '' === trim( $link_label ) ) {
									continue;
								}
								?>
								<a href="<?php echo esc_url( $link_url ); ?>"><?php echo esc_html( $link_label ); ?></a>
							<?php endforeach; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="footer__brand">
				<div class="mega-logo">
					<?php if ( '' !== trim( $brand_image ) ) : ?>
						<?php if ( '' !== $brand_link_trimmed ) : ?>
							<a class="footer__brand-link" href="<?php echo esc_url( $brand_link_trimmed ); ?>">
								<img src="<?php echo esc_url( $brand_image ); ?>" class="logo-footer" alt="<?php echo esc_attr( $brand_alt ); ?>" />
							</a>
						<?php else : ?>
							<img src="<?php echo esc_url( $brand_image ); ?>" class="logo-footer" alt="<?php echo esc_attr( $brand_alt ); ?>" />
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</footer>

<?php if ( $popup_show ) : ?>
	<!-- POPUP -->
	<section class="epopup" id="epopup" aria-hidden="true">
		<div class="epopup__backdrop" data-epopup-close aria-hidden="true"></div>

		<div class="epopup__dialog" role="dialog" aria-modal="true" aria-labelledby="epopupTitle">
			<button class="epopup__close" type="button" aria-label="Cerrar" data-epopup-close>
				&times;
			</button>

			<div class="epopup__grid">
				<div class="epopup__media" aria-hidden="true">
					<img class="epopup__img" src="<?php echo esc_url( $popup_image ); ?>" alt="" loading="lazy" />
				</div>

				<div class="epopup__content">
					<h2 class="epopup__title" id="epopupTitle"><?php echo wp_kses_post( echos_popup_multiline_text( $popup_title ) ); ?></h2>
					<p class="epopup__text">
						<?php echo wp_kses_post( echos_popup_multiline_text( $popup_text ) ); ?>
					</p>

					<form class="epopup__form" id="epopupForm" novalidate>
						<label class="epopup__field">
							<span class="sr-only">Nombre de empresa</span>
							<input class="epopup__input" name="empresa" placeholder="Nombre de empresa" autocomplete="organization" required />
						</label>

						<label class="epopup__field">
							<span class="sr-only">Correo electronico</span>
							<input
								class="epopup__input"
								type="email"
								name="email"
								placeholder="Ingresa tu correo electronico"
								autocomplete="email"
								required
							/>
						</label>

						<input type="hidden" name="form_source" value="popup_subscribe" />

						<button class="epopup__btn" type="submit">
							<span>Suscribirme</span>
							<span class="epopup__btnIcon" aria-hidden="true">
								<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
							</span>
						</button>
					</form>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php get_template_part( 'template-parts/sidebar-menu' ); ?>

<?php wp_footer(); ?>
</body>
</html>
