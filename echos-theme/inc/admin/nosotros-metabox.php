<?php
/**
 * Nosotros template admin metabox.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'echos_nosotros_register_admin_metabox', 10, 2 );
add_action( 'save_post_page', 'echos_nosotros_save_admin_metabox', 10, 2 );
add_action( 'admin_enqueue_scripts', 'echos_nosotros_enqueue_admin_assets' );

/**
 * Registers the metabox for the nosotros page template.
 *
 * @param string  $post_type Post type.
 * @param WP_Post $post      Post object.
 * @return void
 */
function echos_nosotros_register_admin_metabox( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post instanceof WP_Post ) {
		return;
	}

	if ( 'page-templates/template-nosotros.php' !== get_page_template_slug( $post->ID ) ) {
		return;
	}

	add_meta_box(
		'echos_nosotros_sections_metabox',
		__( 'Nosotros: Contenido Administrable', 'echos' ),
		'echos_nosotros_render_admin_metabox',
		'page',
		'normal',
		'high'
	);
}

/**
 * Renders metabox HTML.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function echos_nosotros_render_admin_metabox( $post ) {
	$data = echos_nosotros_get_data( $post->ID );

	wp_nonce_field( 'echos_nosotros_save_sections', 'echos_nosotros_sections_nonce' );
	?>
	<div class="echos-home-admin">
		<p class="description">
			<?php esc_html_e( 'Administra la pagina Nosotros desde aqui. Si dejas un campo vacio, se mantiene el valor por defecto del tema.', 'echos' ); ?>
		</p>

		<details class="echos-home-admin__section" open>
			<summary><?php esc_html_e( 'General y Hero', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'URL CTA topbar', 'echos' ),
						'path'  => array( 'topbar_cta_url' ),
						'type'  => 'url',
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Texto CTA topbar', 'echos' ),
						'path'  => array( 'topbar_cta_label' ),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Imagen de fondo hero', 'echos' ),
						'path'  => array( 'hero_background_image' ),
						'type'  => 'image',
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Hero: texto inicial', 'echos' ),
						'path'  => array( 'hero_title_prefix' ),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Hero: texto destacado', 'echos' ),
						'path'  => array( 'hero_title_accent' ),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Hero: descripcion', 'echos' ),
						'path'  => array( 'hero_description' ),
						'type'  => 'textarea',
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Imagen principal de equipo', 'echos' ),
						'path'  => array( 'team_image' ),
						'type'  => 'image',
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'ALT imagen de equipo', 'echos' ),
						'path'  => array( 'team_image_alt' ),
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'Descripcion', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_nosotros_admin_render_repeater(
					array(
						'title'      => __( 'Parrafos de descripcion', 'echos' ),
						'item_label' => __( 'Parrafo', 'echos' ),
						'add_label'  => __( 'Agregar parrafo', 'echos' ),
						'name_path'  => array( 'description_paragraphs' ),
						'rows'       => echos_nosotros_admin_get_nested_value( $data, array( 'description_paragraphs' ), array() ),
						'fields'     => array(
							array(
								'key'   => 'text',
								'label' => __( 'Texto', 'echos' ),
								'type'  => 'textarea',
								'wide'  => true,
							),
						),
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'Historia', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Titulo de seccion', 'echos' ),
						'path'  => array( 'history_title' ),
					)
				);

				echos_nosotros_admin_render_repeater(
					array(
						'title'      => __( 'Slides de historia', 'echos' ),
						'item_label' => __( 'Slide', 'echos' ),
						'add_label'  => __( 'Agregar slide', 'echos' ),
						'name_path'  => array( 'history_slides' ),
						'rows'       => echos_nosotros_admin_get_nested_value( $data, array( 'history_slides' ), array() ),
						'fields'     => array(
							array(
								'key'   => 'year',
								'label' => __( 'Ano', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'   => 'title',
								'label' => __( 'Titulo', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'   => 'description',
								'label' => __( 'Descripcion', 'echos' ),
								'type'  => 'textarea',
								'wide'  => true,
							),
						),
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'Mision y Vision', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Mision: titulo', 'echos' ),
						'path'  => array( 'mission_title' ),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label'   => __( 'Mision: icono', 'echos' ),
						'path'    => array( 'mission_icon' ),
						'type'    => 'select',
						'options' => echos_nosotros_mv_icon_options(),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Mision: descripcion', 'echos' ),
						'path'  => array( 'mission_description' ),
						'type'  => 'textarea',
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Vision: titulo', 'echos' ),
						'path'  => array( 'vision_title' ),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label'   => __( 'Vision: icono', 'echos' ),
						'path'    => array( 'vision_icon' ),
						'type'    => 'select',
						'options' => echos_nosotros_mv_icon_options(),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Vision: descripcion', 'echos' ),
						'path'  => array( 'vision_description' ),
						'type'  => 'textarea',
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'Proceso', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Titulo de seccion', 'echos' ),
						'path'  => array( 'process_title' ),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Descripcion de seccion', 'echos' ),
						'path'  => array( 'process_description' ),
						'type'  => 'textarea',
					)
				);

				echos_nosotros_admin_render_repeater(
					array(
						'title'      => __( 'Pasos del proceso', 'echos' ),
						'item_label' => __( 'Paso', 'echos' ),
						'add_label'  => __( 'Agregar paso', 'echos' ),
						'name_path'  => array( 'process_steps' ),
						'rows'       => echos_nosotros_admin_get_nested_value( $data, array( 'process_steps' ), array() ),
						'fields'     => array(
							array(
								'key'         => 'number',
								'label'       => __( 'Numero visible', 'echos' ),
								'type'        => 'text',
								'placeholder' => '01',
							),
							array(
								'key'   => 'title',
								'label' => __( 'Titulo', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'   => 'description',
								'label' => __( 'Descripcion', 'echos' ),
								'type'  => 'textarea',
								'wide'  => true,
							),
						),
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'Clientes', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_nosotros_admin_render_repeater(
					array(
						'title'      => __( 'Logos de clientes', 'echos' ),
						'item_label' => __( 'Cliente', 'echos' ),
						'add_label'  => __( 'Agregar cliente', 'echos' ),
						'name_path'  => array( 'clients' ),
						'rows'       => echos_nosotros_admin_get_nested_value( $data, array( 'clients' ), array() ),
						'fields'     => array(
							array(
								'key'   => 'image',
								'label' => __( 'Imagen (opcional)', 'echos' ),
								'type'  => 'image',
							),
							array(
								'key'   => 'alt',
								'label' => __( 'ALT', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'   => 'label',
								'label' => __( 'Texto (si no hay imagen)', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'         => 'logo_class',
								'label'       => __( 'Clases CSS', 'echos' ),
								'type'        => 'text',
								'placeholder' => 'logo logo--bcp',
							),
						),
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'CTA final', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Titulo', 'echos' ),
						'path'  => array( 'cta_title' ),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Texto', 'echos' ),
						'path'  => array( 'cta_text' ),
						'type'  => 'textarea',
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Boton principal - texto', 'echos' ),
						'path'  => array( 'cta_primary_text' ),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Boton principal - URL', 'echos' ),
						'path'  => array( 'cta_primary_url' ),
						'type'  => 'url',
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label'   => __( 'Boton principal - icono', 'echos' ),
						'path'    => array( 'cta_primary_icon' ),
						'type'    => 'select',
						'options' => echos_nosotros_action_icon_options(),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Boton secundario - texto', 'echos' ),
						'path'  => array( 'cta_secondary_text' ),
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Boton secundario - URL', 'echos' ),
						'path'  => array( 'cta_secondary_url' ),
						'type'  => 'url',
					)
				);

				echos_nosotros_admin_render_single_field(
					$data,
					array(
						'label'   => __( 'Boton secundario - icono', 'echos' ),
						'path'    => array( 'cta_secondary_icon' ),
						'type'    => 'select',
						'options' => echos_nosotros_action_icon_options(),
					)
				);
				?>
			</div>
		</details>
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
function echos_nosotros_admin_render_single_field( $data, $args ) {
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

	$name  = echos_nosotros_admin_build_name( $args['path'] );
	$value = echos_nosotros_admin_get_nested_value( $data, $args['path'], '' );

	echo '<div class="echos-home-field">';
	echo '<label class="echos-home-field__label">' . esc_html( $args['label'] ) . '</label>';
	echos_nosotros_admin_render_field_control( $args['type'], $name, $value, $args['placeholder'], $args['options'] );
	echo '</div>';
}

/**
 * Renders a repeater UI.
 *
 * @param array $args Repeater args.
 * @return void
 */
