<?php
/**
 * Single template for Producto CPT.
 *
 * @package Echos
 */

get_header();

get_template_part(
	'template-parts/product/single-content',
	null,
	array(
		'product_id' => get_queried_object_id(),
	)
);

get_footer();
