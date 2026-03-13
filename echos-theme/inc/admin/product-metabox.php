<?php
/**
 * Product templates admin metaboxes.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'echos_product_register_admin_metaboxes', 10, 2 );
add_action( 'save_post_producto', 'echos_product_save_admin_metabox', 10, 2 );
add_action( 'save_post_page', 'echos_product_save_listing_admin_metabox', 10, 2 );

/**
 * Checks if page uses the products listing template.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function echos_product_admin_is_listing_page( $post_id ) {
	return 'page-templates/template-productos.php' === get_page_template_slug( $post_id );
}

/**
 * Registers product metaboxes.
 *
 * @param string  $post_type Post type.
 * @param WP_Post $post      Post object.
 * @return void
 */
function echos_product_register_admin_metaboxes( $post_type, $post ) {
	if ( ! $post instanceof WP_Post ) {
		return;
	}

	if ( 'producto' === $post_type ) {
		add_meta_box(
			'echos_product_sections_metabox',
			__( 'Producto: Contenido Administrable', 'echos' ),
			'echos_product_render_admin_metabox',
			'producto',
			'normal',
			'high'
		);

		return;
	}

	if ( 'page' === $post_type && echos_product_admin_is_listing_page( $post->ID ) ) {
		add_meta_box(
			'echos_product_listing_sections_metabox',
			__( 'Productos: Contenido de Listado', 'echos' ),
			'echos_product_render_listing_admin_metabox',
			'page',
			'normal',
			'high'
		);
	}
}

/**
 * Renders one metabox row.
 *
 * @param string $name  Input name.
 * @param string $label Label.
 * @param string $value Value.
 * @param string $type  Input type.
 * @param string $help  Help text.
 * @return void
 */
function echos_product_admin_render_row( $name, $label, $value, $type = 'text', $help = '' ) {
	echo '<tr>';
	echo '<th scope="row"><label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label></th>';
	echo '<td>';

	if ( 'textarea' === $type ) {
		echo '<textarea class="large-text" rows="4" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea>';
	} elseif ( 'number' === $type ) {
		echo '<input class="small-text" type="number" min="1" step="1" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
	} else {
		echo '<input class="regular-text" type="' . esc_attr( $type ) . '" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '" />';
	}

	if ( '' !== $help ) {
		echo '<p class="description">' . esc_html( $help ) . '</p>';
	}

	echo '</td>';
	echo '</tr>';
}

/**
 * Converts product arrays to editable text lines.
 *
 * @param array $data Product data.
 * @return array
 */
