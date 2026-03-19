<?php
/**
 * Popup data helpers.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gets popup data for a page (defaults + saved values).
 *
 * @param int $page_id Page ID.
 * @return array
 */
function echos_popup_get_data( $page_id = 0 ) {
	$defaults = echos_popup_default_data();

	if ( ! $page_id ) {
		$page_id = get_queried_object_id();
	}

	if ( ! $page_id || 'page' !== get_post_type( $page_id ) ) {
		return $defaults;
	}

	$saved = get_post_meta( $page_id, '_echos_popup_data', true );
	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return array(
		'enabled' => ! empty( $saved['enabled'] ),
		'image'   => echos_popup_resolve_image_url(
			isset( $saved['image'] ) ? $saved['image'] : '',
			(string) $defaults['image']
		),
		'title'   => echos_popup_pick_text_value( $saved, 'title', (string) $defaults['title'] ),
		'text'    => echos_popup_pick_text_value( $saved, 'text', (string) $defaults['text'] ),
	);
}

/**
 * Returns whether popup should be rendered for the current page.
 *
 * @param int $page_id Page ID.
 * @return bool
 */
function echos_popup_should_render( $page_id = 0 ) {
	if ( ! is_singular( 'page' ) ) {
		return false;
	}

	if ( ! $page_id ) {
		$page_id = get_queried_object_id();
	}

	if ( ! $page_id || 'page' !== get_post_type( $page_id ) ) {
		return false;
	}

	$data = echos_popup_get_data( $page_id );
	return ! empty( $data['enabled'] );
}

/**
 * Resolves image URL from saved value.
 *
 * @param mixed  $value    Saved value.
 * @param string $fallback Fallback URL.
 * @return string
 */
function echos_popup_resolve_image_url( $value, $fallback = '' ) {
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
 * Escapes multiline text preserving line breaks.
 *
 * @param string $text Text value.
 * @return string
 */
function echos_popup_multiline_text( $text ) {
	return nl2br( esc_html( (string) $text ) );
}

/**
 * Gets non-empty scalar text from array key with fallback.
 *
 * @param array  $data     Data array.
 * @param string $key      Key name.
 * @param string $fallback Fallback value.
 * @return string
 */
function echos_popup_pick_text_value( $data, $key, $fallback ) {
	if ( ! is_array( $data ) || ! isset( $data[ $key ] ) || ! is_scalar( $data[ $key ] ) ) {
		return $fallback;
	}

	$value = (string) $data[ $key ];
	if ( '' === trim( $value ) ) {
		return $fallback;
	}

	return $value;
}
