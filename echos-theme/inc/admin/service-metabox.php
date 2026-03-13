<?php
/**
 * Service templates admin metabox.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'echos_service_register_admin_metabox', 10, 2 );
add_action( 'save_post_page', 'echos_service_save_admin_metabox', 10, 2 );
add_action( 'save_post_servicio', 'echos_service_save_admin_metabox', 10, 2 );
add_action( 'admin_enqueue_scripts', 'echos_service_enqueue_admin_assets' );

/**
 * Returns supported service templates map.
 *
 * @return array
 */
function echos_service_admin_template_map() {
	return array(
		'page-templates/template-servicios-infraestructura.php' => __( 'Servicio - Infraestructura', 'echos' ),
		'page-templates/template-servicios-iluminacion.php'     => __( 'Servicio - Iluminacion', 'echos' ),
		'page-templates/template-servicios-stands.php'          => __( 'Servicio - Stands para Ferias', 'echos' ),
	);
}

/**
 * Checks if template slug is a service template.
 *
 * @param string $template_slug Template slug.
 * @return bool
 */
function echos_service_admin_is_supported_template( $template_slug ) {
	$map = echos_service_admin_template_map();

	return isset( $map[ $template_slug ] );
}

/**
 * Checks if page ID uses one of the service templates.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function echos_service_admin_is_service_page( $post_id ) {
	$template_slug = get_page_template_slug( $post_id );

	return echos_service_admin_is_supported_template( $template_slug );
}

/**
 * Registers metabox for service templates.
 *
 * @param string  $post_type Post type.
 * @param WP_Post $post      Post object.
 * @return void
 */
function echos_service_register_admin_metabox( $post_type, $post ) {
	if ( ! in_array( $post_type, array( 'page', 'servicio' ), true ) || ! $post instanceof WP_Post ) {
		return;
	}

	if ( ! echos_service_admin_is_service_page( $post->ID ) ) {
		return;
	}

	add_meta_box(
		'echos_service_sections_metabox',
		__( 'Servicios: Contenido Administrable (3 templates)', 'echos' ),
		'echos_service_render_admin_metabox',
		$post_type,
		'normal',
		'high'
	);
}

/**
 * Renders metabox UI.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function echos_service_render_admin_metabox( $post ) {
	$data         = echos_service_get_data( $post->ID );
	$template_map = echos_service_admin_template_map();
	$template     = get_page_template_slug( $post->ID );
	$active_label = isset( $template_map[ $template ] ) ? $template_map[ $template ] : __( 'No definida', 'echos' );

	wp_nonce_field( 'echos_service_save_sections', 'echos_service_sections_nonce' );
	?>
	<div class="echos-home-admin">
		<p class="description">
			<?php esc_html_e( 'Edita aqui los datos de los 3 templates de servicio. Al cambiar la plantilla en Atributos de pagina, la informacion queda guardada y el nuevo template se renderiza con su propio set de datos.', 'echos' ); ?>
		</p>
		<p><strong><?php esc_html_e( 'Plantilla activa:', 'echos' ); ?></strong> <?php echo esc_html( $active_label ); ?></p>

		<?php echos_service_admin_render_variant_infraestructura( $data ); ?>
		<?php echos_service_admin_render_variant_iluminacion( $data ); ?>
		<?php echos_service_admin_render_variant_stands( $data ); ?>
	</div>
	<?php
}

/**
 * Renders infraestructura panel.
 *
 * @param array $data Current data.
 * @return void
 */
function echos_service_admin_render_variant_infraestructura( $data ) {
	$variant = 'infraestructura';
	?>
	<details class="echos-home-admin__section" open>
		<summary><?php esc_html_e( 'Template: Infraestructura', 'echos' ); ?></summary>
		<div class="echos-home-admin__section-body">
			<?php echos_service_admin_render_hero_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_infra_systems_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_products_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_featured_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_certifications_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_other_services_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_final_cta_fields( $data, $variant ); ?>
		</div>
	</details>
	<?php
}

/**
 * Renders iluminacion panel.
 *
 * @param array $data Current data.
 * @return void
 */
