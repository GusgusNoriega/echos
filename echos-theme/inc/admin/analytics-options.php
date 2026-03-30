<?php
/**
 * Analytics options page.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'echos_analytics_register_options_page' );
add_action( 'admin_post_echos_save_analytics_settings', 'echos_analytics_save_options_page' );

/**
 * Registers analytics options page under Appearance.
 *
 * @return void
 */
function echos_analytics_register_options_page() {
	add_theme_page(
		__( 'Analytics ECHOS', 'echos' ),
		__( 'Analytics ECHOS', 'echos' ),
		'manage_options',
		'echos-analytics-options',
		'echos_analytics_render_options_page'
	);
}

/**
 * Renders analytics options page.
 *
 * @return void
 */
function echos_analytics_render_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$settings = echos_analytics_get_settings();
	$defaults = echos_analytics_default_settings();
	$updated  = isset( $_GET['updated'] ) ? sanitize_key( wp_unslash( $_GET['updated'] ) ) : '';
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Analytics ECHOS', 'echos' ); ?></h1>

		<?php if ( 'true' === $updated ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Configuracion de analytics actualizada correctamente.', 'echos' ); ?></p>
			</div>
		<?php endif; ?>

		<p class="description">
			<?php esc_html_e( 'Configura los IDs de Google Analytics 4 y Google Tag Manager. Si dejas un campo vacio, se desactiva ese codigo.', 'echos' ); ?>
		</p>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'echos_analytics_save_options', 'echos_analytics_options_nonce' ); ?>
			<input type="hidden" name="action" value="echos_save_analytics_settings" />

			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row">
							<label for="echos-ga4-id"><?php esc_html_e( 'GA4 Measurement ID', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-ga4-id"
								name="echos_analytics_settings[ga4_measurement_id]"
								value="<?php echo esc_attr( (string) $settings['ga4_measurement_id'] ); ?>"
								placeholder="<?php echo esc_attr( (string) $defaults['ga4_measurement_id'] ); ?>"
							/>
							<p class="description">
								<?php esc_html_e( 'Formato esperado: G-XXXXXXXXXX', 'echos' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="echos-gtm-id"><?php esc_html_e( 'GTM Container ID', 'echos' ); ?></label>
						</th>
						<td>
							<input
								type="text"
								class="regular-text"
								id="echos-gtm-id"
								name="echos_analytics_settings[gtm_container_id]"
								value="<?php echo esc_attr( (string) $settings['gtm_container_id'] ); ?>"
								placeholder="<?php echo esc_attr( (string) $defaults['gtm_container_id'] ); ?>"
							/>
							<p class="description">
								<?php esc_html_e( 'Formato esperado: GTM-XXXXXXX', 'echos' ); ?>
							</p>
						</td>
					</tr>
				</tbody>
			</table>

			<?php submit_button( __( 'Guardar analytics', 'echos' ) ); ?>
		</form>
	</div>
	<?php
}

/**
 * Saves analytics settings.
 *
 * @return void
 */
function echos_analytics_save_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tienes permisos para editar analytics.', 'echos' ) );
	}

	if ( ! isset( $_POST['echos_analytics_options_nonce'] ) ) {
		wp_safe_redirect( admin_url( 'themes.php?page=echos-analytics-options' ) );
		exit;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_analytics_options_nonce'] ) ), 'echos_analytics_save_options' ) ) {
		wp_die( esc_html__( 'Nonce invalido al guardar analytics.', 'echos' ) );
	}

	$raw = array();
	if ( isset( $_POST['echos_analytics_settings'] ) && is_array( $_POST['echos_analytics_settings'] ) ) {
		$raw = wp_unslash( $_POST['echos_analytics_settings'] );
	}

	$sanitized = array(
		'ga4_measurement_id' => echos_analytics_sanitize_ga4_measurement_id( $raw['ga4_measurement_id'] ?? '' ),
		'gtm_container_id'   => echos_analytics_sanitize_gtm_container_id( $raw['gtm_container_id'] ?? '' ),
	);

	update_option( 'echos_analytics_settings', $sanitized, false );

	$redirect = add_query_arg(
		array(
			'page'    => 'echos-analytics-options',
			'updated' => 'true',
		),
		admin_url( 'themes.php' )
	);

	wp_safe_redirect( $redirect );
	exit;
}

