<?php
/**
 * Template Name: Servicio - Stands para Ferias
 * Description: Pagina administrable del servicio de Stands para Ferias.
 * Template Post Type: page, servicio
 *
 * @package Echos
 */

get_header();

$data = echos_service_get_variant_data( get_queried_object_id(), 'stands' );

get_template_part(
	'template-parts/service/layout',
	'stands',
	array(
		'service' => $data,
	)
);

get_footer();