function echos_service_admin_render_variant_iluminacion( $data ) {
	$variant = 'iluminacion';
	?>
	<details class="echos-home-admin__section">
		<summary><?php esc_html_e( 'Template: Iluminacion', 'echos' ); ?></summary>
		<div class="echos-home-admin__section-body">
			<?php echos_service_admin_render_hero_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_iluminacion_systems_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_products_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_iluminacion_additional_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_featured_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_other_services_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_final_cta_fields( $data, $variant ); ?>
		</div>
	</details>
	<?php
}

/**
 * Renders stands panel.
 *
 * @param array $data Current data.
 * @return void
 */
function echos_service_admin_render_variant_stands( $data ) {
	$variant = 'stands';
	?>
	<details class="echos-home-admin__section">
		<summary><?php esc_html_e( 'Template: Stands para Ferias', 'echos' ); ?></summary>
		<div class="echos-home-admin__section-body">
			<?php echos_service_admin_render_hero_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_stands_description_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_stands_ficha_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_products_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_featured_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_stands_additional_slider_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_stands_furniture_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_other_services_fields( $data, $variant ); ?>
			<?php echos_service_admin_render_final_cta_fields( $data, $variant ); ?>
		</div>
	</details>
	<?php
}

/**
 * Renders hero fields for a variant.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_hero_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Hero', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Imagen de fondo', 'echos' ),
			'path'  => array( $variant, 'hero', 'background_image' ),
			'type'  => 'image',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'URL CTA topbar', 'echos' ),
			'path'  => array( $variant, 'hero', 'topbar_cta_url' ),
			'type'  => 'url',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'hero', 'title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Descripcion', 'echos' ),
			'path'  => array( $variant, 'hero', 'description' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Texto boton', 'echos' ),
			'path'  => array( $variant, 'hero', 'button_text' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'URL boton', 'echos' ),
			'path'  => array( $variant, 'hero', 'button_url' ),
			'type'  => 'url',
		)
	);
}

/**
 * Renders infraestructura systems fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_infra_systems_fields( $data, $variant ) {
	echos_service_admin_render_repeater(
		array(
			'title'      => __( 'Sistemas (infraestructura)', 'echos' ),
			'item_label' => __( 'Bloque', 'echos' ),
			'add_label'  => __( 'Agregar bloque', 'echos' ),
			'name_path'  => array( $variant, 'systems', 'rows' ),
			'rows'       => echos_service_admin_get_nested_value( $data, array( $variant, 'systems', 'rows' ), array() ),
			'fields'     => array(
				array(
					'key'   => 'title',
					'label' => __( 'Titulo', 'echos' ),
					'type'  => 'text',
				),
				array(
					'key'   => 'paragraph_1',
					'label' => __( 'Parrafo 1', 'echos' ),
					'type'  => 'textarea',
					'wide'  => true,
				),
				array(
					'key'   => 'paragraph_2',
					'label' => __( 'Parrafo 2', 'echos' ),
					'type'  => 'textarea',
					'wide'  => true,
				),
				array(
					'key'   => 'image',
					'label' => __( 'Imagen', 'echos' ),
					'type'  => 'image',
				),
				array(
					'key'   => 'alt',
					'label' => __( 'ALT imagen', 'echos' ),
					'type'  => 'text',
				),
				array(
					'key'     => 'reverse',
					'label'   => __( 'Invertir bloque (imagen izquierda)', 'echos' ),
					'type'    => 'select',
					'options' => array(
						'no'  => __( 'No', 'echos' ),
						'yes' => __( 'Si', 'echos' ),
					),
				),
			),
		)
	);
}
/**
 * Renders iluminacion systems fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_iluminacion_systems_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Seccion descriptiva (iluminacion)', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'systems_text', 'title' ),
		)
	);

	echos_service_admin_render_repeater(
		array(
			'title'      => __( 'Parrafos', 'echos' ),
			'item_label' => __( 'Parrafo', 'echos' ),
			'add_label'  => __( 'Agregar parrafo', 'echos' ),
			'name_path'  => array( $variant, 'systems_text', 'paragraphs' ),
			'rows'       => echos_service_admin_get_nested_value( $data, array( $variant, 'systems_text', 'paragraphs' ), array() ),
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
}

/**
 * Renders products fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_products_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Productos', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'products', 'title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Subtitulo', 'echos' ),
			'path'  => array( $variant, 'products', 'subtitle' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Texto boton CTA', 'echos' ),
			'path'  => array( $variant, 'products', 'cta_text' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'URL boton CTA', 'echos' ),
			'path'  => array( $variant, 'products', 'cta_url' ),
			'type'  => 'url',
		)
	);

	echos_service_admin_render_repeater(
		array(
			'title'      => __( 'Cards de producto', 'echos' ),
			'item_label' => __( 'Producto', 'echos' ),
			'add_label'  => __( 'Agregar producto', 'echos' ),
			'name_path'  => array( $variant, 'products', 'items' ),
			'rows'       => echos_service_admin_get_nested_value( $data, array( $variant, 'products', 'items' ), array() ),
			'fields'     => array(
				array(
					'key'   => 'image',
					'label' => __( 'Imagen', 'echos' ),
					'type'  => 'image',
				),
				array(
					'key'   => 'alt',
					'label' => __( 'ALT imagen', 'echos' ),
					'type'  => 'text',
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
					'key'     => 'icon',
					'label'   => __( 'Icono', 'echos' ),
					'type'    => 'select',
					'options' => array(
						'plus'     => __( 'Mas (+)', 'echos' ),
						'external' => __( 'Flecha externa', 'echos' ),
					),
				),
			),
		)
	);
}

/**
 * Renders featured fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_featured_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Proyectos destacados', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'featured', 'title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Subtitulo', 'echos' ),
			'path'  => array( $variant, 'featured', 'subtitle' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Texto boton final', 'echos' ),
			'path'  => array( $variant, 'featured', 'cta_text' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'URL boton final', 'echos' ),
			'path'  => array( $variant, 'featured', 'cta_url' ),
			'type'  => 'url',
		)
	);

	echos_service_admin_render_repeater(
		array(
			'title'      => __( 'Cards de proyecto', 'echos' ),
			'item_label' => __( 'Proyecto', 'echos' ),
			'add_label'  => __( 'Agregar proyecto', 'echos' ),
			'name_path'  => array( $variant, 'featured', 'cards' ),
			'rows'       => echos_service_admin_get_nested_value( $data, array( $variant, 'featured', 'cards' ), array() ),
			'fields'     => array(
				array(
					'key'   => 'image',
					'label' => __( 'Imagen', 'echos' ),
					'type'  => 'image',
				),
				array(
					'key'   => 'badge',
					'label' => __( 'Badge / Categoria', 'echos' ),
					'type'  => 'text',
				),
				array(
					'key'   => 'name',
					'label' => __( 'Nombre', 'echos' ),
					'type'  => 'text',
				),
				array(
					'key'   => 'date',
					'label' => __( 'Fecha visible', 'echos' ),
					'type'  => 'text',
				),
				array(
					'key'   => 'url',
					'label' => __( 'URL', 'echos' ),
					'type'  => 'url',
				),
			),
		)
	);
}

/**
 * Renders infraestructura certifications fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_certifications_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Certificaciones', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'certifications', 'title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Subtitulo', 'echos' ),
			'path'  => array( $variant, 'certifications', 'subtitle' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_repeater(
		array(
			'title'      => __( 'Cards de certificacion', 'echos' ),
			'item_label' => __( 'Card', 'echos' ),
			'add_label'  => __( 'Agregar card', 'echos' ),
			'name_path'  => array( $variant, 'certifications', 'cards' ),
			'rows'       => echos_service_admin_get_nested_value( $data, array( $variant, 'certifications', 'cards' ), array() ),
			'fields'     => array(
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
}

/**
 * Renders iluminacion additional fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_iluminacion_additional_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Servicios adicionales (iluminacion)', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'additional', 'title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Subtitulo', 'echos' ),
			'path'  => array( $variant, 'additional', 'subtitle' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Imagen card', 'echos' ),
			'path'  => array( $variant, 'additional', 'card_image' ),
			'type'  => 'image',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'ALT imagen', 'echos' ),
			'path'  => array( $variant, 'additional', 'card_alt' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo card', 'echos' ),
			'path'  => array( $variant, 'additional', 'card_title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Texto card', 'echos' ),
			'path'  => array( $variant, 'additional', 'card_text' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Texto boton card', 'echos' ),
			'path'  => array( $variant, 'additional', 'button_text' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'URL boton card', 'echos' ),
			'path'  => array( $variant, 'additional', 'button_url' ),
			'type'  => 'url',
		)
	);
}
/**
 * Renders stands description fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_stands_description_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Descripcion principal (stands)', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'description', 'title' ),
		)
	);

	echos_service_admin_render_repeater(
		array(
			'title'      => __( 'Parrafos', 'echos' ),
			'item_label' => __( 'Parrafo', 'echos' ),
			'add_label'  => __( 'Agregar parrafo', 'echos' ),
			'name_path'  => array( $variant, 'description', 'paragraphs' ),
			'rows'       => echos_service_admin_get_nested_value( $data, array( $variant, 'description', 'paragraphs' ), array() ),
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
}

/**
 * Renders stands ficha fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_stands_ficha_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Ficha tecnica (stands)', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Imagen', 'echos' ),
			'path'  => array( $variant, 'ficha', 'image' ),
			'type'  => 'image',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'ALT imagen', 'echos' ),
			'path'  => array( $variant, 'ficha', 'alt' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'ficha', 'title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Texto', 'echos' ),
			'path'  => array( $variant, 'ficha', 'text' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Texto boton', 'echos' ),
			'path'  => array( $variant, 'ficha', 'button_text' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'URL boton', 'echos' ),
			'path'  => array( $variant, 'ficha', 'button_url' ),
			'type'  => 'url',
		)
	);
}

/**
 * Renders stands additional slider fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_stands_additional_slider_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Servicios adicionales (slider stands)', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'additional_slider', 'title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Subtitulo', 'echos' ),
			'path'  => array( $variant, 'additional_slider', 'subtitle' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_repeater(
		array(
			'title'      => __( 'Cards del slider', 'echos' ),
			'item_label' => __( 'Card', 'echos' ),
			'add_label'  => __( 'Agregar card', 'echos' ),
			'name_path'  => array( $variant, 'additional_slider', 'items' ),
			'rows'       => echos_service_admin_get_nested_value( $data, array( $variant, 'additional_slider', 'items' ), array() ),
			'fields'     => array(
				array(
					'key'   => 'image',
					'label' => __( 'Imagen', 'echos' ),
					'type'  => 'image',
				),
				array(
					'key'   => 'alt',
					'label' => __( 'ALT imagen', 'echos' ),
					'type'  => 'text',
				),
				array(
					'key'   => 'title',
					'label' => __( 'Titulo', 'echos' ),
					'type'  => 'text',
				),
				array(
					'key'   => 'text',
					'label' => __( 'Texto', 'echos' ),
					'type'  => 'textarea',
					'wide'  => true,
				),
				array(
					'key'   => 'button_text',
					'label' => __( 'Texto boton', 'echos' ),
					'type'  => 'text',
				),
				array(
					'key'   => 'button_url',
					'label' => __( 'URL boton', 'echos' ),
					'type'  => 'url',
				),
			),
		)
	);
}

/**
 * Renders stands furniture fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_stands_furniture_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Mobiliario (stands)', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'furniture', 'title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Subtitulo', 'echos' ),
			'path'  => array( $variant, 'furniture', 'subtitle' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Texto boton brochure', 'echos' ),
			'path'  => array( $variant, 'furniture', 'cta_text' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'URL boton brochure', 'echos' ),
			'path'  => array( $variant, 'furniture', 'cta_url' ),
			'type'  => 'url',
		)
	);

	echos_service_admin_render_repeater(
		array(
			'title'      => __( 'Items de mobiliario', 'echos' ),
			'item_label' => __( 'Item', 'echos' ),
			'add_label'  => __( 'Agregar item', 'echos' ),
			'name_path'  => array( $variant, 'furniture', 'items' ),
			'rows'       => echos_service_admin_get_nested_value( $data, array( $variant, 'furniture', 'items' ), array() ),
			'fields'     => array(
				array(
					'key'   => 'image',
					'label' => __( 'Imagen', 'echos' ),
					'type'  => 'image',
				),
				array(
					'key'   => 'alt',
					'label' => __( 'ALT imagen', 'echos' ),
					'type'  => 'text',
				),
				array(
					'key'   => 'label',
					'label' => __( 'Nombre visible', 'echos' ),
					'type'  => 'text',
				),
			),
		)
	);
}

/**
 * Renders other services fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_other_services_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'Otros servicios', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo seccion', 'echos' ),
			'path'  => array( $variant, 'other_services', 'title' ),
		)
	);

	echos_service_admin_render_repeater(
		array(
			'title'      => __( 'Cards de otros servicios', 'echos' ),
			'item_label' => __( 'Servicio', 'echos' ),
			'add_label'  => __( 'Agregar servicio', 'echos' ),
			'name_path'  => array( $variant, 'other_services', 'items' ),
			'rows'       => echos_service_admin_get_nested_value( $data, array( $variant, 'other_services', 'items' ), array() ),
			'fields'     => array(
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
				array(
					'key'   => 'url',
					'label' => __( 'URL', 'echos' ),
					'type'  => 'url',
				),
				array(
					'key'     => 'bg_variant',
					'label'   => __( 'Fondo visual', 'echos' ),
					'type'    => 'select',
					'options' => array(
						'iluminacion' => __( 'Iluminacion', 'echos' ),
						'stands'      => __( 'Stands', 'echos' ),
					),
				),
			),
		)
	);
}

/**
 * Renders final CTA fields.
 *
 * @param array  $data    Current data.
 * @param string $variant Variant key.
 * @return void
 */
