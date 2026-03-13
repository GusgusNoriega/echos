<?php
/**
 * Home template admin metabox.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'echos_home_register_admin_metabox', 10, 2 );
add_action( 'save_post_page', 'echos_home_save_admin_metabox', 10, 2 );
add_action( 'admin_enqueue_scripts', 'echos_home_enqueue_admin_assets' );

/**
 * Registers the metabox for the home page template.
 *
 * @param string  $post_type Post type.
 * @param WP_Post $post      Post object.
 * @return void
 */
function echos_home_register_admin_metabox( $post_type, $post ) {
	if ( 'page' !== $post_type || ! $post instanceof WP_Post ) {
		return;
	}

	if ( 'page-templates/template-inicio.php' !== get_page_template_slug( $post->ID ) ) {
		return;
	}

	add_meta_box(
		'echos_home_sections_metabox',
		__( 'Inicio: Secciones Administrables', 'echos' ),
		'echos_home_render_admin_metabox',
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
function echos_home_render_admin_metabox( $post ) {
	$data = echos_home_get_data( $post->ID );

	wp_nonce_field( 'echos_home_save_sections', 'echos_home_sections_nonce' );
	?>
	<div class="echos-home-admin">
		<p class="description">
			<?php esc_html_e( 'Administra cada seccion de la portada desde aqui. Si dejas un campo vacio, se mantiene el valor por defecto del tema.', 'echos' ); ?>
		</p>

		<details class="echos-home-admin__section" open>
			<summary><?php esc_html_e( 'Hero', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_home_admin_render_single_field(
					$data,
					array(
						'label'       => __( 'URL del boton superior (CTA)', 'echos' ),
						'path'        => array( 'hero', 'cta_url' ),
						'type'        => 'url',
						'placeholder' => '#contacto',
					)
				);

				echos_home_admin_render_repeater(
					array(
						'title'       => __( 'Slides', 'echos' ),
						'item_label'  => __( 'Slide', 'echos' ),
						'add_label'   => __( 'Agregar slide', 'echos' ),
						'name_path'   => array( 'hero', 'slides' ),
						'rows'        => echos_home_admin_get_nested_value( $data, array( 'hero', 'slides' ), array() ),
						'fields'      => array(
							array(
								'key'   => 'image',
								'label' => __( 'Imagen', 'echos' ),
								'type'  => 'image',
							),
							array(
								'key'         => 'accent',
								'label'       => __( 'Texto destacado', 'echos' ),
								'type'        => 'text',
								'placeholder' => 'CREAMOS',
							),
							array(
								'key'         => 'title',
								'label'       => __( 'Titulo (usa salto de linea para <br>)', 'echos' ),
								'type'        => 'textarea',
								'placeholder' => "ESPECTACULOS\nMEMORABLES",
								'wide'        => true,
							),
							array(
								'key'         => 'description',
								'label'       => __( 'Descripcion', 'echos' ),
								'type'        => 'textarea',
								'wide'        => true,
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
				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Titulo', 'echos' ),
						'path'  => array( 'clients', 'title' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Subtitulo', 'echos' ),
						'path'  => array( 'clients', 'subtitle' ),
						'type'  => 'textarea',
					)
				);

				echos_home_admin_render_repeater(
					array(
						'title'      => __( 'Logos de clientes', 'echos' ),
						'item_label' => __( 'Logo', 'echos' ),
						'add_label'  => __( 'Agregar logo', 'echos' ),
						'name_path'  => array( 'clients', 'logos' ),
						'rows'       => echos_home_admin_get_nested_value( $data, array( 'clients', 'logos' ), array() ),
						'fields'     => array(
							array(
								'key'   => 'image',
								'label' => __( 'Imagen', 'echos' ),
								'type'  => 'image',
							),
							array(
								'key'   => 'alt',
								'label' => __( 'Texto ALT', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'         => 'logo_class',
								'label'       => __( 'Clase CSS extra', 'echos' ),
								'type'        => 'text',
								'placeholder' => 'clients__logo--bcp',
							),
						),
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'Conocenos', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Titulo', 'echos' ),
						'path'  => array( 'about', 'title' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Texto', 'echos' ),
						'path'  => array( 'about', 'text' ),
						'type'  => 'textarea',
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Texto del boton', 'echos' ),
						'path'  => array( 'about', 'button_text' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'URL del boton', 'echos' ),
						'path'  => array( 'about', 'button_url' ),
						'type'  => 'url',
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Imagen principal', 'echos' ),
						'path'  => array( 'about', 'image' ),
						'type'  => 'image',
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'Proyectos', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Titulo', 'echos' ),
						'path'  => array( 'projects', 'title' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Subtitulo', 'echos' ),
						'path'  => array( 'projects', 'subtitle' ),
						'type'  => 'textarea',
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Texto boton final', 'echos' ),
						'path'  => array( 'projects', 'cta_text' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'URL boton final', 'echos' ),
						'path'  => array( 'projects', 'cta_url' ),
						'type'  => 'url',
					)
				);

				echos_home_admin_render_repeater(
					array(
						'title'      => __( 'Tarjetas de proyecto', 'echos' ),
						'item_label' => __( 'Proyecto', 'echos' ),
						'add_label'  => __( 'Agregar proyecto', 'echos' ),
						'name_path'  => array( 'projects', 'cards' ),
						'rows'       => echos_home_admin_get_nested_value( $data, array( 'projects', 'cards' ), array() ),
						'fields'     => array(
							array(
								'key'   => 'image',
								'label' => __( 'Imagen', 'echos' ),
								'type'  => 'image',
							),
							array(
								'key'   => 'chip',
								'label' => __( 'Categoria', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'   => 'title',
								'label' => __( 'Titulo', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'   => 'date',
								'label' => __( 'Fecha visible', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'   => 'url',
								'label' => __( 'URL del proyecto', 'echos' ),
								'type'  => 'url',
							),
							array(
								'key'     => 'variant',
								'label'   => __( 'Color de tarjeta', 'echos' ),
								'type'    => 'select',
								'options' => array(
									'blue'   => 'Blue',
									'red'    => 'Red',
									'green'  => 'Green',
									'purple' => 'Purple',
								),
							),
						),
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'Servicios', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Titulo', 'echos' ),
						'path'  => array( 'services', 'title' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Subtitulo', 'echos' ),
						'path'  => array( 'services', 'subtitle' ),
						'type'  => 'textarea',
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Texto boton final', 'echos' ),
						'path'  => array( 'services', 'cta_text' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'URL boton final', 'echos' ),
						'path'  => array( 'services', 'cta_url' ),
						'type'  => 'url',
					)
				);

				echos_home_admin_render_repeater(
					array(
						'title'      => __( 'Items de servicio', 'echos' ),
						'item_label' => __( 'Servicio', 'echos' ),
						'add_label'  => __( 'Agregar servicio', 'echos' ),
						'name_path'  => array( 'services', 'items' ),
						'rows'       => echos_home_admin_get_nested_value( $data, array( 'services', 'items' ), array() ),
						'fields'     => array(
							array(
								'key'   => 'image',
								'label' => __( 'Imagen', 'echos' ),
								'type'  => 'image',
							),
							array(
								'key'   => 'label',
								'label' => __( 'Titulo', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'   => 'url',
								'label' => __( 'URL', 'echos' ),
								'type'  => 'url',
							),
							array(
								'key'     => 'variant',
								'label'   => __( 'Color de thumb', 'echos' ),
								'type'    => 'select',
								'options' => array(
									'stage'  => 'Stage',
									'lights' => 'Lights',
									'booth'  => 'Booth',
								),
							),
						),
					)
				);
				?>
			</div>
		</details>

		<details class="echos-home-admin__section">
			<summary><?php esc_html_e( 'Contacto', 'echos' ); ?></summary>
			<div class="echos-home-admin__section-body">
				<?php
				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Titulo (usa salto de linea)', 'echos' ),
						'path'  => array( 'contact', 'title' ),
						'type'  => 'textarea',
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Texto descriptivo', 'echos' ),
						'path'  => array( 'contact', 'text' ),
						'type'  => 'textarea',
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Accion principal - texto', 'echos' ),
						'path'  => array( 'contact', 'action_primary_text' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Accion principal - URL', 'echos' ),
						'path'  => array( 'contact', 'action_primary_url' ),
						'type'  => 'url',
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Accion secundaria - texto', 'echos' ),
						'path'  => array( 'contact', 'action_secondary_text' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Accion secundaria - URL', 'echos' ),
						'path'  => array( 'contact', 'action_secondary_url' ),
						'type'  => 'url',
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Texto de ayuda del formulario', 'echos' ),
						'path'  => array( 'contact', 'form_hint' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Texto del boton enviar', 'echos' ),
						'path'  => array( 'contact', 'submit_text' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Placeholder Nombre', 'echos' ),
						'path'  => array( 'contact', 'placeholder_name' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Placeholder Empresa', 'echos' ),
						'path'  => array( 'contact', 'placeholder_company' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Placeholder Email', 'echos' ),
						'path'  => array( 'contact', 'placeholder_email' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Placeholder Telefono', 'echos' ),
						'path'  => array( 'contact', 'placeholder_phone' ),
					)
				);

				echos_home_admin_render_single_field(
					$data,
					array(
						'label' => __( 'Placeholder Detalle', 'echos' ),
						'path'  => array( 'contact', 'placeholder_detail' ),
					)
				);

				echos_home_admin_render_repeater(
					array(
						'title'      => __( 'Tabs del formulario', 'echos' ),
						'item_label' => __( 'Tab', 'echos' ),
						'add_label'  => __( 'Agregar tab', 'echos' ),
						'name_path'  => array( 'contact', 'tabs' ),
						'rows'       => echos_home_admin_get_nested_value( $data, array( 'contact', 'tabs' ), array() ),
						'fields'     => array(
							array(
								'key'   => 'label',
								'label' => __( 'Etiqueta visible', 'echos' ),
								'type'  => 'text',
							),
							array(
								'key'   => 'value',
								'label' => __( 'Valor interno', 'echos' ),
								'type'  => 'text',
							),
						),
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
function echos_home_admin_render_single_field( $data, $args ) {
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

	$name  = echos_home_admin_build_name( $args['path'] );
	$value = echos_home_admin_get_nested_value( $data, $args['path'], '' );

	echo '<div class="echos-home-field">';
	echo '<label class="echos-home-field__label">' . esc_html( $args['label'] ) . '</label>';
	echos_home_admin_render_field_control( $args['type'], $name, $value, $args['placeholder'], $args['options'] );
	echo '</div>';
}

/**
 * Renders a repeater UI.
 *
 * @param array $args Repeater args.
 * @return void
 */
function echos_home_admin_render_repeater( $args ) {
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
		echos_home_admin_render_repeater_row( $args['name_path'], $index, $row, $args['fields'], $args['item_label'] );
	}

	echo '</div>';
	echo '<button type="button" class="button button-secondary" data-home-add-row>' . esc_html( $args['add_label'] ) . '</button>';
	echo '<template data-home-row-template>';
	echos_home_admin_render_repeater_row( $args['name_path'], '__index__', array(), $args['fields'], $args['item_label'] );
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
function echos_home_admin_render_repeater_row( $path, $index, $row, $fields, $item_label ) {
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
		$name          = echos_home_admin_build_repeater_name( $path, $index, $key );
		$name_template = echos_home_admin_build_repeater_name( $path, '__index__', $key );

		echo '<div class="echos-home-field ' . ( $wide ? 'is-wide' : '' ) . '">';
		echo '<label class="echos-home-field__label">' . esc_html( $label ) . '</label>';
		echos_home_admin_render_field_control( $type, $name, $value, $placeholder, $options, $name_template );
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
function echos_home_admin_render_field_control( $type, $name, $value, $placeholder = '', $options = array(), $name_template = '' ) {
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
			echos_home_admin_render_image_control( $name, $value, $template_attr );
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
function echos_home_admin_render_image_control( $name, $value, $template_attr ) {
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
function echos_home_admin_get_nested_value( $data, $path, $default = '' ) {
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
function echos_home_admin_build_name( $path ) {
	$name = 'echos_home_data';

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
function echos_home_admin_build_repeater_name( $path, $index, $field_key ) {
	$name = echos_home_admin_build_name( $path );
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
function echos_home_save_admin_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['echos_home_sections_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_home_sections_nonce'] ) ), 'echos_home_save_sections' ) ) {
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

	if ( 'page-templates/template-inicio.php' !== get_page_template_slug( $post_id ) ) {
		return;
	}

	$raw = array();
	if ( isset( $_POST['echos_home_data'] ) && is_array( $_POST['echos_home_data'] ) ) {
		$raw = wp_unslash( $_POST['echos_home_data'] );
	}

	$sanitized = echos_home_admin_sanitize_by_schema( $raw, echos_home_admin_schema() );

	if ( empty( $sanitized ) ) {
		delete_post_meta( $post_id, '_echos_home_sections' );
		return;
	}

	update_post_meta( $post_id, '_echos_home_sections', $sanitized );
}

/**
 * Home schema for sanitization.
 *
 * @return array
 */
function echos_home_admin_schema() {
	return array(
		'hero'     => array(
			'cta_url' => 'url',
			'slides'  => array(
				'_type'  => 'repeater',
				'fields' => array(
					'image'       => 'url',
					'accent'      => 'text',
					'title'       => 'textarea',
					'description' => 'textarea',
				),
			),
		),
		'clients'  => array(
			'title'    => 'text',
			'subtitle' => 'textarea',
			'logos'    => array(
				'_type'  => 'repeater',
				'fields' => array(
					'image'      => 'url',
					'alt'        => 'text',
					'logo_class' => 'text',
				),
			),
		),
		'about'    => array(
			'title'       => 'text',
			'text'        => 'textarea',
			'button_text' => 'text',
			'button_url'  => 'url',
			'image'       => 'url',
		),
		'projects' => array(
			'title'    => 'text',
			'subtitle' => 'textarea',
			'cta_text' => 'text',
			'cta_url'  => 'url',
			'cards'    => array(
				'_type'  => 'repeater',
				'fields' => array(
					'image'   => 'url',
					'chip'    => 'text',
					'title'   => 'text',
					'date'    => 'text',
					'url'     => 'url',
					'variant' => array(
						'type'    => 'choice',
						'allowed' => array( 'blue', 'red', 'green', 'purple' ),
					),
				),
			),
		),
		'services' => array(
			'title'    => 'text',
			'subtitle' => 'textarea',
			'cta_text' => 'text',
			'cta_url'  => 'url',
			'items'    => array(
				'_type'  => 'repeater',
				'fields' => array(
					'image'   => 'url',
					'label'   => 'text',
					'url'     => 'url',
					'variant' => array(
						'type'    => 'choice',
						'allowed' => array( 'stage', 'lights', 'booth' ),
					),
				),
			),
		),
		'contact'  => array(
			'title'                 => 'textarea',
			'text'                  => 'textarea',
			'action_primary_text'   => 'text',
			'action_primary_url'    => 'url',
			'action_secondary_text' => 'text',
			'action_secondary_url'  => 'url',
			'form_hint'             => 'text',
			'submit_text'           => 'text',
			'placeholder_name'      => 'text',
			'placeholder_company'   => 'text',
			'placeholder_email'     => 'text',
			'placeholder_phone'     => 'text',
			'placeholder_detail'    => 'text',
			'tabs'                  => array(
				'_type'  => 'repeater',
				'fields' => array(
					'label' => 'text',
					'value' => 'text',
				),
			),
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
function echos_home_admin_sanitize_by_schema( $data, $schema ) {
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

				$item = echos_home_admin_sanitize_by_schema( $row, $rule['fields'] );
				if ( echos_home_admin_row_has_content( $item ) ) {
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
			$item  = echos_home_admin_sanitize_by_schema( $group, $rule );
			if ( ! empty( $item ) ) {
				$clean[ $key ] = $item;
			}
			continue;
		}

		$value = isset( $data[ $key ] ) ? $data[ $key ] : '';
		$value = echos_home_admin_sanitize_scalar( $value, $rule );

		if ( '' !== $value ) {
			$clean[ $key ] = $value;
		}
	}

	return $clean;
}

/**
 * Sanitizes scalar values.
 *
 * @param mixed       $value Scalar value.
 * @param string|array $rule Rule.
 * @return string
 */
function echos_home_admin_sanitize_scalar( $value, $rule ) {
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
function echos_home_admin_row_has_content( $row ) {
	if ( ! is_array( $row ) ) {
		return false;
	}

	foreach ( $row as $value ) {
		if ( is_array( $value ) ) {
			if ( echos_home_admin_row_has_content( $value ) ) {
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
 * Loads admin JS/CSS only for home template editor.
 *
 * @param string $hook Current hook.
 * @return void
 */
function echos_home_enqueue_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	if ( ! $post_id ) {
		return;
	}

	if ( 'page-templates/template-inicio.php' !== get_page_template_slug( $post_id ) ) {
		return;
	}

	$version = wp_get_theme()->get( 'Version' );
	$uri     = get_template_directory_uri();

	wp_enqueue_media();

	wp_enqueue_style(
		'echos-home-admin',
		$uri . '/assets/css/admin-home-sections.css',
		array(),
		$version
	);

	wp_enqueue_script(
		'echos-home-admin',
		$uri . '/assets/js/admin-home-sections.js',
		array(),
		$version,
		true
	);

	wp_localize_script(
		'echos-home-admin',
		'echosHomeAdmin',
		array(
			'mediaTitle'  => __( 'Seleccionar imagen', 'echos' ),
			'mediaButton' => __( 'Usar imagen', 'echos' ),
		)
	);
}
