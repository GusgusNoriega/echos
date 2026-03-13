<?php
/**
 * Template Name: Servicio - Iluminacion
 * Description: Pagina administrable del servicio de Iluminacion.
 * Template Post Type: page, servicio
 *
 * @package Echos
 */

get_header();

$data = echos_service_get_variant_data( get_queried_object_id(), 'iluminacion' );

get_template_part(
	'template-parts/service/layout',
	'iluminacion',
	array(
		'service' => $data,
	)
);

get_footer();

