<?php
/**
 * Template Name: Servicio - Infraestructura
 * Description: Pagina administrable del servicio de Infraestructura.
 * Template Post Type: page, servicio
 *
 * @package Echos
 */

get_header();

$data = echos_service_get_variant_data( get_queried_object_id(), 'infraestructura' );

get_template_part(
	'template-parts/service/layout',
	'infraestructura',
	array(
		'service' => $data,
	)
);

get_footer();

