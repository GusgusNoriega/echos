<?php
/**
 * Footer data helpers.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Gets merged footer data (defaults + saved values).
 *
 * @return array
 */
function echos_footer_get_data() {
	$defaults = echos_footer_default_data();
	$saved    = get_option( 'echos_footer_sections', array() );

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	$merged = echos_footer_deep_merge( $defaults, $saved );

	$merged['social_label'] = isset( $merged['social_label'] ) ? (string) $merged['social_label'] : '';
	if ( '' === trim( $merged['social_label'] ) ) {
		$merged['social_label'] = (string) $defaults['social_label'];
	}

	$merged['social_links'] = echos_footer_normalize_social_links(
		isset( $merged['social_links'] ) ? $merged['social_links'] : array()
	);

	$merged['columns'] = echos_footer_normalize_columns(
		isset( $merged['columns'] ) ? $merged['columns'] : array()
	);

	$merged['brand_image'] = echos_footer_resolve_image_url(
		isset( $merged['brand_image'] ) ? $merged['brand_image'] : '',
		(string) $defaults['brand_image']
	);

	$merged['brand_image_alt'] = isset( $merged['brand_image_alt'] ) ? (string) $merged['brand_image_alt'] : (string) $defaults['brand_image_alt'];
	if ( '' === trim( $merged['brand_image_alt'] ) ) {
		$merged['brand_image_alt'] = (string) $defaults['brand_image_alt'];
	}

	$merged['brand_image_link'] = isset( $merged['brand_image_link'] ) ? (string) $merged['brand_image_link'] : (string) $defaults['brand_image_link'];
	if ( '' === trim( $merged['brand_image_link'] ) ) {
		$merged['brand_image_link'] = (string) $defaults['brand_image_link'];
	}

	return $merged;
}

/**
 * Recursive merge preserving repeater structure.
 *
 * @param mixed $defaults Default value.
 * @param mixed $saved    Saved value.
 * @return mixed
 */
function echos_footer_deep_merge( $defaults, $saved ) {
	if ( ! is_array( $defaults ) ) {
		return echos_footer_has_saved_value( $saved ) ? $saved : $defaults;
	}

	if ( ! is_array( $saved ) ) {
		return $defaults;
	}

	if ( echos_footer_is_assoc_array( $defaults ) ) {
		$merged = array();

		foreach ( $defaults as $key => $default_value ) {
			$merged[ $key ] = echos_footer_deep_merge(
				$default_value,
				isset( $saved[ $key ] ) ? $saved[ $key ] : null
			);
		}

		return $merged;
	}

	if ( empty( $saved ) ) {
		return $defaults;
	}

	$normalized = array();
	foreach ( $saved as $row ) {
		if ( is_array( $row ) ) {
			$normalized[] = $row;
		}
	}

	return ! empty( $normalized ) ? $normalized : $defaults;
}

/**
 * Checks whether value exists and should override defaults.
 *
 * @param mixed $value Value.
 * @return bool
 */
