<?php
/**
 * Analytics settings and frontend output.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_head', 'echos_analytics_render_head', 1 );
add_action( 'wp_body_open', 'echos_analytics_render_body', 1 );

/**
 * Returns merged analytics settings.
 *
 * @return array
 */
function echos_analytics_get_settings() {
	$defaults = echos_analytics_default_settings();
	$saved    = get_option( 'echos_analytics_settings', array() );
	$settings = $defaults;

	if ( is_array( $saved ) ) {
		if ( array_key_exists( 'ga4_measurement_id', $saved ) ) {
			$settings['ga4_measurement_id'] = echos_analytics_sanitize_ga4_measurement_id( $saved['ga4_measurement_id'] );
		}

		if ( array_key_exists( 'gtm_container_id', $saved ) ) {
			$settings['gtm_container_id'] = echos_analytics_sanitize_gtm_container_id( $saved['gtm_container_id'] );
		}
	}

	return $settings;
}

/**
 * Sanitizes GA4 measurement ID.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function echos_analytics_sanitize_ga4_measurement_id( $value ) {
	$id = strtoupper( sanitize_text_field( (string) $value ) );
	$id = preg_replace( '/\s+/', '', $id );
	$id = is_string( $id ) ? trim( $id ) : '';

	if ( '' === $id ) {
		return '';
	}

	if ( 1 !== preg_match( '/^G-[A-Z0-9]+$/', $id ) ) {
		return '';
	}

	return $id;
}

/**
 * Sanitizes GTM container ID.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function echos_analytics_sanitize_gtm_container_id( $value ) {
	$id = strtoupper( sanitize_text_field( (string) $value ) );
	$id = preg_replace( '/\s+/', '', $id );
	$id = is_string( $id ) ? trim( $id ) : '';

	if ( '' === $id ) {
		return '';
	}

	if ( 1 !== preg_match( '/^GTM-[A-Z0-9]+$/', $id ) ) {
		return '';
	}

	return $id;
}

/**
 * Prints GA4 and GTM scripts inside <head>.
 *
 * @return void
 */
function echos_analytics_render_head() {
	$settings = echos_analytics_get_settings();
	$ga4_id   = isset( $settings['ga4_measurement_id'] ) ? (string) $settings['ga4_measurement_id'] : '';
	$gtm_id   = isset( $settings['gtm_container_id'] ) ? (string) $settings['gtm_container_id'] : '';

	if ( '' !== $ga4_id ) :
		?>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $ga4_id ); ?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', '<?php echo esc_js( $ga4_id ); ?>');
</script>
		<?php
	endif;

	if ( '' !== $gtm_id ) :
		?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo esc_js( $gtm_id ); ?>');</script>
<!-- End Google Tag Manager -->
		<?php
	endif;
}

/**
 * Prints GTM noscript right after opening <body>.
 *
 * @return void
 */
function echos_analytics_render_body() {
	$settings = echos_analytics_get_settings();
	$gtm_id   = isset( $settings['gtm_container_id'] ) ? (string) $settings['gtm_container_id'] : '';

	if ( '' === $gtm_id ) {
		return;
	}
	?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_attr( $gtm_id ); ?>"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
	<?php
}

