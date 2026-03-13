<?php
/**
 * Single template for Servicio CPT.
 *
 * Uses the assigned template slug (if any) to render one of the
 * 3 service layouts. Falls back to infraestructura.
 *
 * @package Echos
 */

get_header();

$post_id      = get_queried_object_id();
$template     = get_page_template_slug( $post_id );
$template_map = array(
	'page-templates/template-servicios-infraestructura.php' => 'infraestructura',
	'page-templates/template-servicios-iluminacion.php'     => 'iluminacion',
	'page-templates/template-servicios-stands.php'          => 'stands',
);
$variant      = isset( $template_map[ $template ] ) ? $template_map[ $template ] : 'infraestructura';
$data         = echos_service_get_variant_data( $post_id, $variant );

get_template_part(
	'template-parts/service/layout',
	$variant,
	array(
		'service' => $data,
	)
);

get_footer();
