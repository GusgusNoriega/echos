<?php
/**
 * Popup default data.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default popup values.
 *
 * @return array
 */
function echos_popup_default_data() {
	return array(
		'enabled' => false,
		'image'   => get_template_directory_uri() . '/assets/img/popup/image-popup.jpg',
		'title'   => "CONSIGUE UN 20%\nDE DESCUENTO",
		'text'    => 'Lorem ipsum dolor sit amet consectetur. Gravida suspendisse quis a quis. Amet rutrum.',
	);
}
