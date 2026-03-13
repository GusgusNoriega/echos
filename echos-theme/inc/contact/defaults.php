<?php
/**
 * Contact template default data.
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
function echos_contact_social_platform_options() {
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
 * Returns action icon options.
 *
 * @return array
 */
function echos_contact_action_icon_options() {
	return array(
		'whatsapp' => 'WhatsApp',
		'email'    => 'Email',
		'arrow'    => 'Arrow',
	);
}

/**
 * Returns default content for contact template.
 *
 * @return array
 */
function echos_contact_default_data() {
	return array(
		'topbar_cta_url'        => home_url( '/#contacto' ),
		'topbar_cta_label'      => 'Cotiza tu proyecto',
		'background_image'      => '',
		'left_image'            => '',
		'left_image_alt'        => '',
		'title'                 => "DEJANOS CONOCER LOS DETALLES DE TU PROYECTO",
		'description'           => 'Selecciona el servicio en el que estas interesado y rellena tus datos de contacto completos.',
		'action_primary_text'   => 'Conversemos ahora',
		'action_primary_url'    => 'https://wa.me/',
		'action_primary_icon'   => 'whatsapp',
		'action_secondary_text' => 'contacto@echosperu.com.pe',
		'action_secondary_url'  => 'mailto:contacto@echosperu.com.pe',
		'action_secondary_icon' => 'email',
		'social_label'          => 'Siguenos en redes sociales',
		'social_links'          => array(
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
		'form_hint'             => 'Selecciona el servicio en el que estas interesado',
		'submit_text'           => 'Enviar mis datos',
		'placeholder_name'      => 'Nombre',
		'placeholder_company'   => 'Empresa',
		'placeholder_email'     => 'Email corporativo',
		'placeholder_phone'     => 'Telefono',
		'placeholder_detail'    => 'Cuentanos sobre tu evento y necesidades especificas',
		'tabs'                  => array(
			array(
				'label' => 'Infraestructura',
				'value' => 'Infraestructura',
			),
			array(
				'label' => 'Iluminacion',
				'value' => 'Iluminacion',
			),
			array(
				'label' => 'Stands',
				'value' => 'Stands',
			),
		),
	);
}