function echos_product_admin_flatten_product_data( $data ) {
	$spec_items = array();
	if ( isset( $data['specs']['items'] ) && is_array( $data['specs']['items'] ) ) {
		foreach ( $data['specs']['items'] as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}
			$spec_items[] = trim( (string) ( $item['title'] ?? '' ) ) . '|' . trim( (string) ( $item['text'] ?? '' ) );
		}
	}

	$ideal_lines = array();
	if ( isset( $data['ideal']['paragraphs'] ) && is_array( $data['ideal']['paragraphs'] ) ) {
		foreach ( $data['ideal']['paragraphs'] as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}
			$ideal_lines[] = trim( (string) ( $item['text'] ?? '' ) );
		}
	}

	$gallery_lines = array();
	if ( isset( $data['gallery']['items'] ) && is_array( $data['gallery']['items'] ) ) {
		foreach ( $data['gallery']['items'] as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}
			$gallery_lines[] = trim( (string) ( $item['image'] ?? '' ) ) . '|' . trim( (string) ( $item['alt'] ?? '' ) );
		}
	}

	return array(
		'hero_topbar_cta_url'       => (string) ( $data['hero']['topbar_cta_url'] ?? '' ),
		'hero_title'                => (string) ( $data['hero']['title'] ?? '' ),
		'hero_description'          => (string) ( $data['hero']['description'] ?? '' ),
		'hero_button_text'          => (string) ( $data['hero']['button_text'] ?? '' ),
		'hero_button_url'           => (string) ( $data['hero']['button_url'] ?? '' ),
		'hero_image'                => (string) ( $data['hero']['image'] ?? '' ),
		'hero_image_alt'            => (string) ( $data['hero']['image_alt'] ?? '' ),
		'specs_title'               => (string) ( $data['specs']['title'] ?? '' ),
		'specs_image'               => (string) ( $data['specs']['image'] ?? '' ),
		'specs_image_alt'           => (string) ( $data['specs']['image_alt'] ?? '' ),
		'specs_caption'             => (string) ( $data['specs']['caption'] ?? '' ),
		'specs_items_lines'         => implode( "\n", $spec_items ),
		'ficha_image'               => (string) ( $data['ficha']['image'] ?? '' ),
		'ficha_image_alt'           => (string) ( $data['ficha']['image_alt'] ?? '' ),
		'ficha_title'               => (string) ( $data['ficha']['title'] ?? '' ),
		'ficha_text'                => (string) ( $data['ficha']['text'] ?? '' ),
		'ficha_button_text'         => (string) ( $data['ficha']['button_text'] ?? '' ),
		'ficha_button_url'          => (string) ( $data['ficha']['button_url'] ?? '' ),
		'ideal_title'               => (string) ( $data['ideal']['title'] ?? '' ),
		'ideal_paragraphs_lines'    => implode( "\n", $ideal_lines ),
		'gallery_title'             => (string) ( $data['gallery']['title'] ?? '' ),
		'gallery_items_lines'       => implode( "\n", $gallery_lines ),
		'recommended_title'         => (string) ( $data['recommended']['title'] ?? '' ),
		'recommended_items_limit'   => (string) ( $data['recommended']['items_limit'] ?? '4' ),
		'recommended_match_category'=> (string) ( $data['recommended']['match_category'] ?? 'yes' ),
		'listing_summary'           => (string) ( $data['listing']['summary'] ?? '' ),
		'final_cta_title'           => (string) ( $data['final_cta']['title'] ?? '' ),
		'final_cta_text'            => (string) ( $data['final_cta']['text'] ?? '' ),
		'final_cta_primary_text'    => (string) ( $data['final_cta']['primary_text'] ?? '' ),
		'final_cta_primary_url'     => (string) ( $data['final_cta']['primary_url'] ?? '' ),
		'final_cta_secondary_text'  => (string) ( $data['final_cta']['secondary_text'] ?? '' ),
		'final_cta_secondary_url'   => (string) ( $data['final_cta']['secondary_url'] ?? '' ),
	);
}
/**
 * Renders product metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function echos_product_render_admin_metabox( $post ) {
	$data = echos_product_admin_flatten_product_data( echos_product_get_data( $post->ID ) );

	wp_nonce_field( 'echos_product_save_sections', 'echos_product_sections_nonce' );

	echo '<p class="description">' . esc_html__( 'Campos de lista: usa una linea por item. Para pares, usa formato "titulo|texto".', 'echos' ) . '</p>';
	echo '<table class="form-table" role="presentation"><tbody>';

	echos_product_admin_render_row( 'echos_product_data[hero_topbar_cta_url]', __( 'URL CTA topbar', 'echos' ), $data['hero_topbar_cta_url'], 'url' );
	echos_product_admin_render_row( 'echos_product_data[hero_title]', __( 'Hero titulo (opcional)', 'echos' ), $data['hero_title'] );
	echos_product_admin_render_row( 'echos_product_data[hero_description]', __( 'Hero descripcion', 'echos' ), $data['hero_description'], 'textarea' );
	echos_product_admin_render_row( 'echos_product_data[hero_button_text]', __( 'Hero boton texto', 'echos' ), $data['hero_button_text'] );
	echos_product_admin_render_row( 'echos_product_data[hero_button_url]', __( 'Hero boton URL', 'echos' ), $data['hero_button_url'], 'url' );
	echos_product_admin_render_row( 'echos_product_data[hero_image]', __( 'Hero imagen URL', 'echos' ), $data['hero_image'], 'url' );
	echos_product_admin_render_row( 'echos_product_data[hero_image_alt]', __( 'Hero imagen ALT', 'echos' ), $data['hero_image_alt'] );

	echos_product_admin_render_row( 'echos_product_data[specs_title]', __( 'Caracteristicas titulo', 'echos' ), $data['specs_title'] );
	echos_product_admin_render_row( 'echos_product_data[specs_image]', __( 'Caracteristicas imagen URL', 'echos' ), $data['specs_image'], 'url' );
	echos_product_admin_render_row( 'echos_product_data[specs_image_alt]', __( 'Caracteristicas imagen ALT', 'echos' ), $data['specs_image_alt'] );
	echos_product_admin_render_row( 'echos_product_data[specs_caption]', __( 'Caracteristicas texto', 'echos' ), $data['specs_caption'], 'textarea' );
	echos_product_admin_render_row( 'echos_product_data[specs_items_lines]', __( 'Caracteristicas items', 'echos' ), $data['specs_items_lines'], 'textarea', __( 'Una linea por item: Titulo|Descripcion', 'echos' ) );

	echos_product_admin_render_row( 'echos_product_data[ficha_image]', __( 'Ficha imagen URL', 'echos' ), $data['ficha_image'], 'url' );
	echos_product_admin_render_row( 'echos_product_data[ficha_image_alt]', __( 'Ficha imagen ALT', 'echos' ), $data['ficha_image_alt'] );
	echos_product_admin_render_row( 'echos_product_data[ficha_title]', __( 'Ficha titulo', 'echos' ), $data['ficha_title'] );
	echos_product_admin_render_row( 'echos_product_data[ficha_text]', __( 'Ficha texto', 'echos' ), $data['ficha_text'], 'textarea' );
	echos_product_admin_render_row( 'echos_product_data[ficha_button_text]', __( 'Ficha boton texto', 'echos' ), $data['ficha_button_text'] );
	echos_product_admin_render_row( 'echos_product_data[ficha_button_url]', __( 'Ficha boton URL', 'echos' ), $data['ficha_button_url'], 'url' );

	echos_product_admin_render_row( 'echos_product_data[ideal_title]', __( 'Ideal para titulo', 'echos' ), $data['ideal_title'] );
	echos_product_admin_render_row( 'echos_product_data[ideal_paragraphs_lines]', __( 'Ideal para parrafos', 'echos' ), $data['ideal_paragraphs_lines'], 'textarea', __( 'Una linea por parrafo.', 'echos' ) );

	echos_product_admin_render_row( 'echos_product_data[gallery_title]', __( 'Galeria titulo', 'echos' ), $data['gallery_title'] );
	echos_product_admin_render_row( 'echos_product_data[gallery_items_lines]', __( 'Galeria imagenes', 'echos' ), $data['gallery_items_lines'], 'textarea', __( 'Una linea por imagen: URL|ALT', 'echos' ) );

	echos_product_admin_render_row( 'echos_product_data[recommended_title]', __( 'Recomendados titulo', 'echos' ), $data['recommended_title'] );
	echos_product_admin_render_row( 'echos_product_data[recommended_items_limit]', __( 'Recomendados cantidad', 'echos' ), $data['recommended_items_limit'], 'number' );

	echo '<tr><th scope="row"><label for="echos_product_data_recommended_match_category">' . esc_html__( 'Recomendados misma categoria', 'echos' ) . '</label></th><td>';
	echo '<select id="echos_product_data_recommended_match_category" name="echos_product_data[recommended_match_category]">';
	echo '<option value="yes" ' . selected( $data['recommended_match_category'], 'yes', false ) . '>' . esc_html__( 'Si', 'echos' ) . '</option>';
	echo '<option value="no" ' . selected( $data['recommended_match_category'], 'no', false ) . '>' . esc_html__( 'No', 'echos' ) . '</option>';
	echo '</select>';
	echo '</td></tr>';

	echos_product_admin_render_row( 'echos_product_data[listing_summary]', __( 'Resumen en tarjeta de listado', 'echos' ), $data['listing_summary'], 'textarea', __( 'Si queda vacio, usa extracto o contenido.', 'echos' ) );

	echos_product_admin_render_row( 'echos_product_data[final_cta_title]', __( 'CTA final titulo', 'echos' ), $data['final_cta_title'] );
	echos_product_admin_render_row( 'echos_product_data[final_cta_text]', __( 'CTA final texto', 'echos' ), $data['final_cta_text'], 'textarea' );
	echos_product_admin_render_row( 'echos_product_data[final_cta_primary_text]', __( 'CTA boton principal texto', 'echos' ), $data['final_cta_primary_text'] );
	echos_product_admin_render_row( 'echos_product_data[final_cta_primary_url]', __( 'CTA boton principal URL', 'echos' ), $data['final_cta_primary_url'], 'url' );
	echos_product_admin_render_row( 'echos_product_data[final_cta_secondary_text]', __( 'CTA boton secundario texto', 'echos' ), $data['final_cta_secondary_text'] );
	echos_product_admin_render_row( 'echos_product_data[final_cta_secondary_url]', __( 'CTA boton secundario URL', 'echos' ), $data['final_cta_secondary_url'], 'url' );

	echo '</tbody></table>';
}

/**
 * Renders listing-page metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function echos_product_render_listing_admin_metabox( $post ) {
	$data = echos_product_get_listing_data( $post->ID );

	wp_nonce_field( 'echos_product_listing_save_sections', 'echos_product_listing_sections_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';
	echos_product_admin_render_row( 'echos_product_listing_data[topbar_cta_url]', __( 'URL CTA topbar', 'echos' ), (string) ( $data['topbar_cta_url'] ?? '' ), 'url' );
	echos_product_admin_render_row( 'echos_product_listing_data[hero_title]', __( 'Hero titulo', 'echos' ), (string) ( $data['hero']['title'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[hero_description]', __( 'Hero descripcion', 'echos' ), (string) ( $data['hero']['description'] ?? '' ), 'textarea' );

	echos_product_admin_render_row( 'echos_product_listing_data[filters_search_placeholder]', __( 'Filtro buscador placeholder', 'echos' ), (string) ( $data['filters']['search_placeholder'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[filters_all_categories_label]', __( 'Filtro label todas categorias', 'echos' ), (string) ( $data['filters']['all_categories_label'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[filters_submit_label]', __( 'Filtro boton filtrar', 'echos' ), (string) ( $data['filters']['submit_label'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[filters_reset_label]', __( 'Filtro boton limpiar', 'echos' ), (string) ( $data['filters']['reset_label'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[filters_order_recent_label]', __( 'Orden label recientes', 'echos' ), (string) ( $data['filters']['order_recent_label'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[filters_order_old_label]', __( 'Orden label antiguos', 'echos' ), (string) ( $data['filters']['order_old_label'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[filters_order_name_asc_label]', __( 'Orden label nombre A-Z', 'echos' ), (string) ( $data['filters']['order_name_asc_label'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[filters_order_name_desc_label]', __( 'Orden label nombre Z-A', 'echos' ), (string) ( $data['filters']['order_name_desc_label'] ?? '' ) );

	echos_product_admin_render_row( 'echos_product_listing_data[listing_per_page]', __( 'Productos por pagina', 'echos' ), (string) ( $data['listing']['per_page'] ?? '12' ), 'number' );
	echos_product_admin_render_row( 'echos_product_listing_data[listing_empty_title]', __( 'Sin resultados titulo', 'echos' ), (string) ( $data['listing']['empty_title'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[listing_empty_text]', __( 'Sin resultados texto', 'echos' ), (string) ( $data['listing']['empty_text'] ?? '' ), 'textarea' );

	echos_product_admin_render_row( 'echos_product_listing_data[final_cta_title]', __( 'CTA final titulo', 'echos' ), (string) ( $data['final_cta']['title'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[final_cta_text]', __( 'CTA final texto', 'echos' ), (string) ( $data['final_cta']['text'] ?? '' ), 'textarea' );
	echos_product_admin_render_row( 'echos_product_listing_data[final_cta_primary_text]', __( 'CTA boton principal texto', 'echos' ), (string) ( $data['final_cta']['primary_text'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[final_cta_primary_url]', __( 'CTA boton principal URL', 'echos' ), (string) ( $data['final_cta']['primary_url'] ?? '' ), 'url' );
	echos_product_admin_render_row( 'echos_product_listing_data[final_cta_secondary_text]', __( 'CTA boton secundario texto', 'echos' ), (string) ( $data['final_cta']['secondary_text'] ?? '' ) );
	echos_product_admin_render_row( 'echos_product_listing_data[final_cta_secondary_url]', __( 'CTA boton secundario URL', 'echos' ), (string) ( $data['final_cta']['secondary_url'] ?? '' ), 'url' );
	echo '</tbody></table>';
}
/**
 * Parses lines with "left|right" format.
 *
 * @param string $text      Raw text.
 * @param string $left_key  Left key.
 * @param string $right_key Right key.
 * @return array
 */
