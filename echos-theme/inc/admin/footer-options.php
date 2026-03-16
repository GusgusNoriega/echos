<?php
/**
 * Footer global options page.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'admin_menu', 'echos_footer_register_options_page' );
add_action( 'admin_post_echos_save_footer', 'echos_footer_save_options_page' );
add_action( 'admin_enqueue_scripts', 'echos_footer_enqueue_admin_assets' );

/**
 * Registers footer options page under Appearance.
 *
 * @return void
 */
function echos_footer_register_options_page() {
	add_theme_page(
		__( 'Footer ECHOS', 'echos' ),
		__( 'Footer ECHOS', 'echos' ),
		'manage_options',
		'echos-footer-options',
		'echos_footer_render_options_page'
	);
}

/**
 * Renders footer options page.
 *
 * @return void
 */
function echos_footer_render_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$data = echos_footer_get_data();
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Footer ECHOS - Contenido Administrable', 'echos' ); ?></h1>

		<?php
		$updated = isset( $_GET['updated'] ) ? sanitize_key( wp_unslash( $_GET['updated'] ) ) : '';
		?>
		<?php if ( 'true' === $updated ) : ?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e( 'Footer actualizado correctamente.', 'echos' ); ?></p>
			</div>
		<?php endif; ?>

		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'echos_footer_save_options', 'echos_footer_options_nonce' ); ?>
			<input type="hidden" name="action" value="echos_save_footer" />

			<div class="echos-home-admin">
				<p class="description">
					<?php esc_html_e( 'Desde aqui puedes administrar completamente el footer: redes sociales con iconos, columnas de enlaces y la imagen principal.', 'echos' ); ?>
				</p>

				<details class="echos-home-admin__section" open>
					<summary><?php esc_html_e( 'Contenido general', 'echos' ); ?></summary>
					<div class="echos-home-admin__section-body">
						<?php
						echos_footer_admin_render_single_field(
							$data,
							array(
								'label' => __( 'Texto de redes (usa salto de linea)', 'echos' ),
								'path'  => array( 'social_label' ),
								'type'  => 'textarea',
							)
						);

						echos_footer_admin_render_single_field(
							$data,
							array(
								'label' => __( 'Imagen/logo del footer', 'echos' ),
								'path'  => array( 'brand_image' ),
								'type'  => 'image',
							)
						);

						echos_footer_admin_render_single_field(
							$data,
							array(
								'label' => __( 'ALT de la imagen/logo', 'echos' ),
								'path'  => array( 'brand_image_alt' ),
							)
						);

						echos_footer_admin_render_single_field(
							$data,
							array(
								'label' => __( 'URL al hacer clic en la imagen/logo', 'echos' ),
								'path'  => array( 'brand_image_link' ),
								'type'  => 'url',
							)
						);
						?>
					</div>
				</details>

				<details class="echos-home-admin__section">
					<summary><?php esc_html_e( 'Redes sociales', 'echos' ); ?></summary>
					<div class="echos-home-admin__section-body">
						<?php
						echos_footer_admin_render_repeater(
							array(
								'title'      => __( 'Enlaces de redes', 'echos' ),
								'item_label' => __( 'Red social', 'echos' ),
								'add_label'  => __( 'Agregar red', 'echos' ),
								'name_path'  => array( 'social_links' ),
								'rows'       => echos_footer_admin_get_nested_value( $data, array( 'social_links' ), array() ),
								'fields'     => array(
									array(
										'key'     => 'platform',
										'label'   => __( 'Plataforma', 'echos' ),
										'type'    => 'select',
										'options' => echos_footer_social_platform_options(),
									),
									array(
										'key'   => 'url',
										'label' => __( 'URL', 'echos' ),
										'type'  => 'url',
									),
									array(
										'key'   => 'label',
										'label' => __( 'Etiqueta (accesibilidad)', 'echos' ),
										'type'  => 'text',
									),
								),
							)
						);
						?>
					</div>
				</details>

				<details class="echos-home-admin__section">
					<summary><?php esc_html_e( 'Columnas de enlaces', 'echos' ); ?></summary>
					<div class="echos-home-admin__section-body">
						<p class="description"><?php esc_html_e( 'Cada linea debe tener formato: Texto del enlace|https://url.com', 'echos' ); ?></p>
						<?php
						echos_footer_admin_render_repeater(
							array(
								'title'      => __( 'Columnas del footer', 'echos' ),
								'item_label' => __( 'Columna', 'echos' ),
								'add_label'  => __( 'Agregar columna', 'echos' ),
								'name_path'  => array( 'columns' ),
								'rows'       => echos_footer_admin_get_nested_value( $data, array( 'columns' ), array() ),
								'fields'     => array(
									array(
										'key'   => 'title',
										'label' => __( 'Titulo de columna', 'echos' ),
										'type'  => 'text',
									),
									array(
										'key'         => 'links',
										'label'       => __( 'Enlaces', 'echos' ),
										'type'        => 'links_lines',
										'placeholder' => "Productos|https://tuweb.com/productos\nServicios|https://tuweb.com/servicios",
										'wide'        => true,
									),
								),
							)
						);
						?>
					</div>
				</details>
			</div>

			<?php submit_button( __( 'Guardar footer', 'echos' ) ); ?>
		</form>
	</div>
	<?php
}

