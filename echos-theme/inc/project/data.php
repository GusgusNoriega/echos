<?php
/**
 * Project template data helpers.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gets merged project data (defaults + saved values).
 *
 * @param int $project_id Project ID.
 * @return array
 */
function echos_project_get_data( $project_id = 0 ) {
	$defaults = echos_project_default_single_sections();

	if ( ! $project_id ) {
		$project_id = get_queried_object_id();
	}

	if ( ! $project_id || 'proyecto' !== get_post_type( $project_id ) ) {
		return $defaults;
	}

	$saved = get_post_meta( $project_id, '_echos_project_sections', true );
	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return echos_project_deep_merge( $defaults, $saved );
}

/**
 * Gets merged projects listing data (defaults + saved values).
 *
 * @param int $page_id Page ID.
 * @return array
 */
function echos_project_get_listing_data( $page_id = 0 ) {
	$defaults = echos_project_default_listing_sections();

	if ( ! $page_id ) {
		$page_id = get_queried_object_id();
	}

	if ( ! $page_id ) {
		return $defaults;
	}

	$saved = get_post_meta( $page_id, '_echos_project_listing_sections', true );
	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return echos_project_deep_merge( $defaults, $saved );
}

/**
 * Recursive merge preserving repeater structure.
 *
 * @param mixed $defaults Default value.
 * @param mixed $saved    Saved value.
 * @return mixed
 */
function echos_project_deep_merge( $defaults, $saved ) {
	if ( ! is_array( $defaults ) ) {
		return echos_project_has_saved_value( $saved ) ? $saved : $defaults;
	}

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	if ( echos_project_is_assoc_array( $defaults ) ) {
		$merged = array();

		foreach ( $defaults as $key => $default_value ) {
			$merged[ $key ] = echos_project_deep_merge(
				$default_value,
				isset( $saved[ $key ] ) ? $saved[ $key ] : null
			);
		}

		return $merged;
	}

	if ( empty( $saved ) ) {
		return $defaults;
	}

	$template_item = isset( $defaults[0] ) && is_array( $defaults[0] ) ? $defaults[0] : null;
	$normalized    = array();

	if ( ! is_array( $template_item ) ) {
		$scalar_items = array();

		foreach ( $saved as $row ) {
			if ( is_array( $row ) || null === $row ) {
				continue;
			}

			if ( is_string( $row ) ) {
				$row = trim( $row );
				if ( '' === $row ) {
					continue;
				}
			}

			$scalar_items[] = $row;
		}

		return ! empty( $scalar_items ) ? $scalar_items : $defaults;
	}

	foreach ( $saved as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$normalized[] = echos_project_deep_merge( $template_item, $row );
	}

	return ! empty( $normalized ) ? $normalized : $defaults;
}

/**
 * Checks whether value exists and should override defaults.
 *
 * @param mixed $value Value.
 * @return bool
 */
function echos_project_has_saved_value( $value ) {
	if ( is_string( $value ) ) {
		return '' !== trim( $value );
	}

	if ( is_numeric( $value ) || is_bool( $value ) ) {
		return true;
	}

	if ( is_array( $value ) ) {
		return ! empty( $value );
	}

	return null !== $value;
}

/**
 * Returns true for associative arrays.
 *
 * @param array $value Array value.
 * @return bool
 */
function echos_project_is_assoc_array( $value ) {
	if ( ! is_array( $value ) || array() === $value ) {
		return false;
	}

	return array_keys( $value ) !== range( 0, count( $value ) - 1 );
}

/**
 * Resolves image URL from saved value.
 *
 * @param mixed  $value    Saved value.
 * @param string $fallback Fallback URL.
 * @return string
 */
function echos_project_resolve_image_url( $value, $fallback = '' ) {
	if ( is_numeric( $value ) ) {
		$src = wp_get_attachment_image_url( (int) $value, 'full' );
		if ( $src ) {
			return $src;
		}
	}

	if ( is_string( $value ) && '' !== trim( $value ) ) {
		return $value;
	}

	return $fallback;
}

/**
 * Returns project card summary.
 *
 * @param int   $project_id   Project ID.
 * @param array $project_data Project data.
 * @return string
 */
function echos_project_get_card_summary( $project_id, $project_data = array() ) {
	$summary = '';

	if ( isset( $project_data['listing']['summary'] ) ) {
		$summary = trim( (string) $project_data['listing']['summary'] );
	}

	if ( '' !== $summary ) {
		return $summary;
	}

	$excerpt = get_the_excerpt( $project_id );
	if ( '' !== trim( (string) $excerpt ) ) {
		return (string) $excerpt;
	}

	$content = get_post_field( 'post_content', $project_id );
	if ( ! is_string( $content ) ) {
		return '';
	}

	return wp_trim_words( wp_strip_all_tags( $content ), 20, '...' );
}

/**
 * Returns project card badge text.
 *
 * @param int   $project_id   Project ID.
 * @param array $project_data Project data.
 * @return string
 */