function echos_product_admin_parse_pair_lines( $text, $left_key, $right_key ) {
	$rows  = preg_split( '/\r\n|\r|\n/', (string) $text );
	$items = array();

	if ( ! is_array( $rows ) ) {
		return $items;
	}

	foreach ( $rows as $row ) {
		$line = trim( (string) $row );
		if ( '' === $line ) {
			continue;
		}

		$parts = explode( '|', $line, 2 );
		$left  = sanitize_text_field( trim( (string) $parts[0] ) );
		$right = isset( $parts[1] ) ? sanitize_textarea_field( trim( (string) $parts[1] ) ) : '';

		if ( '' === $left && '' === $right ) {
			continue;
		}

		$items[] = array(
			$left_key  => $left,
			$right_key => $right,
		);
	}

	return $items;
}

/**
 * Parses non-empty lines as paragraph items.
 *
 * @param string $text Raw text.
 * @return array
 */
function echos_product_admin_parse_text_lines( $text ) {
	$rows  = preg_split( '/\r\n|\r|\n/', (string) $text );
	$items = array();

	if ( ! is_array( $rows ) ) {
		return $items;
	}

	foreach ( $rows as $row ) {
		$line = sanitize_textarea_field( trim( (string) $row ) );
		if ( '' === $line ) {
			continue;
		}
		$items[] = array( 'text' => $line );
	}

	return $items;
}