function echos_service_admin_render_final_cta_fields( $data, $variant ) {
	echo '<h4>' . esc_html__( 'CTA final', 'echos' ) . '</h4>';

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Titulo', 'echos' ),
			'path'  => array( $variant, 'final_cta', 'title' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Texto', 'echos' ),
			'path'  => array( $variant, 'final_cta', 'text' ),
			'type'  => 'textarea',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Boton principal - texto', 'echos' ),
			'path'  => array( $variant, 'final_cta', 'primary_text' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Boton principal - URL', 'echos' ),
			'path'  => array( $variant, 'final_cta', 'primary_url' ),
			'type'  => 'url',
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Boton secundario - texto', 'echos' ),
			'path'  => array( $variant, 'final_cta', 'secondary_text' ),
		)
	);

	echos_service_admin_render_single_field(
		$data,
		array(
			'label' => __( 'Boton secundario - URL', 'echos' ),
			'path'  => array( $variant, 'final_cta', 'secondary_url' ),
			'type'  => 'url',
		)
	);
}
/**
 * Renders a normal (non repeater) field.
 *
 * @param array $data Current data.
 * @param array $args Field args.
 * @return void
 */
function echos_service_admin_render_single_field( $data, $args ) {
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

	$name  = echos_service_admin_build_name( $args['path'] );
	$value = echos_service_admin_get_nested_value( $data, $args['path'], '' );

	echo '<div class="echos-home-field">';
	echo '<label class="echos-home-field__label">' . esc_html( $args['label'] ) . '</label>';
	echos_service_admin_render_field_control( $args['type'], $name, $value, $args['placeholder'], $args['options'] );
	echo '</div>';
}

