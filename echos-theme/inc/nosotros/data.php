<?php
/**
 * Nosotros template data helpers.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gets merged nosotros data (defaults + saved values).
 *
 * @param int $page_id Page ID.
 * @return array
 */
function echos_nosotros_get_data( $page_id = 0 ) {
	$defaults = echos_nosotros_default_data();

	if ( ! $page_id ) {
		$page_id = get_queried_object_id();
	}

	if ( ! $page_id ) {
		return $defaults;
	}

	$saved = get_post_meta( $page_id, '_echos_nosotros_sections', true );

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return echos_nosotros_deep_merge( $defaults, $saved );
}

/**
 * Recursive merge preserving repeater structure.
 *
 * @param mixed $defaults Default value.
 * @param mixed $saved    Saved value.
 * @return mixed
 */
function echos_nosotros_deep_merge( $defaults, $saved ) {
	if ( ! is_array( $defaults ) ) {
		return echos_nosotros_has_saved_value( $saved ) ? $saved : $defaults;
	}

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	if ( echos_nosotros_is_assoc_array( $defaults ) ) {
		$merged = array();

		foreach ( $defaults as $key => $default_value ) {
			$merged[ $key ] = echos_nosotros_deep_merge(
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
			$normalized[] = echos_nosotros_deep_merge( $template_item, $row );
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
function echos_nosotros_has_saved_value( $value ) {
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
function echos_nosotros_is_assoc_array( $value ) {
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
function echos_nosotros_resolve_image_url( $value, $fallback = '' ) {
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
function echos_nosotros_multiline_text( $text ) {
	return nl2br( esc_html( (string) $text ) );
}

/**
 * Returns icon markup for nosotros CTA buttons.
 *
 * @param string $icon Icon key.
 * @return string
 */
function echos_nosotros_get_action_icon_markup( $icon ) {
	switch ( sanitize_key( (string) $icon ) ) {
		case 'email':
			return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 4L12 13 2 4"/></svg>';

		case 'arrow':
			return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>';

		case 'whatsapp':
		default:
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.025.507 3.932 1.396 5.608L.05 23.708a.6.6 0 00.735.728L6.53 22.64A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.6a9.56 9.56 0 01-5.175-1.516l-.372-.222-3.843.985 1.028-3.752-.243-.387A9.56 9.56 0 012.4 12c0-5.302 4.298-9.6 9.6-9.6s9.6 4.298 9.6 9.6-4.298 9.6-9.6 9.6z"/></svg>';
	}
}

/**
 * Normalizes MV icon key, keeping backward compatibility with old values.
 *
 * @param string $icon Icon key.
 * @return string
 */
function echos_nosotros_normalize_mv_icon_key( $icon ) {
	$key = sanitize_key( (string) $icon );

	switch ( $key ) {
		case 'gear':
		case 'star':
		case 'ojo':
			return 'ojo';

		case 'mountain':
		case 'montana':
			return 'montana';

		default:
			return 'ojo';
	}
}

/**
 * Returns icon URL for mision and vision cards.
 *
 * @param string $icon Icon key.
 * @return string
 */
function echos_nosotros_get_mv_icon_url( $icon ) {
	$normalized = echos_nosotros_normalize_mv_icon_key( $icon );
	$base_url   = trailingslashit( get_template_directory_uri() ) . 'assets/img/nosotros/';

	return $base_url . $normalized . '.svg';
}

/**
 * Returns icon markup for mision and vision cards.
 *
 * @param string $icon Icon key.
 * @return string
 */
function echos_nosotros_get_mv_icon_markup( $icon ) {
	$normalized = echos_nosotros_normalize_mv_icon_key( $icon );
	$icon_url   = echos_nosotros_get_mv_icon_url( $normalized );

	if ( '' === trim( $icon_url ) ) {
		return '';
	}

	return sprintf(
		'<img class="nosotros-mv__icon-img nosotros-mv__icon-img--%1$s" src="%2$s" alt="" loading="lazy" decoding="async" />',
		esc_attr( $normalized ),
		esc_url( $icon_url )
	);
}
