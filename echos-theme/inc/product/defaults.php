<?php
/**
 * Product templates default data.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default sections for single product pages.
 *
 * @return array
 */
function echos_product_default_single_sections() {
	$img_base      = get_template_directory_uri() . '/assets/img/inicio/';
	$default_image = $img_base . 'baner1.jpg';

	return array(
		'hero'        => array(
			'topbar_cta_url' => home_url( '/#contacto' ),
			'title'          => '',
			'description'    => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit.',
			'button_text'    => 'Cotizar',
			'button_url'     => home_url( '/#contacto' ),
			'image'          => $default_image,
			'image_alt'      => '',
		),
		'specs'       => array(
			'title'     => 'CARACTERISTICAS',
			'image'     => $default_image,
			'image_alt' => '',
			'caption'   => 'Describe aqui las caracteristicas principales del producto.',
			'items'     => array(
				array(
					'title' => 'Color pixel LED - RGB',
					'text'  => 'Detalle tecnico editable para el producto.',
				),
				array(
					'title' => 'Senal de control - HDMI - DVI',
					'text'  => 'Detalle tecnico editable para el producto.',
				),
				array(
					'title' => 'Angulo de vision 360 grados',
					'text'  => 'Detalle tecnico editable para el producto.',
				),
				array(
					'title' => 'Dimensiones por unidades 30 cm',
					'text'  => 'Detalle tecnico editable para el producto.',
				),
				array(
					'title' => 'Frecuencia de actualizacion 75Hz',
					'text'  => 'Detalle tecnico editable para el producto.',
				),
			),
		),
		'ficha'       => array(
			'image'       => $default_image,
			'image_alt'   => '',
			'title'       => 'FICHA TECNICA',
			'text'        => 'Agrega aqui una breve explicacion de la ficha tecnica del producto.',
			'button_text' => 'Descargar ficha tecnica',
			'button_url'  => '#',
		),
		'ideal'       => array(
			'title'      => 'IDEAL PARA',
			'paragraphs' => array(
				array(
					'text' => 'Describe para que tipo de eventos o proyectos es ideal este producto.',
				),
				array(
					'text' => 'Puedes agregar mas contexto de uso, recomendaciones y alcances.',
				),
			),
		),
		'gallery'     => array(
			'title' => 'GALERIA DE EXPERIENCIAS',
			'items' => array(
				array(
					'image' => $default_image,
					'alt'   => '',
				),
				array(
					'image' => $default_image,
					'alt'   => '',
				),
				array(
					'image' => $default_image,
					'alt'   => '',
				),
				array(
					'image' => $default_image,
					'alt'   => '',
				),
			),
		),
		'recommended' => array(
			'title'          => 'PRODUCTOS RECOMENDADOS',
			'items_limit'    => 4,
			'match_category' => 'yes',
		),
		'listing'     => array(
			'summary' => '',
		),
		'final_cta'   => array(
			'title'          => 'LISTO PARA COMENZAR?',
			'text'           => 'Todo gran proyecto comienza con una conversacion.',
			'primary_text'   => 'Conversemos ahora',
			'primary_url'    => 'https://wa.me/',
			'secondary_text' => 'echosperu.com.pe',
			'secondary_url'  => 'mailto:contacto@echosperu.com.pe',
		),
	);
}

/**
 * Returns default sections for products listing page.
 *
 * @return array
 */
function echos_product_default_listing_sections() {
	return array(
		'topbar_cta_url' => home_url( '/#contacto' ),
		'hero'           => array(
			'title'       => 'NUESTROS PRODUCTOS',
			'description' => 'Descubre nuestra linea completa de soluciones tecnologicas para eventos y espectaculos.',
		),
		'filters'        => array(
			'search_placeholder'    => 'Buscar producto...',
			'all_categories_label'  => 'Todas las categorias',
			'submit_label'          => 'Filtrar',
			'reset_label'           => 'Limpiar',
			'order_recent_label'    => 'Mas recientes',
			'order_old_label'       => 'Mas antiguos',
			'order_name_asc_label'  => 'Nombre (A-Z)',
			'order_name_desc_label' => 'Nombre (Z-A)',
		),
		'listing'        => array(
			'per_page'    => 12,
			'empty_title' => 'No encontramos productos',
			'empty_text'  => 'Prueba ajustando los filtros para ver mas resultados.',
		),
		'final_cta'      => array(
			'title'          => 'LISTO PARA COMENZAR?',
			'text'           => 'Todo gran proyecto comienza con una conversacion.',
			'primary_text'   => 'Conversemos ahora',
			'primary_url'    => 'https://wa.me/',
			'secondary_text' => 'echosperu.com.pe',
			'secondary_url'  => 'mailto:contacto@echosperu.com.pe',
		),
	);
}