/**
 * Renders a normal (non repeater) field.
 *
 * @param array $data Current data.
 * @param array $args Field args.
 * @return void
 */
function echos_footer_admin_render_single_field( $data, $args ) {
	$defaults = array(
		'label'       => '',
		'path'        => array(),
		'type'        => 'text',
		'placeholder' => '',
		'options'     => array(),
	);
	$args     = wp_parse_args( $args, $defaults );

	if ( empty( $args['path'] ) || ! is_array( $args['path'] ) ) {
		return;
	}

	$name  = echos_footer_admin_build_name( $args['path'] );
	$value = echos_footer_admin_get_nested_value( $data, $args['path'], '' );

	echo '<div class="echos-home-field">';
	echo '<label class="echos-home-field__label">' . esc_html( $args['label'] ) . '</label>';
	echos_footer_admin_render_field_control( $args['type'], $name, $value, $args['placeholder'], $args['options'] );
	echo '</div>';
}

/**
 * Renders a repeater UI.
 *
 * @param array $args Repeater args.
 * @return void
 */
function echos_footer_admin_render_repeater( $args ) {
	$defaults = array(
		'title'      => '',
		'item_label' => __( 'Item', 'echos' ),
		'add_label'  => __( 'Agregar item', 'echos' ),
		'name_path'  => array(),
		'rows'       => array(),
		'fields'     => array(),
	);
	$args     = wp_parse_args( $args, $defaults );

	if ( empty( $args['name_path'] ) || ! is_array( $args['name_path'] ) ) {
		return;
	}

	$rows = is_array( $args['rows'] ) ? array_values( $args['rows'] ) : array();
	if ( empty( $rows ) ) {
		$rows[] = array();
	}

	echo '<div class="echos-home-repeater" data-home-repeater>';
	echo '<div class="echos-home-repeater__head">' . esc_html( $args['title'] ) . '</div>';
	echo '<div class="echos-home-repeater__rows" data-home-rows>';

	foreach ( $rows as $index => $row ) {
		echos_footer_admin_render_repeater_row( $args['name_path'], $index, $row, $args['fields'], $args['item_label'] );
	}

	echo '</div>';
	echo '<button type="button" class="button button-secondary" data-home-add-row>' . esc_html( $args['add_label'] ) . '</button>';
	echo '<template data-home-row-template>';
	echos_footer_admin_render_repeater_row( $args['name_path'], '__index__', array(), $args['fields'], $args['item_label'] );
	echo '</template>';
	echo '</div>';
}

/**
 * Renders a repeater row.
 *
 * @param array       $path       Field path.
 * @param int|string  $index      Row index.
 * @param array       $row        Row values.
 * @param array       $fields     Field definitions.
 * @param string      $item_label Label.
 * @return void
 */