function echos_nosotros_admin_render_repeater( $args ) {
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
		echos_nosotros_admin_render_repeater_row( $args['name_path'], $index, $row, $args['fields'], $args['item_label'] );
	}

	echo '</div>';
	echo '<button type="button" class="button button-secondary" data-home-add-row>' . esc_html( $args['add_label'] ) . '</button>';
	echo '<template data-home-row-template>';
	echos_nosotros_admin_render_repeater_row( $args['name_path'], '__index__', array(), $args['fields'], $args['item_label'] );
	echo '</template>';
	echo '</div>';
}

/**
 * Renders a repeater row.
 *
 * @param array      $path       Field path.
 * @param int|string $index      Row index.
 * @param array      $row        Row values.
 * @param array      $fields     Field definitions.
 * @param string     $item_label Label.
 * @return void
 */
function echos_nosotros_admin_render_repeater_row( $path, $index, $row, $fields, $item_label ) {
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
		$name          = echos_nosotros_admin_build_repeater_name( $path, $index, $key );
		$name_template = echos_nosotros_admin_build_repeater_name( $path, '__index__', $key );

		echo '<div class="echos-home-field ' . ( $wide ? 'is-wide' : '' ) . '">';
		echo '<label class="echos-home-field__label">' . esc_html( $label ) . '</label>';
		echos_nosotros_admin_render_field_control( $type, $name, $value, $placeholder, $options, $name_template );
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
function echos_nosotros_admin_render_field_control( $type, $name, $value, $placeholder = '', $options = array(), $name_template = '' ) {
	$template_attr = $name_template ? ' data-home-name-template="' . esc_attr( $name_template ) . '"' : '';

	switch ( $type ) {
		case 'textarea':
			echo '<textarea class="large-text" rows="3" name="' . esc_attr( $name ) . '" placeholder="' . esc_attr( $placeholder ) . '"' . $template_attr . '>' . esc_textarea( (string) $value ) . '</textarea>';
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
			echos_nosotros_admin_render_image_control( $name, $value, $template_attr );
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
function echos_nosotros_admin_render_image_control( $name, $value, $template_attr ) {
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
function echos_nosotros_admin_get_nested_value( $data, $path, $default = '' ) {
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
function echos_nosotros_admin_build_name( $path ) {
	$name = 'echos_nosotros_data';

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
function echos_nosotros_admin_build_repeater_name( $path, $index, $field_key ) {
	$name = echos_nosotros_admin_build_name( $path );
	$name .= '[' . $index . ']';
	$name .= '[' . $field_key . ']';

	return $name;
}

/**
 * Saves metabox values.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @return void
 */
function echos_nosotros_save_admin_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['echos_nosotros_sections_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_nosotros_sections_nonce'] ) ), 'echos_nosotros_save_sections' ) ) {
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

	if ( 'page-templates/template-nosotros.php' !== get_page_template_slug( $post_id ) ) {
		return;
	}

	$raw = array();
	if ( isset( $_POST['echos_nosotros_data'] ) && is_array( $_POST['echos_nosotros_data'] ) ) {
		$raw = wp_unslash( $_POST['echos_nosotros_data'] );
	}

	$sanitized = echos_nosotros_admin_sanitize_by_schema( $raw, echos_nosotros_admin_schema() );

	if ( empty( $sanitized ) ) {
		delete_post_meta( $post_id, '_echos_nosotros_sections' );
		return;
	}

	update_post_meta( $post_id, '_echos_nosotros_sections', $sanitized );
}

/**
 * Nosotros schema for sanitization.
 *
 * @return array
 */
function echos_nosotros_admin_schema() {
	return array(
		'topbar_cta_url'         => 'url',
		'topbar_cta_label'       => 'text',
		'hero_background_image'  => 'url',
		'hero_title_prefix'      => 'text',
		'hero_title_accent'      => 'text',
		'hero_description'       => 'textarea',
		'team_image'             => 'url',
		'team_image_alt'         => 'text',
		'description_paragraphs' => array(
			'_type'  => 'repeater',
			'fields' => array(
				'text' => 'textarea',
			),
		),
		'history_title'          => 'text',
		'history_slides'         => array(
			'_type'  => 'repeater',
			'fields' => array(
				'year'        => 'text',
				'title'       => 'text',
				'description' => 'textarea',
			),
		),
		'mission_title'          => 'text',
		'mission_icon'           => array(
			'type'    => 'choice',
			'allowed' => array_keys( echos_nosotros_mv_icon_options() ),
		),
		'mission_description'    => 'textarea',
		'vision_title'           => 'text',
		'vision_icon'            => array(
			'type'    => 'choice',
			'allowed' => array_keys( echos_nosotros_mv_icon_options() ),
		),
		'vision_description'     => 'textarea',
		'process_title'          => 'text',
		'process_description'    => 'textarea',
		'process_steps'          => array(
			'_type'  => 'repeater',
			'fields' => array(
				'number'      => 'text',
				'title'       => 'text',
				'description' => 'textarea',
			),
		),
		'clients'                => array(
			'_type'  => 'repeater',
			'fields' => array(
				'image'      => 'url',
				'alt'        => 'text',
				'label'      => 'text',
				'logo_class' => 'text',
			),
		),
		'cta_title'              => 'text',
		'cta_text'               => 'textarea',
		'cta_primary_text'       => 'text',
		'cta_primary_url'        => 'url',
		'cta_primary_icon'       => array(
			'type'    => 'choice',
			'allowed' => array_keys( echos_nosotros_action_icon_options() ),
		),
		'cta_secondary_text'     => 'text',
		'cta_secondary_url'      => 'url',
		'cta_secondary_icon'     => array(
			'type'    => 'choice',
			'allowed' => array_keys( echos_nosotros_action_icon_options() ),
		),
	);
}

/**
 * Sanitizes data recursively based on schema.
 *
 * @param array $data   Raw data.
 * @param array $schema Schema.
 * @return array
 */
function echos_nosotros_admin_sanitize_by_schema( $data, $schema ) {
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

				$item = echos_nosotros_admin_sanitize_by_schema( $row, $rule['fields'] );
				if ( echos_nosotros_admin_row_has_content( $item ) ) {
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
			$item  = echos_nosotros_admin_sanitize_by_schema( $group, $rule );
			if ( ! empty( $item ) ) {
				$clean[ $key ] = $item;
			}
			continue;
		}

		$value = isset( $data[ $key ] ) ? $data[ $key ] : '';
		$value = echos_nosotros_admin_sanitize_scalar( $value, $rule );

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
 * @return string
 */
function echos_nosotros_admin_sanitize_scalar( $value, $rule ) {
	$type = is_array( $rule ) && isset( $rule['type'] ) ? $rule['type'] : $rule;

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
function echos_nosotros_admin_row_has_content( $row ) {
	if ( ! is_array( $row ) ) {
		return false;
	}

	foreach ( $row as $value ) {
		if ( is_array( $value ) ) {
			if ( echos_nosotros_admin_row_has_content( $value ) ) {
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
 * Loads admin JS/CSS only for nosotros template editor.
 *
 * @param string $hook Current hook.
 * @return void
 */
function echos_nosotros_enqueue_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	if ( ! $post_id ) {
		return;
	}

	if ( 'page-templates/template-nosotros.php' !== get_page_template_slug( $post_id ) ) {
		return;
	}

	$version = wp_get_theme()->get( 'Version' );
	$uri     = get_template_directory_uri();

	wp_enqueue_media();

	wp_enqueue_style(
		'echos-nosotros-admin',
		$uri . '/assets/css/admin-home-sections.css',
		array(),
		$version
	);

	wp_enqueue_script(
		'echos-nosotros-admin',
		$uri . '/assets/js/admin-home-sections.js',
		array(),
		$version,
		true
	);

	wp_localize_script(
		'echos-nosotros-admin',
		'echosHomeAdmin',
		array(
			'mediaTitle'  => __( 'Seleccionar imagen', 'echos' ),
			'mediaButton' => __( 'Usar imagen', 'echos' ),
		)
	);
}