function echos_project_get_card_badge( $project_id, $project_data = array() ) {
	if ( isset( $project_data['listing']['badge'] ) ) {
		$badge = trim( (string) $project_data['listing']['badge'] );
		if ( '' !== $badge ) {
			return $badge;
		}
	}

	$terms = wp_get_post_terms( $project_id, 'categoria_proyecto' );
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return __( 'Proyecto', 'echos' );
	}

	$first_term = $terms[0];
	if ( $first_term instanceof WP_Term ) {
		return $first_term->name;
	}

	return __( 'Proyecto', 'echos' );
}

/**
 * Resolves project ID for the project template page.
 *
 * Priority:
 * 1) Current queried project.
 * 2) Explicit fallback project ID.
 * 3) URL param ?proyecto=<id|slug>.
 * 4) First published project.
 *
 * @param int $fallback_project_id Optional fallback project ID.
 * @return int
 */
function echos_project_resolve_requested_project_id( $fallback_project_id = 0 ) {
	if ( is_singular( 'proyecto' ) ) {
		$current_id = get_queried_object_id();
		if ( $current_id ) {
			return (int) $current_id;
		}
	}

	if ( $fallback_project_id && 'proyecto' === get_post_type( $fallback_project_id ) ) {
		return (int) $fallback_project_id;
	}

	if ( isset( $_GET['proyecto'] ) ) {
		$raw = sanitize_text_field( wp_unslash( $_GET['proyecto'] ) );

		if ( is_numeric( $raw ) ) {
			$maybe_id = absint( $raw );
			if ( $maybe_id && 'proyecto' === get_post_type( $maybe_id ) ) {
				return $maybe_id;
			}
		}

		$slug = sanitize_title( $raw );
		if ( '' !== $slug ) {
			$maybe_post = get_page_by_path( $slug, OBJECT, 'proyecto' );
			if ( $maybe_post instanceof WP_Post ) {
				return (int) $maybe_post->ID;
			}
		}
	}

	$first_project = get_posts(
		array(
			'post_type'      => 'proyecto',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( ! empty( $first_project ) ) {
		return (int) $first_project[0];
	}

	return 0;
}

/**
 * Returns featured projects for listing slider.
 *
 * @param int $limit Number of projects.
 * @return array
 */
function echos_project_get_featured_projects( $limit = 6 ) {
	$limit = max( 1, min( 24, absint( $limit ) ) );

	$featured = get_posts(
		array(
			'post_type'      => 'proyecto',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'meta_key'       => '_echos_project_is_featured',
			'meta_value'     => 'yes',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( ! empty( $featured ) ) {
		return $featured;
	}

	return get_posts(
		array(
			'post_type'      => 'proyecto',
			'post_status'    => 'publish',
			'posts_per_page' => $limit,
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);
}

/**
 * Returns related projects for single project pages.
 *
 * @param int   $project_id Project ID.
 * @param array $data       Project data.
 * @return array
 */
function echos_project_get_related_projects( $project_id, $data = array() ) {
	$limit = isset( $data['related']['items_limit'] ) ? absint( $data['related']['items_limit'] ) : 4;
	if ( $limit < 1 ) {
		$limit = 4;
	}
	$limit = min( $limit, 12 );

	$base_args = array(
		'post_type'      => 'proyecto',
		'post_status'    => 'publish',
		'post__not_in'   => array( (int) $project_id ),
		'posts_per_page' => $limit,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$match_category = isset( $data['related']['match_category'] ) ? sanitize_key( $data['related']['match_category'] ) : 'yes';
	if ( 'yes' === $match_category ) {
		$terms = wp_get_post_terms(
			$project_id,
			'categoria_proyecto',
			array(
				'fields' => 'ids',
			)
		);

		if ( ! is_wp_error( $terms ) && ! empty( $terms ) ) {
			$by_category = get_posts(
				array_merge(
					$base_args,
					array(
						'tax_query' => array(
							array(
								'taxonomy' => 'categoria_proyecto',
								'field'    => 'term_id',
								'terms'    => $terms,
							),
						),
					)
				)
			);

			if ( ! empty( $by_category ) ) {
				return $by_category;
			}
		}
	}

	return get_posts( $base_args );
}

/**
 * Normalizes selected product IDs.
 *
 * @param mixed $raw_ids Raw IDs.
 * @return array
 */
function echos_project_normalize_selected_product_ids( $raw_ids ) {
	$values = is_array( $raw_ids ) ? $raw_ids : array( $raw_ids );
	$ids    = array();

	foreach ( $values as $value ) {
		if ( ! is_scalar( $value ) ) {
			continue;
		}

		$product_id = absint( $value );
		if ( ! $product_id ) {
			continue;
		}

		if ( 'producto' !== get_post_type( $product_id ) ) {
			continue;
		}

		$ids[] = $product_id;
	}

	if ( empty( $ids ) ) {
		return array();
	}

	return array_values( array_unique( $ids ) );
}

/**
 * Builds used-product features from product data.
 *
 * @param array $product_data Product data.
 * @param int   $limit        Max features.
 * @return array
 */
function echos_project_get_used_product_features( $product_data, $limit = 3 ) {
	$limit    = max( 1, absint( $limit ) );
	$features = array();
	$specs    = is_array( $product_data['specs'] ?? null ) ? $product_data['specs'] : array();
	$items    = is_array( $specs['items'] ?? null ) ? $specs['items'] : array();

	foreach ( $items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$feature = trim( (string) ( $item['title'] ?? '' ) );
		if ( '' === $feature ) {
			$feature = trim( (string) ( $item['text'] ?? '' ) );
		}

		if ( '' === $feature ) {
			continue;
		}

		$features[] = $feature;
		if ( count( $features ) >= $limit ) {
			break;
		}
	}

	return $features;
}

/**
 * Builds one used-product item from a product post.
 *
 * @param WP_Post $product_post Product post.
 * @return array
 */
function echos_project_build_used_product_item( $product_post ) {
	if ( ! $product_post instanceof WP_Post ) {
		return array();
	}

	$product_id = (int) $product_post->ID;
	if ( ! $product_id || 'producto' !== get_post_type( $product_id ) ) {
		return array();
	}

	$product_data = echos_product_get_data( $product_id );
	$title        = trim( (string) get_the_title( $product_id ) );
	$default_img  = get_template_directory_uri() . '/assets/img/inicio/baner1.jpg';
	$thumb        = get_the_post_thumbnail_url( $product_id, 'full' );
	$specs_image  = echos_product_resolve_image_url( ( $product_data['specs']['image'] ?? '' ), '' );
	$hero_image   = echos_product_resolve_image_url( ( $product_data['hero']['image'] ?? '' ), '' );
	$image        = echos_project_resolve_image_url( $thumb, '' );
	$image        = echos_project_resolve_image_url( $image, $specs_image );
	$image        = echos_project_resolve_image_url( $image, $hero_image );
	$image        = echos_project_resolve_image_url( $image, $default_img );
	$image_alt    = trim( (string) ( $product_data['specs']['image_alt'] ?? '' ) );

	if ( '' === $image_alt ) {
		$image_alt = trim( (string) ( $product_data['hero']['image_alt'] ?? '' ) );
	}

	if ( '' === $image_alt ) {
		$image_alt = '' !== $title ? $title : __( 'Producto', 'echos' );
	}

	$features = echos_project_get_used_product_features( $product_data, 3 );
	if ( empty( $features ) ) {
		$summary = trim( (string) echos_product_get_card_summary( $product_id, $product_data ) );
		if ( '' !== $summary ) {
			$features[] = $summary;
		}
	}

	return array(
		'id'        => $product_id,
		'name'      => $title,
		'url'       => (string) get_permalink( $product_id ),
		'image'     => $image,
		'image_alt' => $image_alt,
		'features' => $features,
	);
}

/**
 * Gets used products items for the project section.
 *
 * Priority:
 * 1) Selected products from CPT.
 * 2) Manual fallback rows from metabox.
 *
 * @param int   $project_id Project ID.
 * @param array $data       Project data.
 * @return array
 */
function echos_project_get_used_products_items( $project_id, $data = array() ) {
	$project_id    = absint( $project_id );
	if ( ! $project_id || 'proyecto' !== get_post_type( $project_id ) ) {
		return array();
	}

	$used_products = is_array( $data['used_products'] ?? null ) ? $data['used_products'] : array();
	$selected_ids  = echos_project_normalize_selected_product_ids( $used_products['selected_product_ids'] ?? array() );
	$items         = array();

	if ( ! empty( $selected_ids ) ) {
		$selected_posts = get_posts(
			array(
				'post_type'      => 'producto',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'post__in'       => $selected_ids,
				'orderby'        => 'post__in',
			)
		);

		if ( is_array( $selected_posts ) ) {
			foreach ( $selected_posts as $product_post ) {
				$item = echos_project_build_used_product_item( $product_post );
				if ( ! empty( $item ) ) {
					$items[] = $item;
				}
			}
		}
	}

	if ( ! empty( $items ) ) {
		return $items;
	}

	$manual_items = is_array( $used_products['items'] ?? null ) ? $used_products['items'] : array();

	foreach ( $manual_items as $item ) {
		if ( ! is_array( $item ) ) {
			continue;
		}

		$name     = trim( (string) ( $item['name'] ?? '' ) );
		$features = array();

		if ( isset( $item['features'] ) && is_array( $item['features'] ) ) {
			foreach ( $item['features'] as $feature ) {
				$feature_text = trim( (string) $feature );
				if ( '' !== $feature_text ) {
					$features[] = $feature_text;
				}
			}
		}

		if ( '' === $name && empty( $features ) ) {
			continue;
		}

		$items[] = array(
			'id'        => 0,
			'name'      => $name,
			'url'       => '',
			'image'     => '',
			'image_alt' => '' !== $name ? $name : __( 'Producto', 'echos' ),
			'features' => $features,
		);
	}

	return $items;
}
