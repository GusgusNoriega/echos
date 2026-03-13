<?php
/**
 * Template Name: Proyecto Individual
 * Description: Vista dinamica de proyecto basada en el CPT "proyecto".
 *
 * @package Echos
 */

get_header();

$project_id = echos_project_resolve_requested_project_id();

get_template_part(
	'template-parts/project/single-content',
	null,
	array(
		'project_id' => $project_id,
		'is_preview' => true,
	)
);

get_footer();
