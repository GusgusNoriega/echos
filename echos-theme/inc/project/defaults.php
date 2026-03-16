<?php
/**
 * Project templates default data.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default sections for single project pages.
 *
 * @return array
 */
function echos_project_default_single_sections() {
	$img_base      = get_template_directory_uri() . '/assets/img/inicio/';
	$default_image = $img_base . 'baner1.jpg';

	return array(
		'hero'          => array(
			'topbar_cta_url' => home_url( '/#contacto' ),
			'title'          => '',
			'description'    => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla id massa eget massa.',
			'image'          => $default_image,
			'image_alt'      => '',
		),
		'detail'        => array(
			'tag'        => '',
			'date_label' => '',
			'title'      => '',
			'intro'      => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla id massa eget massa.',
			'highlight'  => 'Lorem ipsum dolor sit amet consectetur. Tristique gravida posuere leo venenatis nunc vel. Venenatis ipsum imperdiet augue adipiscing posuere.',
			'body'       => 'Netus condimentum neque mattis dui cursus volutpat. In et accumsan augue magna lacinia faucibus. Leo nibh tincidunt cras sit arcu tristique senectus.',
			'cta_text'   => 'Cotizar proyecto',
			'cta_url'    => home_url( '/#contacto' ),
		),
		'video'         => array(
			'video_id'      => '',
			'thumbnail'     => $default_image,
			'thumbnail_alt' => 'Video del proyecto',
		),
		'used_products' => array(
			'title'                => 'Productos utilizados',
			'selected_product_ids' => array(),
			'items'                => array(
				array(
					'name'     => 'Esferas kinetic',
					'features' => array(
						'Angulo de vision 360 grados.',
						'Dimensiones por unidades 30 cm.',
						'Frecuencia actualizacion 75Hz.',
					),
				),
				array(
					'name'     => 'Pantallas LED',
					'features' => array(
						'Color pixel LED RGB.',
						'Senal control HDMI - DVI - Madrix 5.',
						'Alto brillo para eventos indoor y outdoor.',
					),
				),
			),
		),
		'related'       => array(
			'title'          => 'Conoce otros proyectos',
			'items_limit'    => 4,
			'match_category' => 'yes',
		),
		'listing'       => array(
			'summary'     => '',
			'badge'       => '',
			'is_featured' => 'no',
		),
		'final_cta'     => array(
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
 * Returns default sections for projects listing page.
 *
 * @return array
 */
function echos_project_default_listing_sections() {
	return array(
		'topbar_cta_url' => home_url( '/#contacto' ),
		'hero'           => array(
			'background_image' => get_template_directory_uri() . '/assets/img/inicio/baner1.jpg',
			'title'            => 'NUESTROS PROYECTOS',
			'description'      => 'Conoce todos los proyectos que hemos realizado para eventos, marcas y experiencias en vivo.',
		),
		'featured'       => array(
			'title'       => 'LOS MAS DESTACADOS',
			'items_limit' => 6,
		),
		'listing'        => array(
			'title'            => 'ULTIMOS PROYECTOS',
			'all_filter_label' => 'Todos',
			'per_page'         => 9,
			'empty_title'      => 'No encontramos proyectos',
			'empty_text'       => 'Prueba con otro filtro para ver mas resultados.',
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
