<?php
/**
 * Single template for Proyecto CPT.
 *
 * @package Echos
 */

get_header();

get_template_part(
	'template-parts/project/single-content',
	null,
	array(
		'project_id' => get_queried_object_id(),
	)
);

get_footer();
