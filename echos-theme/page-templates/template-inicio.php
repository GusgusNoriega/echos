<?php
/**
 * Template Name: Inicio
 * Description: Pagina principal de ECHOS con secciones administrables.
 *
 * @package Echos
 */

get_header();

$home_data = echos_home_get_data( get_the_ID() );

get_template_part(
	'template-parts/home/section',
	'hero',
	array(
		'hero' => isset( $home_data['hero'] ) ? $home_data['hero'] : array(),
	)
);

get_template_part(
	'template-parts/home/section',
	'clients',
	array(
		'clients' => isset( $home_data['clients'] ) ? $home_data['clients'] : array(),
	)
);

get_template_part(
	'template-parts/home/section',
	'about',
	array(
		'about' => isset( $home_data['about'] ) ? $home_data['about'] : array(),
	)
);

get_template_part(
	'template-parts/home/section',
	'projects',
	array(
		'projects' => isset( $home_data['projects'] ) ? $home_data['projects'] : array(),
	)
);

get_template_part(
	'template-parts/home/section',
	'services',
	array(
		'services' => isset( $home_data['services'] ) ? $home_data['services'] : array(),
	)
);

get_template_part(
	'template-parts/home/section',
	'contact',
	array(
		'contact' => isset( $home_data['contact'] ) ? $home_data['contact'] : array(),
	)
);

get_footer();
