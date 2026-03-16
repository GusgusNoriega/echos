<?php
/**
 * Footer default data.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns social platform options.
 *
 * @return array
 */
function echos_footer_social_platform_options() {
	return array(
		'instagram' => 'Instagram',
		'facebook'  => 'Facebook',
		'tiktok'    => 'TikTok',
		'linkedin'  => 'LinkedIn',
		'youtube'   => 'YouTube',
		'whatsapp'  => 'WhatsApp',
		'x'         => 'X',
		'custom'    => 'Custom',
	);
}

/**
 * Returns a fallback social label by platform.
 *
 * @param string $platform Platform key.
 * @return string
 */
function echos_footer_default_social_label( $platform ) {
	$labels = array(
		'instagram' => 'Instagram',
		'facebook'  => 'Facebook',
		'tiktok'    => 'TikTok',
		'linkedin'  => 'LinkedIn',
		'youtube'   => 'YouTube',
		'whatsapp'  => 'WhatsApp',
		'x'         => 'X',
		'custom'    => 'Social link',
	);

	$key = sanitize_key( (string) $platform );

	return isset( $labels[ $key ] ) ? $labels[ $key ] : 'Social link';
}

/**
 * Returns default content for footer.
 *
 * @return array
 */
function echos_footer_default_data() {
	$home = home_url( '/' );

	return array(
		'social_label' => "Siguenos en nuestras\nredes sociales!",
		'social_links' => array(
			array(
				'platform' => 'instagram',
				'url'      => '#',
				'label'    => 'Instagram',
			),
			array(
				'platform' => 'facebook',
				'url'      => '#',
				'label'    => 'Facebook',
			),
			array(
				'platform' => 'tiktok',
				'url'      => '#',
				'label'    => 'TikTok',
			),
			array(
				'platform' => 'linkedin',
				'url'      => '#',
				'label'    => 'LinkedIn',
			),
		),
		'columns'      => array(
			array(
				'title' => 'ECHOS',
				'links' => array(
					array(
						'label' => 'Productos',
						'url'   => $home . '#clientes',
					),
					array(
						'label' => 'Servicios',
						'url'   => $home . '#servicios',
					),
					array(
						'label' => 'Proyectos',
						'url'   => $home . '#proyectos',
					),
					array(
						'label' => 'Conocenos',
						'url'   => $home . '#conocenos',
					),
				),
			),
			array(
				'title' => 'Legal',
				'links' => array(
					array(
						'label' => 'Politicas de privacidad',
						'url'   => '#',
					),
					array(
						'label' => 'Terminos y condiciones',
						'url'   => '#',
					),
				),
			),
		),
		'brand_image'  => echos_asset( 'img/inicio/logo-footer.png' ),
		'brand_image_alt' => 'ECHOS Logo',
		'brand_image_link' => $home,
	);
}