/**
 * Renders a repeater UI.
 *
 * @param array $args Repeater args.
 * @return void
 */
function echos_service_admin_render_repeater( $args ) {
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
		echos_service_admin_render_repeater_row( $args['name_path'], $index, $row, $args['fields'], $args['item_label'] );
	}

	echo '</div>';
	echo '<button type="button" class="button button-secondary" data-home-add-row>' . esc_html( $args['add_label'] ) . '</button>';
	echo '<template data-home-row-template>';
	echos_service_admin_render_repeater_row( $args['name_path'], '__index__', array(), $args['fields'], $args['item_label'] );
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
function echos_service_admin_render_repeater_row( $path, $index, $row, $fields, $item_label ) {
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
		$name          = echos_service_admin_build_repeater_name( $path, $index, $key );
		$name_template = echos_service_admin_build_repeater_name( $path, '__index__', $key );

		echo '<div class="echos-home-field ' . ( $wide ? 'is-wide' : '' ) . '">';
		echo '<label class="echos-home-field__label">' . esc_html( $label ) . '</label>';
		echos_service_admin_render_field_control( $type, $name, $value, $placeholder, $options, $name_template );
		echo '</div>';
	}

	echo '</div>';
	echo '</div>';
}

/**
 * Renders field control.
 *
 * @param string $type          Field type.
 * @param string $name          Field name.
 * @param mixed  $value         Value.
 * @param string $placeholder   Placeholder.
 * @param array  $options       Select options.
 * @param string $name_template Name template for repeater renumber.
 * @return void
 */
