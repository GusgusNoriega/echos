<?php
/**
 * Popup per-page admin metabox.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'echos_popup_register_admin_metabox', 10, 2 );
add_action( 'save_post_page', 'echos_popup_save_admin_metabox', 10, 2 );
add_action( 'admin_enqueue_scripts', 'echos_popup_enqueue_admin_assets' );

/**
 * Registers popup metabox for pages.
 *
 * @param string  $post_type Post type.
 * @param WP_Post $post      Post object.
 * @return void
 */
function echos_popup_register_admin_metabox( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post instanceof WP_Post ) {
		return;
	}

	add_meta_box(
		'echos_popup_metabox',
		__( 'Popup: Contenido por pagina', 'echos' ),
		'echos_popup_render_admin_metabox',
		'page',
		'normal',
		'default'
	);
}

/**
 * Renders popup metabox HTML.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function echos_popup_render_admin_metabox( $post ) {
	$data = echos_popup_get_data( $post->ID );

	wp_nonce_field( 'echos_popup_save_metabox', 'echos_popup_metabox_nonce' );
	?>
	<div class="echos-home-admin">
		<p class="description">
			<?php esc_html_e( 'Activa el popup para esta pagina y personaliza su contenido. El formulario de contacto se mantiene fijo.', 'echos' ); ?>
		</p>

		<details class="echos-home-admin__section" open>
			<summary><?php esc_html_e( 'Contenido del popup', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<div class="echos-home-field">
					<label class="echos-home-field__label" for="echos-popup-enabled"><?php esc_html_e( 'Mostrar popup en esta pagina', 'echos' ); ?></label>
					<label>
						<input
							type="checkbox"
							id="echos-popup-enabled"
							name="echos_popup_data[enabled]"
							value="1"
							<?php checked( ! empty( $data['enabled'] ) ); ?>
						/>
						<?php esc_html_e( 'Activar popup', 'echos' ); ?>
					</label>
				</div>

				<div class="echos-home-field">
					<label class="echos-home-field__label" for="echos-popup-title"><?php esc_html_e( 'Titulo (permite salto de linea)', 'echos' ); ?></label>
					<textarea id="echos-popup-title" class="large-text" rows="3" name="echos_popup_data[title]"><?php echo esc_textarea( isset( $data['title'] ) ? (string) $data['title'] : '' ); ?></textarea>
				</div>

				<div class="echos-home-field">
					<label class="echos-home-field__label" for="echos-popup-text"><?php esc_html_e( 'Texto descriptivo', 'echos' ); ?></label>
					<textarea id="echos-popup-text" class="large-text" rows="4" name="echos_popup_data[text]"><?php echo esc_textarea( isset( $data['text'] ) ? (string) $data['text'] : '' ); ?></textarea>
				</div>

				<div class="echos-home-field">
					<label class="echos-home-field__label" for="echos-popup-image"><?php esc_html_e( 'Imagen del popup', 'echos' ); ?></label>
					<?php echos_popup_admin_render_image_field( 'echos_popup_data[image]', isset( $data['image'] ) ? $data['image'] : '' ); ?>
				</div>
			</div>
		</details>
	</div>
	<?php
}

/**
 * Renders image control using shared admin JS.
 *
 * @param string $name  Input name.
 * @param mixed  $value Current value.
 * @return void
 */
function echos_popup_admin_render_image_field( $name, $value ) {
	$image_url = is_scalar( $value ) ? (string) $value : '';
	$show      = '' !== trim( $image_url ) ? '' : ' style="display:none;"';

	echo '<div class="echos-home-image" data-home-image-field>';
	echo '<input type="url" id="echos-popup-image" class="regular-text" name="' . esc_attr( $name ) . '" value="' . esc_attr( $image_url ) . '" placeholder="https://" data-home-image-input />';
	echo '<button type="button" class="button" data-home-image-pick>' . esc_html__( 'Seleccionar', 'echos' ) . '</button>';
	echo '<button type="button" class="button-link-delete" data-home-image-clear>' . esc_html__( 'Limpiar', 'echos' ) . '</button>';
	echo '<div class="echos-home-image__preview" data-home-image-preview' . $show . '>';
	echo '<img src="' . esc_url( $image_url ) . '" alt="" />';
	echo '</div>';
	echo '</div>';
}

/**
 * Saves popup metabox values.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @return void
 */
function echos_popup_save_admin_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['echos_popup_metabox_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_popup_metabox_nonce'] ) ), 'echos_popup_save_metabox' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}

	$raw = array();
	if ( isset( $_POST['echos_popup_data'] ) && is_array( $_POST['echos_popup_data'] ) ) {
		$raw = wp_unslash( $_POST['echos_popup_data'] );
	}

	$sanitized = array(
		'enabled' => ! empty( $raw['enabled'] ) ? 1 : 0,
		'title'   => isset( $raw['title'] ) && is_scalar( $raw['title'] ) ? sanitize_textarea_field( (string) $raw['title'] ) : '',
		'text'    => isset( $raw['text'] ) && is_scalar( $raw['text'] ) ? sanitize_textarea_field( (string) $raw['text'] ) : '',
		'image'   => isset( $raw['image'] ) && is_scalar( $raw['image'] ) ? esc_url_raw( trim( (string) $raw['image'] ) ) : '',
	);

	if (
		0 === (int) $sanitized['enabled']
		&& '' === $sanitized['title']
		&& '' === $sanitized['text']
		&& '' === $sanitized['image']
	) {
		delete_post_meta( $post_id, '_echos_popup_data' );
		return;
	}

	update_post_meta( $post_id, '_echos_popup_data', $sanitized );
}

/**
 * Enqueues shared admin assets for popup metabox.
 *
 * @param string $hook Current admin hook.
 * @return void
 */
function echos_popup_enqueue_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
	if ( ! $screen || 'page' !== $screen->post_type ) {
		return;
	}

	$version = wp_get_theme()->get( 'Version' );
	$uri     = get_template_directory_uri();

	wp_enqueue_media();

	wp_enqueue_style(
		'echos-popup-admin',
		$uri . '/assets/css/admin-home-sections.css',
		array(),
		$version
	);

	wp_enqueue_script(
		'echos-popup-admin',
		$uri . '/assets/js/admin-home-sections.js',
		array(),
		$version,
		true
	);

	wp_localize_script(
		'echos-popup-admin',
		'echosHomeAdmin',
		array(
			'mediaTitle'  => __( 'Seleccionar imagen', 'echos' ),
			'mediaButton' => __( 'Usar imagen', 'echos' ),
		)
	);
}
