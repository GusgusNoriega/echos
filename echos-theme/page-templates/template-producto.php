<?php
/**
 * Template Name: Producto Individual
 * Description: Vista dinamica de producto basada en el CPT "producto".
 *
 * @package Echos
 */

get_header();

$product_id = echos_product_resolve_requested_product_id();

get_template_part(
	'template-parts/product/single-content',
	null,
	array(
		'product_id'  => $product_id,
		'is_preview'  => true,
	)
);

get_footer();
