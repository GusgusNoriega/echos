<?php
/**
 * Project templates admin metaboxes.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'add_meta_boxes', 'echos_project_register_admin_metaboxes', 10, 2 );
add_action( 'save_post_proyecto', 'echos_project_save_admin_metabox', 10, 2 );
add_action( 'save_post_page', 'echos_project_save_listing_admin_metabox', 10, 2 );

/**
 * Checks if page uses the projects listing template.
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function echos_project_admin_is_listing_page( $post_id ) {
	return 'page-templates/template-proyectos.php' === get_page_template_slug( $post_id );
}

/**
 * Registers project metaboxes.
 *
 * @param string  $post_type Post type.
 * @param WP_Post $post      Post object.
 * @return void
 */
function echos_project_register_admin_metaboxes( $post_type, $post ) {
	if ( ! $post instanceof WP_Post ) {
		return;
	}

	if ( 'proyecto' === $post_type ) {
		add_meta_box(
			'echos_project_sections_metabox',
			__( 'Proyecto: Contenido Administrable', 'echos' ),
			'echos_project_render_admin_metabox',
			'proyecto',
			'normal',
			'high'
		);

		return;
	}

	if ( 'page' === $post_type && echos_project_admin_is_listing_page( $post->ID ) ) {
		add_meta_box(
			'echos_project_listing_sections_metabox',
			__( 'Proyectos: Contenido de Listado', 'echos' ),
			'echos_project_render_listing_admin_metabox',
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
function echos_project_admin_render_row( $name, $label, $value, $type = 'text', $help = '' ) {
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
 * Converts project arrays to editable text lines.
 *
 * @param array $data Project data.
 * @return array
 */
function echos_project_admin_flatten_project_data( $data ) {
	$used_products_items = array();
	if ( isset( $data['used_products']['items'] ) && is_array( $data['used_products']['items'] ) ) {
		foreach ( $data['used_products']['items'] as $item ) {
			if ( ! is_array( $item ) ) {
				continue;
			}

			$features = array();
			if ( isset( $item['features'] ) && is_array( $item['features'] ) ) {
				foreach ( $item['features'] as $feature ) {
					if ( is_string( $feature ) && '' !== trim( $feature ) ) {
						$features[] = trim( $feature );
					}
				}
			}

			$used_products_items[] = trim( (string) ( $item['name'] ?? '' ) ) . '|' . implode( '; ', $features );
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
		'hero_image'                => (string) ( $data['hero']['image'] ?? '' ),
		'hero_image_alt'            => (string) ( $data['hero']['image_alt'] ?? '' ),
		'detail_tag'                => (string) ( $data['detail']['tag'] ?? '' ),
		'detail_date_label'         => (string) ( $data['detail']['date_label'] ?? '' ),
		'detail_title'              => (string) ( $data['detail']['title'] ?? '' ),
		'detail_intro'              => (string) ( $data['detail']['intro'] ?? '' ),
		'detail_highlight'          => (string) ( $data['detail']['highlight'] ?? '' ),
		'detail_body'               => (string) ( $data['detail']['body'] ?? '' ),
		'detail_cta_text'           => (string) ( $data['detail']['cta_text'] ?? '' ),
		'detail_cta_url'            => (string) ( $data['detail']['cta_url'] ?? '' ),
		'video_id'                  => (string) ( $data['video']['video_id'] ?? '' ),
		'video_thumbnail'           => (string) ( $data['video']['thumbnail'] ?? '' ),
		'video_thumbnail_alt'       => (string) ( $data['video']['thumbnail_alt'] ?? '' ),
		'used_products_title'       => (string) ( $data['used_products']['title'] ?? '' ),
		'used_products_items_lines' => implode( "\n", $used_products_items ),
		'gallery_items_lines'       => implode( "\n", $gallery_lines ),
		'related_title'             => (string) ( $data['related']['title'] ?? '' ),
		'related_items_limit'       => (string) ( $data['related']['items_limit'] ?? '4' ),
		'related_match_category'    => (string) ( $data['related']['match_category'] ?? 'yes' ),
		'listing_summary'           => (string) ( $data['listing']['summary'] ?? '' ),
		'listing_badge'             => (string) ( $data['listing']['badge'] ?? '' ),
		'listing_is_featured'       => (string) ( $data['listing']['is_featured'] ?? 'no' ),
		'final_cta_title'           => (string) ( $data['final_cta']['title'] ?? '' ),
		'final_cta_text'            => (string) ( $data['final_cta']['text'] ?? '' ),
		'final_cta_primary_text'    => (string) ( $data['final_cta']['primary_text'] ?? '' ),
		'final_cta_primary_url'     => (string) ( $data['final_cta']['primary_url'] ?? '' ),
		'final_cta_secondary_text'  => (string) ( $data['final_cta']['secondary_text'] ?? '' ),
		'final_cta_secondary_url'   => (string) ( $data['final_cta']['secondary_url'] ?? '' ),
	);
}

/**
 * Renders project metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function echos_project_render_admin_metabox( $post ) {
	$data = echos_project_admin_flatten_project_data( echos_project_get_data( $post->ID ) );

	wp_nonce_field( 'echos_project_save_sections', 'echos_project_sections_nonce' );

	echo '<p class="description">' . esc_html__( 'Campos de lista: usa una linea por item. Para pares, usa formato "titulo|texto".', 'echos' ) . '</p>';
	echo '<table class="form-table" role="presentation"><tbody>';

	echos_project_admin_render_row( 'echos_project_data[hero_topbar_cta_url]', __( 'URL CTA topbar', 'echos' ), $data['hero_topbar_cta_url'], 'url' );
	echos_project_admin_render_row( 'echos_project_data[hero_title]', __( 'Hero titulo (opcional)', 'echos' ), $data['hero_title'] );
	echos_project_admin_render_row( 'echos_project_data[hero_description]', __( 'Hero descripcion', 'echos' ), $data['hero_description'], 'textarea' );
	echos_project_admin_render_row( 'echos_project_data[hero_image]', __( 'Hero imagen URL', 'echos' ), $data['hero_image'], 'url' );
	echos_project_admin_render_row( 'echos_project_data[hero_image_alt]', __( 'Hero imagen ALT', 'echos' ), $data['hero_image_alt'] );

	echos_project_admin_render_row( 'echos_project_data[detail_tag]', __( 'Detalle etiqueta', 'echos' ), $data['detail_tag'], 'text', __( 'Si queda vacio, usa la primera categoria del proyecto.', 'echos' ) );
	echos_project_admin_render_row( 'echos_project_data[detail_date_label]', __( 'Detalle fecha visible', 'echos' ), $data['detail_date_label'], 'text', __( 'Si queda vacio, usa la fecha de publicacion.', 'echos' ) );
	echos_project_admin_render_row( 'echos_project_data[detail_title]', __( 'Detalle titulo', 'echos' ), $data['detail_title'] );
	echos_project_admin_render_row( 'echos_project_data[detail_intro]', __( 'Detalle parrafo introductorio', 'echos' ), $data['detail_intro'], 'textarea' );
	echos_project_admin_render_row( 'echos_project_data[detail_highlight]', __( 'Detalle texto destacado', 'echos' ), $data['detail_highlight'], 'textarea' );
	echos_project_admin_render_row( 'echos_project_data[detail_body]', __( 'Detalle parrafo final', 'echos' ), $data['detail_body'], 'textarea' );
	echos_project_admin_render_row( 'echos_project_data[detail_cta_text]', __( 'Detalle CTA texto', 'echos' ), $data['detail_cta_text'] );
	echos_project_admin_render_row( 'echos_project_data[detail_cta_url]', __( 'Detalle CTA URL', 'echos' ), $data['detail_cta_url'], 'url' );

	echos_project_admin_render_row( 'echos_project_data[video_id]', __( 'Video YouTube ID', 'echos' ), $data['video_id'], 'text', __( 'Ejemplo: dQw4w9WgXcQ', 'echos' ) );
	echos_project_admin_render_row( 'echos_project_data[video_thumbnail]', __( 'Video thumbnail URL', 'echos' ), $data['video_thumbnail'], 'url' );
	echos_project_admin_render_row( 'echos_project_data[video_thumbnail_alt]', __( 'Video thumbnail ALT', 'echos' ), $data['video_thumbnail_alt'] );

	echos_project_admin_render_row( 'echos_project_data[used_products_title]', __( 'Productos utilizados titulo', 'echos' ), $data['used_products_title'] );
	echos_project_admin_render_row( 'echos_project_data[used_products_items_lines]', __( 'Productos utilizados items', 'echos' ), $data['used_products_items_lines'], 'textarea', __( 'Una linea por tarjeta: Nombre|Caracteristica 1; Caracteristica 2; Caracteristica 3', 'echos' ) );

	echos_project_admin_render_row( 'echos_project_data[gallery_items_lines]', __( 'Galeria imagenes', 'echos' ), $data['gallery_items_lines'], 'textarea', __( 'Una linea por imagen: URL|ALT', 'echos' ) );

	echos_project_admin_render_row( 'echos_project_data[related_title]', __( 'Relacionados titulo', 'echos' ), $data['related_title'] );
	echos_project_admin_render_row( 'echos_project_data[related_items_limit]', __( 'Relacionados cantidad', 'echos' ), $data['related_items_limit'], 'number' );

	echo '<tr><th scope="row"><label for="echos_project_data_related_match_category">' . esc_html__( 'Relacionados misma categoria', 'echos' ) . '</label></th><td>';
	echo '<select id="echos_project_data_related_match_category" name="echos_project_data[related_match_category]">';
	echo '<option value="yes" ' . selected( $data['related_match_category'], 'yes', false ) . '>' . esc_html__( 'Si', 'echos' ) . '</option>';
	echo '<option value="no" ' . selected( $data['related_match_category'], 'no', false ) . '>' . esc_html__( 'No', 'echos' ) . '</option>';
	echo '</select>';
	echo '</td></tr>';

	echos_project_admin_render_row( 'echos_project_data[listing_summary]', __( 'Resumen en tarjeta de listado', 'echos' ), $data['listing_summary'], 'textarea', __( 'Si queda vacio, usa extracto o contenido.', 'echos' ) );
	echos_project_admin_render_row( 'echos_project_data[listing_badge]', __( 'Badge en tarjeta de listado', 'echos' ), $data['listing_badge'], 'text', __( 'Si queda vacio, usa la primera categoria del proyecto.', 'echos' ) );

	echo '<tr><th scope="row"><label for="echos_project_data_listing_is_featured">' . esc_html__( 'Marcar como destacado', 'echos' ) . '</label></th><td>';
	echo '<select id="echos_project_data_listing_is_featured" name="echos_project_data[listing_is_featured]">';
	echo '<option value="no" ' . selected( $data['listing_is_featured'], 'no', false ) . '>' . esc_html__( 'No', 'echos' ) . '</option>';
	echo '<option value="yes" ' . selected( $data['listing_is_featured'], 'yes', false ) . '>' . esc_html__( 'Si', 'echos' ) . '</option>';
	echo '</select>';
	echo '</td></tr>';

	echos_project_admin_render_row( 'echos_project_data[final_cta_title]', __( 'CTA final titulo', 'echos' ), $data['final_cta_title'] );
	echos_project_admin_render_row( 'echos_project_data[final_cta_text]', __( 'CTA final texto', 'echos' ), $data['final_cta_text'], 'textarea' );
	echos_project_admin_render_row( 'echos_project_data[final_cta_primary_text]', __( 'CTA boton principal texto', 'echos' ), $data['final_cta_primary_text'] );
	echos_project_admin_render_row( 'echos_project_data[final_cta_primary_url]', __( 'CTA boton principal URL', 'echos' ), $data['final_cta_primary_url'], 'url' );
	echos_project_admin_render_row( 'echos_project_data[final_cta_secondary_text]', __( 'CTA boton secundario texto', 'echos' ), $data['final_cta_secondary_text'] );
	echos_project_admin_render_row( 'echos_project_data[final_cta_secondary_url]', __( 'CTA boton secundario URL', 'echos' ), $data['final_cta_secondary_url'], 'url' );

	echo '</tbody></table>';
}

/**
 * Renders listing-page metabox.
 *
 * @param WP_Post $post Current post.
 * @return void
 */
function echos_project_render_listing_admin_metabox( $post ) {
	$data = echos_project_get_listing_data( $post->ID );

	wp_nonce_field( 'echos_project_listing_save_sections', 'echos_project_listing_sections_nonce' );

	echo '<table class="form-table" role="presentation"><tbody>';
	echos_project_admin_render_row( 'echos_project_listing_data[topbar_cta_url]', __( 'URL CTA topbar', 'echos' ), (string) ( $data['topbar_cta_url'] ?? '' ), 'url' );
	echos_project_admin_render_row( 'echos_project_listing_data[hero_title]', __( 'Hero titulo', 'echos' ), (string) ( $data['hero']['title'] ?? '' ) );
	echos_project_admin_render_row( 'echos_project_listing_data[hero_description]', __( 'Hero descripcion', 'echos' ), (string) ( $data['hero']['description'] ?? '' ), 'textarea' );
	echos_project_admin_render_row( 'echos_project_listing_data[hero_background_image]', __( 'Hero fondo URL', 'echos' ), (string) ( $data['hero']['background_image'] ?? '' ), 'url' );

	echos_project_admin_render_row( 'echos_project_listing_data[featured_title]', __( 'Destacados titulo', 'echos' ), (string) ( $data['featured']['title'] ?? '' ) );
	echos_project_admin_render_row( 'echos_project_listing_data[featured_items_limit]', __( 'Destacados cantidad', 'echos' ), (string) ( $data['featured']['items_limit'] ?? '6' ), 'number' );

	echos_project_admin_render_row( 'echos_project_listing_data[listing_title]', __( 'Listado titulo', 'echos' ), (string) ( $data['listing']['title'] ?? '' ) );
	echos_project_admin_render_row( 'echos_project_listing_data[listing_all_filter_label]', __( 'Filtro label "Todos"', 'echos' ), (string) ( $data['listing']['all_filter_label'] ?? '' ) );
	echos_project_admin_render_row( 'echos_project_listing_data[listing_per_page]', __( 'Proyectos por pagina', 'echos' ), (string) ( $data['listing']['per_page'] ?? '9' ), 'number' );
	echos_project_admin_render_row( 'echos_project_listing_data[listing_empty_title]', __( 'Sin resultados titulo', 'echos' ), (string) ( $data['listing']['empty_title'] ?? '' ) );
	echos_project_admin_render_row( 'echos_project_listing_data[listing_empty_text]', __( 'Sin resultados texto', 'echos' ), (string) ( $data['listing']['empty_text'] ?? '' ), 'textarea' );

	echos_project_admin_render_row( 'echos_project_listing_data[final_cta_title]', __( 'CTA final titulo', 'echos' ), (string) ( $data['final_cta']['title'] ?? '' ) );
	echos_project_admin_render_row( 'echos_project_listing_data[final_cta_text]', __( 'CTA final texto', 'echos' ), (string) ( $data['final_cta']['text'] ?? '' ), 'textarea' );
	echos_project_admin_render_row( 'echos_project_listing_data[final_cta_primary_text]', __( 'CTA boton principal texto', 'echos' ), (string) ( $data['final_cta']['primary_text'] ?? '' ) );
	echos_project_admin_render_row( 'echos_project_listing_data[final_cta_primary_url]', __( 'CTA boton principal URL', 'echos' ), (string) ( $data['final_cta']['primary_url'] ?? '' ), 'url' );
	echos_project_admin_render_row( 'echos_project_listing_data[final_cta_secondary_text]', __( 'CTA boton secundario texto', 'echos' ), (string) ( $data['final_cta']['secondary_text'] ?? '' ) );
	echos_project_admin_render_row( 'echos_project_listing_data[final_cta_secondary_url]', __( 'CTA boton secundario URL', 'echos' ), (string) ( $data['final_cta']['secondary_url'] ?? '' ), 'url' );
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
function echos_project_admin_parse_pair_lines( $text, $left_key, $right_key ) {
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
		$right = isset( $parts[1] ) ? sanitize_text_field( trim( (string) $parts[1] ) ) : '';

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
 * Parses products lines with format "name|feature1;feature2".
 *
 * @param string $text Raw text.
 * @return array
 */
function echos_project_admin_parse_used_products_lines( $text ) {
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

		$parts        = explode( '|', $line, 2 );
		$name         = sanitize_text_field( trim( (string) $parts[0] ) );
		$features_raw = isset( $parts[1] ) ? (string) $parts[1] : '';
		$features     = array();

		if ( '' !== trim( $features_raw ) ) {
			$feature_rows = preg_split( '/\s*;\s*/', $features_raw );
			if ( is_array( $feature_rows ) ) {
				foreach ( $feature_rows as $feature_row ) {
					$feature_text = sanitize_text_field( trim( (string) $feature_row ) );
					if ( '' !== $feature_text ) {
						$features[] = $feature_text;
					}
				}
			}
		}

		if ( '' === $name && empty( $features ) ) {
			continue;
		}

		$items[] = array(
			'name'     => $name,
			'features' => $features,
		);
	}

	return $items;
}

/**
 * Removes empty values recursively.
 *
 * @param mixed $value Value.
 * @return mixed
 */
function echos_project_admin_cleanup_recursive( $value ) {
	if ( ! is_array( $value ) ) {
		if ( is_string( $value ) ) {
			$value = trim( $value );
		}

		return '' === $value ? '' : $value;
	}

	$clean = array();

	foreach ( $value as $key => $item ) {
		$normalized = echos_project_admin_cleanup_recursive( $item );

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
 * Saves project metabox values.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @return void
 */
function echos_project_save_admin_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['echos_project_sections_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_project_sections_nonce'] ) ), 'echos_project_save_sections' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) || ! $post instanceof WP_Post || 'proyecto' !== $post->post_type ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	$raw = isset( $_POST['echos_project_data'] ) && is_array( $_POST['echos_project_data'] )
		? wp_unslash( $_POST['echos_project_data'] )
		: array();

	$is_featured = 'yes' === sanitize_key( $raw['listing_is_featured'] ?? 'no' ) ? 'yes' : 'no';

	$data = array(
		'hero'          => array(
			'topbar_cta_url' => esc_url_raw( trim( (string) ( $raw['hero_topbar_cta_url'] ?? '' ) ) ),
			'title'          => sanitize_text_field( $raw['hero_title'] ?? '' ),
			'description'    => sanitize_textarea_field( $raw['hero_description'] ?? '' ),
			'image'          => esc_url_raw( trim( (string) ( $raw['hero_image'] ?? '' ) ) ),
			'image_alt'      => sanitize_text_field( $raw['hero_image_alt'] ?? '' ),
		),
		'detail'        => array(
			'tag'        => sanitize_text_field( $raw['detail_tag'] ?? '' ),
			'date_label' => sanitize_text_field( $raw['detail_date_label'] ?? '' ),
			'title'      => sanitize_text_field( $raw['detail_title'] ?? '' ),
			'intro'      => sanitize_textarea_field( $raw['detail_intro'] ?? '' ),
			'highlight'  => sanitize_textarea_field( $raw['detail_highlight'] ?? '' ),
			'body'       => sanitize_textarea_field( $raw['detail_body'] ?? '' ),
			'cta_text'   => sanitize_text_field( $raw['detail_cta_text'] ?? '' ),
			'cta_url'    => esc_url_raw( trim( (string) ( $raw['detail_cta_url'] ?? '' ) ) ),
		),
		'video'         => array(
			'video_id'      => sanitize_text_field( $raw['video_id'] ?? '' ),
			'thumbnail'     => esc_url_raw( trim( (string) ( $raw['video_thumbnail'] ?? '' ) ) ),
			'thumbnail_alt' => sanitize_text_field( $raw['video_thumbnail_alt'] ?? '' ),
		),
		'used_products' => array(
			'title' => sanitize_text_field( $raw['used_products_title'] ?? '' ),
			'items' => echos_project_admin_parse_used_products_lines( (string) ( $raw['used_products_items_lines'] ?? '' ) ),
		),
		'gallery'       => array(
			'items' => echos_project_admin_parse_pair_lines( (string) ( $raw['gallery_items_lines'] ?? '' ), 'image', 'alt' ),
		),
		'related'       => array(
			'title'          => sanitize_text_field( $raw['related_title'] ?? '' ),
			'items_limit'    => max( 1, absint( $raw['related_items_limit'] ?? 4 ) ),
			'match_category' => 'no' === sanitize_key( $raw['related_match_category'] ?? 'yes' ) ? 'no' : 'yes',
		),
		'listing'       => array(
			'summary'     => sanitize_textarea_field( $raw['listing_summary'] ?? '' ),
			'badge'       => sanitize_text_field( $raw['listing_badge'] ?? '' ),
			'is_featured' => $is_featured,
		),
		'final_cta'     => array(
			'title'          => sanitize_text_field( $raw['final_cta_title'] ?? '' ),
			'text'           => sanitize_textarea_field( $raw['final_cta_text'] ?? '' ),
			'primary_text'   => sanitize_text_field( $raw['final_cta_primary_text'] ?? '' ),
			'primary_url'    => esc_url_raw( trim( (string) ( $raw['final_cta_primary_url'] ?? '' ) ) ),
			'secondary_text' => sanitize_text_field( $raw['final_cta_secondary_text'] ?? '' ),
			'secondary_url'  => esc_url_raw( trim( (string) ( $raw['final_cta_secondary_url'] ?? '' ) ) ),
		),
	);

	$clean = echos_project_admin_cleanup_recursive( $data );

	if ( empty( $clean ) ) {
		delete_post_meta( $post_id, '_echos_project_sections' );
	} else {
		update_post_meta( $post_id, '_echos_project_sections', $clean );
	}

	update_post_meta( $post_id, '_echos_project_is_featured', $is_featured );
}

/**
 * Saves listing-page metabox values.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post object.
 * @return void
 */
function echos_project_save_listing_admin_metabox( $post_id, $post ) {
	if ( ! isset( $_POST['echos_project_listing_sections_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['echos_project_listing_sections_nonce'] ) ), 'echos_project_listing_save_sections' ) ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( wp_is_post_revision( $post_id ) || ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
		return;
	}

	if ( ! current_user_can( 'edit_page', $post_id ) || ! echos_project_admin_is_listing_page( $post_id ) ) {
		return;
	}

	$raw = isset( $_POST['echos_project_listing_data'] ) && is_array( $_POST['echos_project_listing_data'] )
		? wp_unslash( $_POST['echos_project_listing_data'] )
		: array();

	$data = array(
		'topbar_cta_url' => esc_url_raw( trim( (string) ( $raw['topbar_cta_url'] ?? '' ) ) ),
		'hero'           => array(
			'title'            => sanitize_text_field( $raw['hero_title'] ?? '' ),
			'description'      => sanitize_textarea_field( $raw['hero_description'] ?? '' ),
			'background_image' => esc_url_raw( trim( (string) ( $raw['hero_background_image'] ?? '' ) ) ),
		),
		'featured'       => array(
			'title'       => sanitize_text_field( $raw['featured_title'] ?? '' ),
			'items_limit' => max( 1, absint( $raw['featured_items_limit'] ?? 6 ) ),
		),
		'listing'        => array(
			'title'            => sanitize_text_field( $raw['listing_title'] ?? '' ),
			'all_filter_label' => sanitize_text_field( $raw['listing_all_filter_label'] ?? '' ),
			'per_page'         => max( 1, absint( $raw['listing_per_page'] ?? 9 ) ),
			'empty_title'      => sanitize_text_field( $raw['listing_empty_title'] ?? '' ),
			'empty_text'       => sanitize_textarea_field( $raw['listing_empty_text'] ?? '' ),
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

	$clean = echos_project_admin_cleanup_recursive( $data );

	if ( empty( $clean ) ) {
		delete_post_meta( $post_id, '_echos_project_listing_sections' );
		return;
	}

	update_post_meta( $post_id, '_echos_project_listing_sections', $clean );
}