function echos_service_admin_render_field_control( $type, $name, $value, $placeholder = '', $options = array(), $name_template = '' ) {
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
			echos_service_admin_render_image_control( $name, $value, $template_attr );
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
function echos_service_admin_render_image_control( $name, $value, $template_attr ) {
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
 * Gets nested value from array.
 *
 * @param array $data    Source data.
 * @param array $path    Key path.
 * @param mixed $default Default value.
 * @return mixed
 */
function echos_service_admin_get_nested_value( $data, $path, $default = '' ) {
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
function echos_service_admin_build_name( $path ) {
	$name = 'echos_service_data';

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
function echos_service_admin_build_repeater_name( $path, $index, $field_key ) {
	$name = echos_service_admin_build_name( $path );
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
function echos_service_save_admin_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['echos_service_sections_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_service_sections_nonce'] ) ), 'echos_service_save_sections' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) ) {
		return;
	}

	if ( ! $post instanceof WP_Post || ! in_array( $post->post_type, array( 'page', 'servicio' ), true ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	if ( ! echos_service_admin_is_service_page( $post_id ) ) {
		return;
	}

	$raw = array();
	if ( isset( $_POST['echos_service_data'] ) && is_array( $_POST['echos_service_data'] ) ) {
		$raw = wp_unslash( $_POST['echos_service_data'] );
	}

	$sanitized = echos_service_admin_sanitize_by_schema( $raw, echos_service_admin_schema() );

	if ( empty( $sanitized ) ) {
		delete_post_meta( $post_id, '_echos_service_sections' );
		return;
	}

	update_post_meta( $post_id, '_echos_service_sections', $sanitized );
}
/**
 * Service schema for sanitization.
 *
 * @return array
 */
function echos_service_admin_schema() {
	$hero_schema = array(
		'background_image' => 'url',
		'topbar_cta_url'   => 'url',
		'title'            => 'text',
		'description'      => 'textarea',
		'button_text'      => 'text',
		'button_url'       => 'url',
	);

	$products_schema = array(
		'title'    => 'text',
		'subtitle' => 'textarea',
		'cta_text' => 'text',
		'cta_url'  => 'url',
		'items'    => array(
			'_type'  => 'repeater',
			'fields' => array(
				'image' => 'url',
				'alt'   => 'text',
				'label' => 'text',
				'url'   => 'url',
				'icon'  => array(
					'type'    => 'choice',
					'allowed' => array( 'plus', 'external' ),
				),
			),
		),
	);

	$featured_schema = array(
		'title'    => 'text',
		'subtitle' => 'textarea',
		'cta_text' => 'text',
		'cta_url'  => 'url',
		'cards'    => array(
			'_type'  => 'repeater',
			'fields' => array(
				'image' => 'url',
				'badge' => 'text',
				'name'  => 'text',
				'date'  => 'text',
				'url'   => 'url',
			),
		),
	);

	$other_services_schema = array(
		'title' => 'text',
		'items' => array(
			'_type'  => 'repeater',
			'fields' => array(
				'title'       => 'text',
				'description' => 'textarea',
				'url'         => 'url',
				'bg_variant'  => array(
					'type'    => 'choice',
					'allowed' => array( 'iluminacion', 'stands' ),
				),
			),
		),
	);

	$final_cta_schema = array(
		'title'          => 'text',
		'text'           => 'textarea',
		'primary_text'   => 'text',
		'primary_url'    => 'url',
		'secondary_text' => 'text',
		'secondary_url'  => 'url',
	);

	return array(
		'infraestructura' => array(
			'hero'           => $hero_schema,
			'systems'        => array(
				'rows' => array(
					'_type'  => 'repeater',
					'fields' => array(
						'title'       => 'text',
						'paragraph_1' => 'textarea',
						'paragraph_2' => 'textarea',
						'image'       => 'url',
						'alt'         => 'text',
						'reverse'     => array(
							'type'    => 'choice',
							'allowed' => array( 'no', 'yes' ),
						),
					),
				),
			),
			'products'       => $products_schema,
			'featured'       => $featured_schema,
			'certifications' => array(
				'title'    => 'text',
				'subtitle' => 'textarea',
				'cards'    => array(
					'_type'  => 'repeater',
					'fields' => array(
						'title'       => 'text',
						'description' => 'textarea',
					),
				),
			),
			'other_services' => $other_services_schema,
			'final_cta'      => $final_cta_schema,
		),
		'iluminacion'     => array(
			'hero'           => $hero_schema,
			'systems_text'   => array(
				'title'      => 'text',
				'paragraphs' => array(
					'_type'  => 'repeater',
					'fields' => array(
						'text' => 'textarea',
					),
				),
			),
			'products'       => $products_schema,
			'additional'     => array(
				'title'       => 'text',
				'subtitle'    => 'textarea',
				'card_image'  => 'url',
				'card_alt'    => 'text',
				'card_title'  => 'text',
				'card_text'   => 'textarea',
				'button_text' => 'text',
				'button_url'  => 'url',
			),
			'featured'       => $featured_schema,
			'other_services' => $other_services_schema,
			'final_cta'      => $final_cta_schema,
		),
		'stands'          => array(
			'hero'              => $hero_schema,
			'description'       => array(
				'title'      => 'text',
				'paragraphs' => array(
					'_type'  => 'repeater',
					'fields' => array(
						'text' => 'textarea',
					),
				),
			),
			'ficha'             => array(
				'image'       => 'url',
				'alt'         => 'text',
				'title'       => 'text',
				'text'        => 'textarea',
				'button_text' => 'text',
				'button_url'  => 'url',
			),
			'products'          => $products_schema,
			'featured'          => $featured_schema,
			'additional_slider' => array(
				'title'    => 'text',
				'subtitle' => 'textarea',
				'items'    => array(
					'_type'  => 'repeater',
					'fields' => array(
						'image'       => 'url',
						'alt'         => 'text',
						'title'       => 'text',
						'text'        => 'textarea',
						'button_text' => 'text',
						'button_url'  => 'url',
					),
				),
			),
			'furniture'         => array(
				'title'    => 'text',
				'subtitle' => 'textarea',
				'cta_text' => 'text',
				'cta_url'  => 'url',
				'items'    => array(
					'_type'  => 'repeater',
					'fields' => array(
						'image' => 'url',
						'alt'   => 'text',
						'label' => 'text',
					),
				),
			),
			'other_services'    => $other_services_schema,
			'final_cta'         => $final_cta_schema,
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
function echos_service_admin_sanitize_by_schema( $data, $schema ) {
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

				$item = echos_service_admin_sanitize_by_schema( $row, $rule['fields'] );
				if ( echos_service_admin_row_has_content( $item ) ) {
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
			$item  = echos_service_admin_sanitize_by_schema( $group, $rule );
			if ( ! empty( $item ) ) {
				$clean[ $key ] = $item;
			}
			continue;
		}

		$value = isset( $data[ $key ] ) ? $data[ $key ] : '';
		$value = echos_service_admin_sanitize_scalar( $value, $rule );

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
function echos_service_admin_sanitize_scalar( $value, $rule ) {
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
 * Checks if repeater row has content.
 *
 * @param array $row Row data.
 * @return bool
 */
function echos_service_admin_row_has_content( $row ) {
	if ( ! is_array( $row ) ) {
		return false;
	}

	foreach ( $row as $value ) {
		if ( is_array( $value ) ) {
			if ( echos_service_admin_row_has_content( $value ) ) {
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
 * Loads admin JS/CSS only for service templates.
 *
 * @param string $hook Current hook.
 * @return void
 */
function echos_service_enqueue_admin_assets( $hook ) {
	if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ), true ) ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	if ( ! $post_id ) {
		return;
	}

	if ( ! echos_service_admin_is_service_page( $post_id ) ) {
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