function echos_footer_admin_render_repeater_row( $path, $index, $row, $fields, $item_label ) {
	echo '<div class="echos-home-row" data-home-row>';
	echo '<div class="echos-home-row__actions">';
	echo '<strong>' . esc_html( $item_label ) . '</strong>';
	echo '<button type="button" class="button-link-delete" data-home-remove-row>' . esc_html__( 'Quitar', 'echos' ) . '</button>';
	echo '</div>';
	echo '<div class="echos-home-row__grid">';

	foreach ( $fields as $field ) {
		$key         = isset( $field['key'] ) ? (string) $field['key'] : '';
		$label       = isset( $field['label'] ) ? $field['label'] : $key;
		$type        = isset( $field['type'] ) ? $field['type'] : 'text';
		$placeholder = isset( $field['placeholder'] ) ? $field['placeholder'] : '';
		$options     = isset( $field['options'] ) && is_array( $field['options'] ) ? $field['options'] : array();
		$wide        = ! empty( $field['wide'] );

		if ( '' === $key ) {
			continue;
		}

		$value         = isset( $row[ $key ] ) ? $row[ $key ] : '';
		$name          = echos_footer_admin_build_repeater_name( $path, $index, $key );
		$name_template = echos_footer_admin_build_repeater_name( $path, '__index__', $key );

		echo '<div class="echos-home-field ' . ( $wide ? 'is-wide' : '' ) . '">';
		echo '<label class="echos-home-field__label">' . esc_html( $label ) . '</label>';
		echos_footer_admin_render_field_control( $type, $name, $value, $placeholder, $options, $name_template );
		echo '</div>';
	}

	echo '</div>';
	echo '</div>';
}

/**
 * Renders a field control.
 *
 * @param string $type          Field type.
 * @param string $name          Field name.
 * @param mixed  $value         Value.
 * @param string $placeholder   Placeholder.
 * @param array  $options       Select options.
 * @param string $name_template Name template for repeater renumber.
 * @return void
 */
function echos_footer_admin_render_field_control( $type, $name, $value, $placeholder = '', $options = array(), $name_template = '' ) {
	$template_attr = $name_template ? ' data-home-name-template="' . esc_attr( $name_template ) . '"' : '';

	switch ( $type ) {
		case 'textarea':
			echo '<textarea class="large-text" rows="3" name="' . esc_attr( $name ) . '" placeholder="' . esc_attr( $placeholder ) . '"' . $template_attr . '>' . esc_textarea( (string) $value ) . '</textarea>';
			break;

		case 'links_lines':
			$links_text = is_array( $value ) ? echos_footer_links_to_lines( $value ) : (string) $value;
			echo '<textarea class="large-text" rows="4" name="' . esc_attr( $name ) . '" placeholder="' . esc_attr( $placeholder ) . '"' . $template_attr . '>' . esc_textarea( $links_text ) . '</textarea>';
			break;

		case 'url':
			echo '<input type="url" class="regular-text" name="' . esc_attr( $name ) . '" value="' . esc_attr( (string) $value ) . '" placeholder="' . esc_attr( $placeholder ) . '"' . $template_attr . ' />';
			break;

		case 'select':
			echo '<select name="' . esc_attr( $name ) . '"' . $template_attr . '>';
			foreach ( $options as $option_value => $option_label ) {
				echo '<option value="' . esc_attr( $option_value ) . '" ' . selected( (string) $value, (string) $option_value, false ) . '>' . esc_html( $option_label ) . '</option>';
			}
			echo '</select>';
			break;

		case 'image':
			echos_footer_admin_render_image_control( $name, $value, $template_attr );
			break;

		case 'text':
		default:
			echo '<input type="text" class="regular-text" name="' . esc_attr( $name ) . '" value="' . esc_attr( (string) $value ) . '" placeholder="' . esc_attr( $placeholder ) . '"' . $template_attr . ' />';
			break;
	}
}

/**
 * Renders image field control.
 *
 * @param string $name          Name attribute.
 * @param string $value         Current value.
 * @param string $template_attr Template attribute.
 * @return void
 */
function echos_footer_admin_render_image_control( $name, $value, $template_attr ) {
	$image_url = is_string( $value ) ? $value : '';
	$show      = '' !== trim( $image_url ) ? '' : ' style="display:none;"';

	echo '<div class="echos-home-image" data-home-image-field>';
	echo '<input type="url" class="regular-text" name="' . esc_attr( $name ) . '" value="' . esc_attr( $image_url ) . '" placeholder="https://" data-home-image-input' . $template_attr . ' />';
	echo '<button type="button" class="button" data-home-image-pick>' . esc_html__( 'Seleccionar', 'echos' ) . '</button>';
	echo '<button type="button" class="button-link-delete" data-home-image-clear>' . esc_html__( 'Limpiar', 'echos' ) . '</button>';
	echo '<div class="echos-home-image__preview" data-home-image-preview' . $show . '>';
	echo '<img src="' . esc_url( $image_url ) . '" alt="" />';
	echo '</div>';
	echo '</div>';
}