function echos_footer_has_saved_value( $value ) {
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
function echos_footer_is_assoc_array( $value ) {
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
function echos_footer_resolve_image_url( $value, $fallback = '' ) {
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
function echos_footer_multiline_text( $text ) {
	return nl2br( esc_html( (string) $text ) );
}

/**
 * Normalizes footer social links.
 *
 * @param mixed $links Raw links.
 * @return array
 */
function echos_footer_normalize_social_links( $links ) {
	if ( ! is_array( $links ) ) {
		$defaults = echos_footer_default_data();
		$links    = isset( $defaults['social_links'] ) && is_array( $defaults['social_links'] ) ? $defaults['social_links'] : array();
	}

	$allowed    = array_keys( echos_footer_social_platform_options() );
	$normalized = array();

	foreach ( $links as $link ) {
		if ( ! is_array( $link ) ) {
			continue;
		}

		$platform = sanitize_key( $link['platform'] ?? 'custom' );
		if ( ! in_array( $platform, $allowed, true ) ) {
			$platform = 'custom';
		}

		$url   = trim( (string) ( $link['url'] ?? '' ) );
		$label = trim( (string) ( $link['label'] ?? '' ) );

		if ( '' === $url ) {
			$url = '#';
		}

		if ( '' === $label ) {
			$label = echos_footer_default_social_label( $platform );
		}

		$normalized[] = array(
			'platform' => $platform,
			'url'      => $url,
			'label'    => $label,
		);
	}

	if ( empty( $normalized ) ) {
		$normalized[] = array(
			'platform' => 'instagram',
			'url'      => '#',
			'label'    => 'Instagram',
		);
	}

	return $normalized;
}

/**
 * Normalizes footer columns and links.
 *
 * @param mixed $columns Raw columns.
 * @return array
 */
function echos_footer_normalize_columns( $columns ) {
	if ( ! is_array( $columns ) ) {
		$defaults = echos_footer_default_data();
		$columns  = isset( $defaults['columns'] ) && is_array( $defaults['columns'] ) ? $defaults['columns'] : array();
	}

	$normalized = array();

	foreach ( $columns as $column ) {
		if ( ! is_array( $column ) ) {
			continue;
		}

		$title = sanitize_text_field( (string) ( $column['title'] ?? '' ) );
		$links = echos_footer_normalize_column_links( $column['links'] ?? array() );

		if ( '' === $title && empty( $links ) ) {
			continue;
		}

		if ( '' === $title ) {
			$title = __( 'Enlaces', 'echos' );
		}

		$normalized[] = array(
			'title' => $title,
			'links' => $links,
		);
	}

	if ( empty( $normalized ) ) {
		$defaults   = echos_footer_default_data();
		$normalized = isset( $defaults['columns'] ) && is_array( $defaults['columns'] ) ? $defaults['columns'] : array();
	}

	return $normalized;
}

/**
 * Normalizes links array of a footer column.
 *
 * @param mixed $links Raw links.
 * @return array
 */
function echos_footer_normalize_column_links( $links ) {
	if ( is_string( $links ) ) {
		$links = echos_footer_parse_links_lines( $links );
	}

	if ( ! is_array( $links ) ) {
		return array();
	}

	$normalized = array();

	foreach ( $links as $link ) {
		if ( ! is_array( $link ) ) {
			continue;
		}

		$label = sanitize_text_field( (string) ( $link['label'] ?? '' ) );
		$url   = trim( (string) ( $link['url'] ?? '' ) );

		if ( '' === $label ) {
			continue;
		}

		if ( '' === $url ) {
			$url = '#';
		}

		$normalized[] = array(
			'label' => $label,
			'url'   => $url,
		);
	}

	return $normalized;
}

/**
 * Parses links lines with format "Texto|URL".
 *
 * @param string $text Raw lines.
 * @return array
 */
function echos_footer_parse_links_lines( $text ) {
	$rows  = preg_split( '/\r\n|\r|\n/', (string) $text );
	$links = array();

	if ( ! is_array( $rows ) ) {
		return $links;
	}

	foreach ( $rows as $row ) {
		$line = trim( (string) $row );
		if ( '' === $line ) {
			continue;
		}

		$parts = explode( '|', $line, 2 );
		$label = sanitize_text_field( trim( (string) $parts[0] ) );
		$url   = isset( $parts[1] ) ? esc_url_raw( trim( (string) $parts[1] ) ) : '';

		if ( '' === $label ) {
			continue;
		}

		if ( '' === $url ) {
			$url = '#';
		}

		$links[] = array(
			'label' => $label,
			'url'   => $url,
		);
	}

	return $links;
}

/**
 * Converts links array to text lines for admin textarea.
 *
 * @param mixed $links Links array.
 * @return string
 */
function echos_footer_links_to_lines( $links ) {
	if ( ! is_array( $links ) ) {
		return '';
	}

	$lines = array();

	foreach ( $links as $link ) {
		if ( ! is_array( $link ) ) {
			continue;
		}

		$label = trim( (string) ( $link['label'] ?? '' ) );
		$url   = trim( (string) ( $link['url'] ?? '' ) );

		if ( '' === $label ) {
			continue;
		}

		$line = $label;
		if ( '' !== $url ) {
			$line .= '|' . $url;
		}

		$lines[] = $line;
	}

	return implode( "\n", $lines );
}

/**
 * Returns icon markup for social links.
 *
 * @param string $platform Platform key.
 * @return string
 */
function echos_footer_get_social_icon_markup( $platform ) {
	switch ( sanitize_key( (string) $platform ) ) {
		case 'facebook':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>';

		case 'tiktok':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .54.04.79.1v-3.5a6.37 6.37 0 00-.79-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 0010.86 4.48V13a8.28 8.28 0 005.58 2.15V11.7a4.83 4.83 0 01-3.77-1.24V6.69h3.77z"/></svg>';

		case 'linkedin':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>';

		case 'youtube':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a2.99 2.99 0 0 0-2.103-2.117C19.53 3.5 12 3.5 12 3.5s-7.53 0-9.395.569A2.99 2.99 0 0 0 .502 6.186C0 8.062 0 12 0 12s0 3.938.502 5.814a2.99 2.99 0 0 0 2.103 2.117C4.47 20.5 12 20.5 12 20.5s7.53 0 9.395-.569a2.99 2.99 0 0 0 2.103-2.117C24 15.938 24 12 24 12s0-3.938-.502-5.814zM9.75 15.568V8.432L15.818 12 9.75 15.568z"/></svg>';

		case 'whatsapp':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.52 3.48A11.92 11.92 0 0012.03 0C5.4 0 .03 5.37.03 12c0 2.11.55 4.17 1.6 5.99L0 24l6.17-1.62a11.97 11.97 0 005.86 1.5h.01c6.63 0 12-5.37 12-12 0-3.2-1.25-6.2-3.52-8.4zm-8.49 18.36h-.01a9.95 9.95 0 01-5.07-1.39l-.36-.21-3.66.96.98-3.57-.23-.37A9.94 9.94 0 012.05 12c0-5.5 4.48-9.98 9.99-9.98 2.67 0 5.18 1.04 7.07 2.93A9.93 9.93 0 0122.04 12c0 5.5-4.48 9.98-10 9.98zm5.47-7.47c-.3-.15-1.77-.87-2.05-.97-.27-.1-.47-.15-.66.15-.2.3-.76.97-.94 1.17-.17.2-.35.22-.65.08-.3-.15-1.27-.47-2.41-1.5-.89-.79-1.49-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.35.45-.52.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.51h-.57c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.49 0 1.46 1.07 2.88 1.22 3.08.15.2 2.1 3.21 5.09 4.5.71.31 1.26.49 1.69.63.71.23 1.36.2 1.88.12.57-.09 1.77-.72 2.02-1.42.25-.7.25-1.3.17-1.42-.07-.12-.27-.2-.57-.35z"/></svg>';

		case 'x':
			return '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2H21l-6.57 7.51L22.5 22h-6.67l-5.22-6.82L4.64 22H1.88l7.03-8.03L1.5 2h6.84l4.71 6.23L18.244 2zm-.97 18h1.85L7.33 3.9H5.35L17.274 20z"/></svg>';

		case 'instagram':
			return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2.2" y="2.2" width="19.6" height="19.6" rx="5"/><circle cx="12" cy="12" r="4.7"/><circle cx="17.6" cy="6.4" r="1.3" fill="currentColor" stroke="none"/></svg>';

		case 'custom':
		default:
			return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.07 0l2.83-2.83a5 5 0 0 0-7.07-7.07L11.2 4.72"/><path d="M14 11a5 5 0 0 0-7.07 0L4.1 13.83a5 5 0 0 0 7.07 7.07l1.41-1.41"/></svg>';
	}
}