/**
 * Removes empty values recursively.
 *
 * @param mixed $value Value.
 * @return mixed
 */
function echos_product_admin_cleanup_recursive( $value ) {
	if ( ! is_array( $value ) ) {
		if ( is_string( $value ) ) {
			$value = trim( $value );
		}

		return '' === $value ? '' : $value;
	}

	$clean = array();

	foreach ( $value as $key => $item ) {
		$normalized = echos_product_admin_cleanup_recursive( $item );

		if ( is_array( $normalized ) ) {
			if ( ! empty( $normalized ) ) {
				$clean[ $key ] = $normalized;
			}
			continue;
		}

		if ( '' !== $normalized ) {
			$clean[ $key ] = $normalized;
		}
	}

	return $clean;
}

/**
 * Saves product metabox values.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @return void
 */
function echos_product_save_admin_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['echos_product_sections_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_product_sections_nonce'] ) ), 'echos_product_save_sections' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) || ! $post instanceof WP_Post || 'producto' !== $post->post_type ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$raw = isset( $_POST['echos_product_data'] ) && is_array( $_POST['echos_product_data'] )
		? wp_unslash( $_POST['echos_product_data'] )
		: array();

	$data = array(
		'hero'        => array(
			'topbar_cta_url' => esc_url_raw( trim( (string) ( $raw['hero_topbar_cta_url'] ?? '' ) ) ),
			'title'          => sanitize_text_field( $raw['hero_title'] ?? '' ),
			'description'    => sanitize_textarea_field( $raw['hero_description'] ?? '' ),
			'button_text'    => sanitize_text_field( $raw['hero_button_text'] ?? '' ),
			'button_url'     => esc_url_raw( trim( (string) ( $raw['hero_button_url'] ?? '' ) ) ),
			'image'          => esc_url_raw( trim( (string) ( $raw['hero_image'] ?? '' ) ) ),
			'image_alt'      => sanitize_text_field( $raw['hero_image_alt'] ?? '' ),
		),
		'specs'       => array(
			'title'     => sanitize_text_field( $raw['specs_title'] ?? '' ),
			'image'     => esc_url_raw( trim( (string) ( $raw['specs_image'] ?? '' ) ) ),
			'image_alt' => sanitize_text_field( $raw['specs_image_alt'] ?? '' ),
			'caption'   => sanitize_textarea_field( $raw['specs_caption'] ?? '' ),
			'items'     => echos_product_admin_parse_pair_lines( (string) ( $raw['specs_items_lines'] ?? '' ), 'title', 'text' ),
		),
		'ficha'       => array(
			'image'       => esc_url_raw( trim( (string) ( $raw['ficha_image'] ?? '' ) ) ),
			'image_alt'   => sanitize_text_field( $raw['ficha_image_alt'] ?? '' ),
			'title'       => sanitize_text_field( $raw['ficha_title'] ?? '' ),
			'text'        => sanitize_textarea_field( $raw['ficha_text'] ?? '' ),
			'button_text' => sanitize_text_field( $raw['ficha_button_text'] ?? '' ),
			'button_url'  => esc_url_raw( trim( (string) ( $raw['ficha_button_url'] ?? '' ) ) ),
		),
		'ideal'       => array(
			'title'      => sanitize_text_field( $raw['ideal_title'] ?? '' ),
			'paragraphs' => echos_product_admin_parse_text_lines( (string) ( $raw['ideal_paragraphs_lines'] ?? '' ) ),
		),
		'gallery'     => array(
			'title' => sanitize_text_field( $raw['gallery_title'] ?? '' ),
			'items' => echos_product_admin_parse_pair_lines( (string) ( $raw['gallery_items_lines'] ?? '' ), 'image', 'alt' ),
		),
		'recommended' => array(
			'title'          => sanitize_text_field( $raw['recommended_title'] ?? '' ),
			'items_limit'    => max( 1, absint( $raw['recommended_items_limit'] ?? 4 ) ),
			'match_category' => 'no' === sanitize_key( $raw['recommended_match_category'] ?? 'yes' ) ? 'no' : 'yes',
		),
		'listing'     => array(
			'summary' => sanitize_textarea_field( $raw['listing_summary'] ?? '' ),
		),
		'final_cta'   => array(
			'title'          => sanitize_text_field( $raw['final_cta_title'] ?? '' ),
			'text'           => sanitize_textarea_field( $raw['final_cta_text'] ?? '' ),
			'primary_text'   => sanitize_text_field( $raw['final_cta_primary_text'] ?? '' ),
			'primary_url'    => esc_url_raw( trim( (string) ( $raw['final_cta_primary_url'] ?? '' ) ) ),
			'secondary_text' => sanitize_text_field( $raw['final_cta_secondary_text'] ?? '' ),
			'secondary_url'  => esc_url_raw( trim( (string) ( $raw['final_cta_secondary_url'] ?? '' ) ) ),
		),
	);

	$clean = echos_product_admin_cleanup_recursive( $data );

	if ( empty( $clean ) ) {
		delete_post_meta( $post_id, '_echos_product_sections' );
		return;
	}

	update_post_meta( $post_id, '_echos_product_sections', $clean );
}
/**
 * Saves listing-page metabox values.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @return void
 */