/**
 * Returns nested value from array.
 *
 * @param array $data    Source data.
 * @param array $path    Key path.
 * @param mixed $default Default value.
 * @return mixed
 */
function echos_footer_admin_get_nested_value( $data, $path, $default = '' ) {
	$cursor = $data;

	foreach ( $path as $key ) {
		if ( ! is_array( $cursor ) || ! array_key_exists( $key, $cursor ) ) {
			return $default;
		}
		$cursor = $cursor[ $key ];
	}

	return $cursor;
}

/**
 * Builds input name for normal field.
 *
 * @param array $path Field path.
 * @return string
 */
function echos_footer_admin_build_name( $path ) {
	$name = 'echos_footer_data';

	foreach ( $path as $segment ) {
		$name .= '[' . $segment . ']';
	}

	return $name;
}

/**
 * Builds input name for repeater field.
 *
 * @param array      $path      Repeater path.
 * @param int|string $index     Row index.
 * @param string     $field_key Field key.
 * @return string
 */
function echos_footer_admin_build_repeater_name( $path, $index, $field_key ) {
	$name = echos_footer_admin_build_name( $path );
	$name .= '[' . $index . ']';
	$name .= '[' . $field_key . ']';

	return $name;
}

/**
 * Handles footer options save.
 *
 * @return void
 */
function echos_footer_save_options_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'No tienes permisos para editar el footer.', 'echos' ) );
	}

	if ( ! isset( $_POST['echos_footer_options_nonce'] ) ) {
		wp_safe_redirect( admin_url( 'themes.php?page=echos-footer-options' ) );
		exit;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_footer_options_nonce'] ) ), 'echos_footer_save_options' ) ) {
		wp_die( esc_html__( 'Nonce invalido al guardar footer.', 'echos' ) );
	}

	$raw = array();
	if ( isset( $_POST['echos_footer_data'] ) && is_array( $_POST['echos_footer_data'] ) ) {
		$raw = wp_unslash( $_POST['echos_footer_data'] );
	}

	$sanitized = echos_footer_admin_sanitize_by_schema( $raw, echos_footer_admin_schema() );

	if ( empty( $sanitized ) ) {
		delete_option( 'echos_footer_sections' );
	} else {
		update_option( 'echos_footer_sections', $sanitized, false );
	}

	$redirect = add_query_arg(
		array(
			'page'    => 'echos-footer-options',
			'updated' => 'true',
		),
		admin_url( 'themes.php' )
	);

	wp_safe_redirect( $redirect );
	exit;
}

/**
 * Footer schema for sanitization.
 *
 * @return array
 */
function echos_footer_admin_schema() {
	return array(
		'social_label'     => 'textarea',
		'social_links'     => array(
			'_type'  => 'repeater',
			'fields' => array(
				'platform' => array(
					'type'    => 'choice',
					'allowed' => array_keys( echos_footer_social_platform_options() ),
				),
				'url'      => 'url',
				'label'    => 'text',
			),
		),
		'columns'          => array(
			'_type'  => 'repeater',
			'fields' => array(
				'title' => 'text',
				'links' => 'links_lines',
			),
		),
		'brand_image'      => 'url',
		'brand_image_alt'  => 'text',
		'brand_image_link' => 'url',
	);
}

/**
 * Sanitizes data recursively based on schema.
 *
 * @param array $data   Raw data.
 * @param array $schema Schema.
 * @return array
 */
