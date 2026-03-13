<?php
/**
 * Service template data helpers.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gets merged service data (defaults + saved values).
 *
 * @param int $page_id Page ID.
 * @return array
 */
function echos_service_get_data( $page_id = 0 ) {
	$defaults = echos_service_default_data();

	if ( ! $page_id ) {
		$page_id = get_queried_object_id();
	}

	if ( ! $page_id ) {
		return $defaults;
	}

	$saved = get_post_meta( $page_id, '_echos_service_sections', true );

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return echos_service_deep_merge( $defaults, $saved );
}

/**
 * Returns data for a concrete service template variant.
 *
 * @param int    $page_id Page ID.
 * @param string $variant Template variant key.
 * @return array
 */
function echos_service_get_variant_data( $page_id = 0, $variant = 'infraestructura' ) {
	$data    = echos_service_get_data( $page_id );
	$variant = sanitize_key( $variant );

	if ( isset( $data[ $variant ] ) && is_array( $data[ $variant ] ) ) {
		return $data[ $variant ];
	}

	return isset( $data['infraestructura'] ) && is_array( $data['infraestructura'] ) ? $data['infraestructura'] : array();
}

/**
 * Recursive merge preserving repeater structure.
 *
 * @param mixed $defaults Default value.
 * @param mixed $saved    Saved value.
 * @return mixed
 */
function echos_service_deep_merge( $defaults, $saved ) {
	if ( ! is_array( $defaults ) ) {
		return echos_service_has_saved_value( $saved ) ? $saved : $defaults;
	}

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	if ( echos_service_is_assoc_array( $defaults ) ) {
		$merged = array();

		foreach ( $defaults as $key => $default_value ) {
			$merged[ $key ] = echos_service_deep_merge(
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
			$normalized[] = echos_service_deep_merge( $template_item, $row );
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
function echos_service_has_saved_value( $value ) {
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
function echos_service_is_assoc_array( $value ) {
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
function echos_service_resolve_image_url( $value, $fallback = '' ) {
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
function echos_service_multiline_text( $text ) {
	return nl2br( esc_html( (string) $text ) );
}
