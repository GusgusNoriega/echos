<?php
/**
 * Product template data helpers.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gets merged product data (defaults + saved values).
 *
 * @param int $product_id Product ID.
 * @return array
 */
function echos_product_get_data( $product_id = 0 ) {
	$defaults = echos_product_default_single_sections();

	if ( ! $product_id ) {
		$product_id = get_queried_object_id();
	}

	if ( ! $product_id || 'producto' !== get_post_type( $product_id ) ) {
		return $defaults;
	}

	$saved = get_post_meta( $product_id, '_echos_product_sections', true );
	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return echos_product_deep_merge( $defaults, $saved );
}

/**
 * Gets merged listing page data (defaults + saved values).
 *
 * @param int $page_id Page ID.
 * @return array
 */
function echos_product_get_listing_data( $page_id = 0 ) {
	$defaults = echos_product_default_listing_sections();

	if ( ! $page_id ) {
		$page_id = get_queried_object_id();
	}

	if ( ! $page_id ) {
		return $defaults;
	}

	$saved = get_post_meta( $page_id, '_echos_product_listing_sections', true );
	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return echos_product_deep_merge( $defaults, $saved );
}

/**
 * Recursive merge preserving repeater structure.
 *
 * @param mixed $defaults Default value.
 * @param mixed $saved    Saved value.
 * @return mixed
 */
function echos_product_deep_merge( $defaults, $saved ) {
	if ( ! is_array( $defaults ) ) {
		return echos_product_has_saved_value( $saved ) ? $saved : $defaults;
	}

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	if ( echos_product_is_assoc_array( $defaults ) ) {
		$merged = array();

		foreach ( $defaults as $key => $default_value ) {
			$merged[ $key ] = echos_product_deep_merge(
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

	foreach ( $saved as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		if ( is_array( $template_item ) ) {
			$normalized[] = echos_product_deep_merge( $template_item, $row );
			continue;
		}

		$normalized[] = $row;
	}

	return ! empty( $normalized ) ? $normalized : $defaults;
}

/**
 * Checks whether value exists and should override defaults.
 *
 * @param mixed $value Value.
 * @return bool
 */
function echos_product_has_saved_value( $value ) {
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
function echos_product_is_assoc_array( $value ) {
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
function echos_product_resolve_image_url( $value, $fallback = '' ) {
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
 * Escaped multiline text keeping line breaks.
 *
 * @param string $text Text value.
 * @return string
 */
function echos_product_multiline_text( $text ) {
	return nl2br( esc_html( (string) $text ) );
}

/**
 * Returns product card summary.
 *
 * @param int   $product_id   Product ID.
 * @param array $product_data Product data.
 * @return string
 */
function echos_product_get_card_summary( $product_id, $product_data = array() ) {
	$summary = '';

	if ( isset( $product_data['listing']['summary'] ) ) {
		$summary = trim( (string) $product_data['listing']['summary'] );
	}

	if ( '' !== $summary ) {
		return $summary;
	}

	$excerpt = get_the_excerpt( $product_id );
	if ( '' !== trim( (string) $excerpt ) ) {
		return (string) $excerpt;
	}

	$content = get_post_field( 'post_content', $product_id );
	if ( ! is_string( $content ) ) {
		return '';
	}

	return wp_trim_words( wp_strip_all_tags( $content ), 20, '...' );
}

/**
 * Resolves product ID for the product template page.
 *
 * Priority:
 * 1) Current queried product.
 * 2) Explicit fallback product ID.
 * 3) URL param ?producto=<id|slug>.
 * 4) First published product.
 *
 * @param int $fallback_product_id Optional fallback product ID.
 * @return int
 */
function echos_product_resolve_requested_product_id( $fallback_product_id = 0 ) {
	if ( is_singular( 'producto' ) ) {
		$current_id = get_queried_object_id();
		if ( $current_id ) {
			return (int) $current_id;
		}
	}

	if ( $fallback_product_id && 'producto' === get_post_type( $fallback_product_id ) ) {
		return (int) $fallback_product_id;
	}

	if ( isset( $_GET['producto'] ) ) {
		$raw = sanitize_text_field( wp_unslash( $_GET['producto'] ) );

		if ( is_numeric( $raw ) ) {
			$maybe_id = absint( $raw );
			if ( $maybe_id && 'producto' === get_post_type( $maybe_id ) ) {
				return $maybe_id;
			}
		}

		$slug = sanitize_title( $raw );
		if ( '' !== $slug ) {
			$maybe_post = get_page_by_path( $slug, OBJECT, 'producto' );
			if ( $maybe_post instanceof WP_Post ) {
				return (int) $maybe_post->ID;
			}
		}
	}

	$first_product = get_posts(
		array(
			'post_type'      => 'producto',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'orderby'        => 'date',
			'order'          => 'DESC',
		)
	);

	if ( ! empty( $first_product ) ) {
		return (int) $first_product[0];
	}

	return 0;
}

/**
 * Returns recommended products for single product pages.
 *
 * @param int   $product_id Product ID.
 * @param array $data       Product data.
 * @return array
 */
function echos_product_get_recommended_products( $product_id, $data = array() ) {
	$limit = isset( $data['recommended']['items_limit'] ) ? absint( $data['recommended']['items_limit'] ) : 4;
	if ( $limit < 1 ) {
		$limit = 4;
	}
	$limit = min( $limit, 12 );

	$base_args = array(
		'post_type'      => 'producto',
		'post_status'    => 'publish',
		'post__not_in'   => array( (int) $product_id ),
		'posts_per_page' => $limit,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$match_category = isset( $data['recommended']['match_category'] ) ? sanitize_key( $data['recommended']['match_category'] ) : 'yes';
	if ( 'yes' === $match_category ) {
		$terms = wp_get_post_terms(
			$product_id,
			'categoria_producto',
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
								'taxonomy' => 'categoria_producto',
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