function echos_footer_admin_sanitize_by_schema( $data, $schema ) {
	$clean = array();

	if ( ! is_array( $data ) ) {
		$data = array();
	}

	foreach ( $schema as $key => $rule ) {
		if ( is_array( $rule ) && isset( $rule['_type'] ) && 'repeater' === $rule['_type'] ) {
			$rows      = isset( $data[ $key ] ) && is_array( $data[ $key ] ) ? $data[ $key ] : array();
			$clean_row = array();

			foreach ( $rows as $row ) {
				if ( ! is_array( $row ) ) {
					continue;
				}

				$item = echos_footer_admin_sanitize_by_schema( $row, $rule['fields'] );
				if ( 'social_links' === $key ) {
					$url   = isset( $item['url'] ) ? trim( (string) $item['url'] ) : '';
					$label = isset( $item['label'] ) ? trim( (string) $item['label'] ) : '';
					if ( '' === $url && '' === $label ) {
						continue;
					}
				}
				if ( echos_footer_admin_row_has_content( $item ) ) {
					$clean_row[] = $item;
				}
			}

			if ( ! empty( $clean_row ) ) {
				$clean[ $key ] = $clean_row;
			}

			continue;
		}

		if ( is_array( $rule ) && ! isset( $rule['type'] ) ) {
			$group = isset( $data[ $key ] ) && is_array( $data[ $key ] ) ? $data[ $key ] : array();
			$item  = echos_footer_admin_sanitize_by_schema( $group, $rule );
			if ( ! empty( $item ) ) {
				$clean[ $key ] = $item;
			}
			continue;
		}

		$value = isset( $data[ $key ] ) ? $data[ $key ] : '';
		$value = echos_footer_admin_sanitize_scalar( $value, $rule );

		if ( is_array( $value ) ) {
			if ( ! empty( $value ) ) {
				$clean[ $key ] = $value;
			}
			continue;
		}

		if ( '' !== $value ) {
			$clean[ $key ] = $value;
		}
	}

	return $clean;
}

/**
 * Sanitizes scalar values.
 *
 * @param mixed        $value Scalar value.
 * @param string|array $rule  Rule.
 * @return mixed
 */
function echos_footer_admin_sanitize_scalar( $value, $rule ) {
	$type = is_array( $rule ) && isset( $rule['type'] ) ? $rule['type'] : $rule;

	if ( 'links_lines' === $type ) {
		$raw = is_scalar( $value ) ? (string) $value : '';
		return echos_footer_parse_links_lines( $raw );
	}

	if ( ! is_scalar( $value ) ) {
		$value = '';
	}

	$value = (string) $value;

	switch ( $type ) {
		case 'textarea':
			return sanitize_textarea_field( $value );

		case 'url':
			return esc_url_raw( trim( $value ) );

		case 'choice':
			$allowed = is_array( $rule ) && isset( $rule['allowed'] ) && is_array( $rule['allowed'] ) ? $rule['allowed'] : array();
			$key     = sanitize_key( $value );
			if ( in_array( $key, $allowed, true ) ) {
				return $key;
			}
			return isset( $allowed[0] ) ? $allowed[0] : '';

		case 'text':
		default:
			return sanitize_text_field( $value );
	}
}

/**
 * Checks if row has some content.
 *
 * @param array $row Row data.
 * @return bool
 */
function echos_footer_admin_row_has_content( $row ) {
	if ( ! is_array( $row ) ) {
		return false;
	}

	foreach ( $row as $value ) {
		if ( is_array( $value ) ) {
			if ( ! empty( $value ) ) {
				return true;
			}
			continue;
		}

		if ( '' !== trim( (string) $value ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Loads admin JS/CSS only for footer options page.
 *
 * @param string $hook Current hook.
 * @return void
 */
function echos_footer_enqueue_admin_assets( $hook ) {
	if ( 'appearance_page_echos-footer-options' !== $hook ) {
		return;
	}

	$version = wp_get_theme()->get( 'Version' );
	$uri     = get_template_directory_uri();

	wp_enqueue_media();

	wp_enqueue_style(
		'echos-footer-admin',
		$uri . '/assets/css/admin-home-sections.css',
		array(),
		$version
	);

	wp_enqueue_script(
		'echos-footer-admin',
		$uri . '/assets/js/admin-home-sections.js',
		array(),
		$version,
		true
	);

	wp_localize_script(
		'echos-footer-admin',
		'echosHomeAdmin',
		array(
			'mediaTitle'  => __( 'Seleccionar imagen', 'echos' ),
			'mediaButton' => __( 'Usar imagen', 'echos' ),
		)
	);
}