function echos_product_save_listing_admin_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['echos_product_listing_sections_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_product_listing_sections_nonce'] ) ), 'echos_product_listing_save_sections' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) || ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) || ! echos_product_admin_is_listing_page( $post_id ) ) {
		return;
	}

	$raw = isset( $_POST['echos_product_listing_data'] ) && is_array( $_POST['echos_product_listing_data'] )
		? wp_unslash( $_POST['echos_product_listing_data'] )
		: array();

	$data = array(
		'topbar_cta_url' => esc_url_raw( trim( (string) ( $raw['topbar_cta_url'] ?? '' ) ) ),
		'hero'           => array(
			'title'       => sanitize_text_field( $raw['hero_title'] ?? '' ),
			'description' => sanitize_textarea_field( $raw['hero_description'] ?? '' ),
		),
		'filters'        => array(
			'search_placeholder'    => sanitize_text_field( $raw['filters_search_placeholder'] ?? '' ),
			'all_categories_label'  => sanitize_text_field( $raw['filters_all_categories_label'] ?? '' ),
			'submit_label'          => sanitize_text_field( $raw['filters_submit_label'] ?? '' ),
			'reset_label'           => sanitize_text_field( $raw['filters_reset_label'] ?? '' ),
			'order_recent_label'    => sanitize_text_field( $raw['filters_order_recent_label'] ?? '' ),
			'order_old_label'       => sanitize_text_field( $raw['filters_order_old_label'] ?? '' ),
			'order_name_asc_label'  => sanitize_text_field( $raw['filters_order_name_asc_label'] ?? '' ),
			'order_name_desc_label' => sanitize_text_field( $raw['filters_order_name_desc_label'] ?? '' ),
		),
		'listing'        => array(
			'per_page'    => max( 1, absint( $raw['listing_per_page'] ?? 12 ) ),
			'empty_title' => sanitize_text_field( $raw['listing_empty_title'] ?? '' ),
			'empty_text'  => sanitize_textarea_field( $raw['listing_empty_text'] ?? '' ),
		),
		'final_cta'      => array(
			'title'          => sanitize_text_field( $raw['final_cta_title'] ?? '' ),
			'text'           => sanitize_textarea_field( $raw['final_cta_text'] ?? '' ),
			'primary_text'   => sanitize_text_field( $raw['final_cta_primary_text'] ?? '' ),
			'primary_url'    => esc_url_raw( trim( (string) ( $raw['final_cta_primary_url'] ?? '' ) ) ),
			'secondary_text' => sanitize_text_field( $raw['final_cta_secondary_text'] ?? '' ),
			'secondary_url'  => esc_url_raw( trim( (string) ( $raw['final_cta_secondary_url'] ?? '' ) ) ),
		),
	);

	$clean = echos_product_admin_cleanup_recursive( $data );

	if ( empty( $clean ) ) {
		delete_post_meta( $post_id, '_echos_product_listing_sections' );
		return;
	}

	update_post_meta( $post_id, '_echos_product_listing_sections', $clean );
}
