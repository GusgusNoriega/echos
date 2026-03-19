<?php
/**
 * Home template data helpers.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gets merged home data (defaults + saved values).
 *
 * @param int $page_id Page ID.
 * @return array
 */
function echos_home_get_data( $page_id = 0 ) {
	$defaults = echos_home_default_data();

	if ( ! $page_id ) {
		$page_id = get_queried_object_id();
	}

	if ( ! $page_id ) {
		return $defaults;
	}

	$saved = get_post_meta( $page_id, '_echos_home_sections', true );

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	return echos_home_deep_merge( $defaults, $saved );
}

/**
 * Recursive merge preserving repeater structure.
 *
 * @param mixed $defaults Default value.
 * @param mixed $saved    Saved value.
 * @return mixed
 */
function echos_home_deep_merge( $defaults, $saved ) {
	if ( ! is_array( $defaults ) ) {
		return echos_home_has_saved_value( $saved ) ? $saved : $defaults;
	}

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	if ( echos_home_is_assoc_array( $defaults ) ) {
		$merged = array();

		foreach ( $defaults as $key => $default_value ) {
			$merged[ $key ] = echos_home_deep_merge(
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
			$normalized[] = echos_home_deep_merge( $template_item, $row );
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
function echos_home_has_saved_value( $value ) {
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
function echos_home_is_assoc_array( $value ) {
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
function echos_home_resolve_image_url( $value, $fallback = '' ) {
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
 * Extracts YouTube video ID from common URL formats.
 *
 * @param string $value Raw URL or potential ID.
 * @return string
 */
function echos_home_extract_youtube_id( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value ) {
		return '';
	}

	if ( preg_match( '/^[A-Za-z0-9_-]{11}$/', $value ) ) {
		return $value;
	}

	$parts = wp_parse_url( $value );
	if ( ! is_array( $parts ) ) {
		return '';
	}

	$host = isset( $parts['host'] ) ? strtolower( (string) $parts['host'] ) : '';
	$path = isset( $parts['path'] ) ? trim( (string) $parts['path'], '/' ) : '';

	$query = array();
	if ( ! empty( $parts['query'] ) ) {
		parse_str( (string) $parts['query'], $query );
	}

	$video_id = '';

	if ( '' !== $host && false !== strpos( $host, 'youtu.be' ) ) {
		$segments = array_values( array_filter( explode( '/', $path ) ) );
		$video_id = isset( $segments[0] ) ? (string) $segments[0] : '';
	} elseif ( '' !== $host && ( false !== strpos( $host, 'youtube.com' ) || false !== strpos( $host, 'youtube-nocookie.com' ) ) ) {
		if ( isset( $query['v'] ) ) {
			$video_id = (string) $query['v'];
		}

		if ( '' === $video_id && '' !== $path ) {
			$segments = array_values( array_filter( explode( '/', $path ) ) );

			if ( isset( $segments[0], $segments[1] ) && in_array( $segments[0], array( 'embed', 'shorts', 'live', 'v' ), true ) ) {
				$video_id = (string) $segments[1];
			}
		}
	}

	$video_id = trim( $video_id );

	if ( preg_match( '/^[A-Za-z0-9_-]{11}$/', $video_id ) ) {
		return $video_id;
	}

	return '';
}

/**
 * Builds embeddable YouTube URL with autoplay, mute and loop.
 *
 * @param string $value Raw URL or potential ID.
 * @return string
 */
function echos_home_build_youtube_embed_url( $value ) {
	$video_id = echos_home_extract_youtube_id( $value );

	if ( '' === $video_id ) {
		return '';
	}

	$embed_base = 'https://www.youtube.com/embed/' . rawurlencode( $video_id );

	return add_query_arg(
		array(
			'autoplay'       => '1',
			'mute'           => '1',
			'controls'       => '0',
			'playsinline'    => '1',
			'loop'           => '1',
			'playlist'       => $video_id,
			'rel'            => '0',
			'modestbranding' => '1',
			'iv_load_policy' => '3',
			'disablekb'      => '1',
		),
		$embed_base
	);
}

/**
 * Escaped multiline text keeping line breaks.
 *
 * @param string $text Text value.
 * @return string
 */
function echos_home_multiline_text( $text ) {
	return nl2br( esc_html( (string) $text ) );
}
