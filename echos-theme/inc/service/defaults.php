<?php
/**
 * Service templates default data.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default content for all service templates.
 *
 * Data is grouped by template variant so a single page can switch
 * between layouts without losing template-specific content.
 *
 * @return array
 */
function echos_service_default_data() {
	$img_base      = get_template_directory_uri() . '/assets/img/inicio/';
	$default_image = $img_base . 'baner1.jpg';

	$featured_cards = array(
		array(
			'name'  => 'BCP Lanzamiento',
			'date'  => '05 de junio, 2025',
			'badge' => 'Eventos',
			'image' => $default_image,
			'url'   => '#',
		),
		array(
			'name'  => 'BCP Lanzamiento',
			'date'  => '05 de junio, 2025',
			'badge' => 'Entretenimiento',
			'image' => $default_image,
			'url'   => '#',
		),
		array(
			'name'  => 'Ecoferia Madre Tierra',
			'date'  => '05 de junio, 2025',
			'badge' => 'Eventos',
			'image' => $default_image,
			'url'   => '#',
		),
		array(
			'name'  => 'Evento Corporativo',
			'date'  => '10 de julio, 2025',
			'badge' => 'Corporativo',
			'image' => $default_image,
			'url'   => '#',
		),
		array(
			'name'  => 'Festival Musical',
			'date'  => '20 de agosto, 2025',
			'badge' => 'Entretenimiento',
			'image' => $default_image,
			'url'   => '#',
		),
	);

	$products_six = array(
		array(
			'label' => 'Esfera Kinetic',
			'image' => $default_image,
			'alt'   => 'Esfera Kinetic',
			'url'   => '#',
			'icon'  => 'plus',
		),
		array(
			'label' => 'Esfera Kinetic',
			'image' => $default_image,
			'alt'   => 'Esfera Kinetic',
			'url'   => '#',
			'icon'  => 'external',
		),
		array(
			'label' => 'Esfera Kinetic',
			'image' => $default_image,
			'alt'   => 'Esfera Kinetic',
			'url'   => '#',
			'icon'  => 'external',
		),
		array(
			'label' => 'Esfera Kinetic',
			'image' => $default_image,
			'alt'   => 'Esfera Kinetic',
			'url'   => '#',
			'icon'  => 'external',
		),
		array(
			'label' => 'Esfera Kinetic',
			'image' => $default_image,
			'alt'   => 'Esfera Kinetic',
			'url'   => '#',
			'icon'  => 'external',
		),
		array(
			'label' => 'Esfera Kinetic',
			'image' => $default_image,
			'alt'   => 'Esfera Kinetic',
			'url'   => '#',
			'icon'  => 'external',
		),
	);

	$products_three = array_slice( $products_six, 0, 3 );

	$other_services = array(
		array(
			'title'       => 'ILUMINACION',
			'description' => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor s',
			'url'         => '#',
			'bg_variant'  => 'iluminacion',
		),
		array(
			'title'       => 'STANDS PARA FERIAS',
			'description' => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor s',
			'url'         => '#',
			'bg_variant'  => 'stands',
		),
	);

	$final_cta = array(
		'title'          => 'LISTO PARA COMENZAR?',
		'text'           => 'Todo gran proyecto comienza con una conversacion.',
		'primary_text'   => 'Conversemos ahora',
		'primary_url'    => 'https://wa.me/',
		'secondary_text' => 'echosperu.com.pe',
		'secondary_url'  => 'mailto:contacto@echosperu.com.pe',
	);

	return array(
		'infraestructura' => array(
			'hero'           => array(
				'background_image' => $default_image,
				'topbar_cta_url'   => home_url( '/#contacto' ),
				'title'            => 'INFRAESTRUCTURA',
				'description'      => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla id m',
				'button_text'      => 'Ver portafolio',
				'button_url'       => '#portafolio',
			),
			'systems'        => array(
				'rows' => array(
					array(
						'title'       => 'SISTEMA LOSBERGER',
						'paragraph_1' => 'El sistema Losberger ofrece soluciones de espacio tanto temporales como permanentes de primera clase, adaptandose a una amplia variedad de necesidades.',
						'paragraph_2' => 'Gracias a su diseno modular y alta calidad en materiales, este sistema es ideal para la realizacion de eventos, implementacion de soluciones empresariales, uso en espacios publicos, asi como en operaciones de proteccion civil y defensa.',
						'image'       => $default_image,
						'alt'         => 'Sistema Losberger',
						'reverse'     => 'no',
					),
					array(
						'title'       => 'SISTEMA TRUSS DE ALUMINIO',
						'paragraph_1' => 'El sistema de Truss de aluminio con acoplamiento conico CCS esta disenado para ofrecer un soporte de carga elevado gracias a su estructura robusta y ligera fabricada en aluminio de alta resistencia. Este sistema destaca por su gran versatilidad y facilidad de montaje, permitiendo una instalacion rapida y segura en una amplia variedad de configuraciones.',
						'paragraph_2' => 'Es ideal para adaptarse a diferentes tipos de escenarios, estructuras temporales, eventos en vivo y montajes tecnicos, brindando soluciones eficientes tanto en interiores como en exteriores.',
						'image'       => $default_image,
						'alt'         => 'Sistema Truss de Aluminio',
						'reverse'     => 'yes',
					),
				),
			),
			'products'       => array(
				'title'    => 'PRODUCTOS',
				'subtitle' => 'Equipamiento de ultima generacion y servicios integrales para eventos de cualquier escala.',
				'items'    => $products_six,
				'cta_text' => 'Cotizar servicio',
				'cta_url'  => '#contacto',
			),
			'featured'       => array(
				'title'    => 'PROYECTOS DESTACADOS',
				'subtitle' => 'Algunos de nuestros trabajos mas representativos en diferentes tipos de eventos.',
				'cards'    => $featured_cards,
				'cta_text' => 'Ver todos los proyectos',
				'cta_url'  => '#proyectos',
			),
			'certifications' => array(
				'title'    => 'CERTIFICACIONES Y RESPALDO',
				'subtitle' => 'Contamos con todas las certificaciones necesarias para garantizar la calidad y seguridad en nuestros servicios.',
				'cards'    => array(
					array(
						'title'       => 'Construccion tecnica',
						'description' => 'Lorem ipsum dolor sit amet consectetur. Nibh feugiat sit id sed.',
					),
					array(
						'title'       => 'Construccion tecnica',
						'description' => 'Lorem ipsum dolor sit amet consectetur. Nibh feugiat sit id sed.',
					),
				),
			),
			'other_services' => array(
				'title' => 'OTROS SERVICIOS QUE PODRIAN INTERESARTE',
				'items' => $other_services,
			),
			'final_cta'      => $final_cta,
		),
		'iluminacion'     => array(
			'hero'           => array(
				'background_image' => $default_image,
				'topbar_cta_url'   => home_url( '/#contacto' ),
				'title'            => 'ILUMINACION',
				'description'      => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla id m',
				'button_text'      => 'Ver portafolio',
				'button_url'       => '#portafolio',
			),
			'systems_text'   => array(
				'title'      => 'LOREM IPSUM DOLOR',
				'paragraphs' => array(
					array(
						'text' => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas. Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristi',
					),
					array(
						'text' => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas. Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristi',
					),
					array(
						'text' => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas. Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristi',
					),
				),
			),
			'products'       => array(
				'title'    => 'PRODUCTOS',
				'subtitle' => 'Equipamiento de ultima generacion y servicios integrales para eventos de cualquier escala.',
				'items'    => $products_six,
				'cta_text' => 'Cotizar servicio',
				'cta_url'  => '#contacto',
			),
			'additional'     => array(
				'title'       => 'SERVICIOS ADICIONALES',
				'subtitle'    => 'Complementamos nuestros servicio de iluminacion con soluciones energeticas confiables para garantizar el suministro electrico continuo en su evento.',
				'card_image'  => $default_image,
				'card_alt'    => 'Grupo Electrogeno',
				'card_title'  => 'GRUPO ELECTROGENO',
				'card_text'   => 'Generador de alta potencia para eventos de gran escala y requerimientos energeticos elevados',
				'button_text' => 'Mas informacion',
				'button_url'  => '#contacto',
			),
			'featured'       => array(
				'title'    => 'PROYECTOS DESTACADOS',
				'subtitle' => 'Algunos de nuestros trabajos mas representativos en diferentes tipos de eventos.',
				'cards'    => $featured_cards,
				'cta_text' => 'Ver todos los proyectos',
				'cta_url'  => '#proyectos',
			),
			'other_services' => array(
				'title' => 'OTROS SERVICIOS QUE PODRIAN INTERESARTE',
				'items' => $other_services,
			),
			'final_cta'      => $final_cta,
		),
		'stands'          => array(
			'hero'              => array(
				'background_image' => $default_image,
				'topbar_cta_url'   => home_url( '/#contacto' ),
				'title'            => 'STAND PARA FERIAS',
				'description'      => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla id m',
				'button_text'      => 'Ver portafolio',
				'button_url'       => '#portafolio',
			),
			'description'       => array(
				'title'      => 'LOREM IPSUM DOLOR',
				'paragraphs' => array(
					array(
						'text' => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas. Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristi',
					),
					array(
						'text' => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas. Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristi',
					),
					array(
						'text' => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas. Egestas pretium enim tellus nibh. Velit nibh lectus quis nec tellus. Enim pellentesque tristi',
					),
				),
			),
			'ficha'             => array(
				'image'       => $default_image,
				'alt'         => 'Ficha tecnica de producto terminado',
				'title'       => 'FICHA TECNICA',
				'text'        => 'Lorem ipsum dolor sit amet consectetur. Ipsum nisl aenean nibh ac et. Proin donec adipiscing magnis euismod. Felis eget egestas risus pharetra vel. A mattis elementum mi in. Dui dolor',
				'button_text' => 'Descargar ficha tecnica',
				'button_url'  => '#',
			),
			'products'          => array(
				'title'    => 'PRODUCTOS',
				'subtitle' => 'Equipamiento de ultima generacion y servicios integrales para eventos de cualquier escala.',
				'items'    => $products_three,
				'cta_text' => 'Cotizar servicio',
				'cta_url'  => '#contacto',
			),
			'featured'          => array(
				'title'    => 'PROYECTOS DESTACADOS',
				'subtitle' => 'Algunos de nuestros trabajos mas representativos en diferentes tipos de eventos.',
				'cards'    => $featured_cards,
				'cta_text' => 'Ver todos los proyectos',
				'cta_url'  => '#proyectos',
			),
			'additional_slider' => array(
				'title'    => 'SERVICIOS ADICIONALES',
				'subtitle' => 'Ofrecemos un servicio integral de diseno, fabricacion e instalacion de stands, enfocado en destacar la identidad de cada marca.',
				'items'    => array(
					array(
						'image'       => $default_image,
						'alt'         => 'PORTICO DE OCTANORM',
						'title'       => 'PORTICO DE OCTANORM',
						'text'        => 'Lorem ipsum dolor sit amet consectetur. Turpis etiam purus massa ultrices bibendum.',
						'button_text' => 'Mas informacion',
						'button_url'  => '#',
					),
					array(
						'image'       => $default_image,
						'alt'         => 'BRANDING PARA STANDS',
						'title'       => 'BRANDING PARA STANDS',
						'text'        => 'Lorem ipsum dolor sit amet consectetur. Turpis etiam purus massa ultrices bibendum.',
						'button_text' => 'Mas informacion',
						'button_url'  => '#',
					),
					array(
						'image'       => $default_image,
						'alt'         => 'SERVICIO ADICIONAL',
						'title'       => 'SERVICIO ADICIONAL',
						'text'        => 'Lorem ipsum dolor sit amet consectetur. Turpis etiam purus massa ultrices bibendum.',
						'button_text' => 'Mas informacion',
						'button_url'  => '#',
					),
					array(
						'image'       => $default_image,
						'alt'         => 'SERVICIO ADICIONAL',
						'title'       => 'SERVICIO ADICIONAL',
						'text'        => 'Lorem ipsum dolor sit amet consectetur. Turpis etiam purus massa ultrices bibendum.',
						'button_text' => 'Mas informacion',
						'button_url'  => '#',
					),
				),
			),
			'furniture'         => array(
				'title'    => 'MOBILIARIO EN ALQUILER PARA COMPLEMENTAR TU ESPACIO',
				'subtitle' => 'Te ofrecemos mobiliario extra para que tengas todo lo que necesitas el dia del evento. Descarga el brochure con el catalogo completo.',
				'items'    => array(
					array(
						'image' => $default_image,
						'alt'   => 'Counter curvo',
						'label' => 'Counter curvo',
					),
					array(
						'image' => $default_image,
						'alt'   => 'Rack para TV',
						'label' => 'Rack para TV',
					),
					array(
						'image' => $default_image,
						'alt'   => 'Podium',
						'label' => 'Podium',
					),
					array(
						'image' => $default_image,
						'alt'   => 'Mesa alta',
						'label' => 'Mesa alta',
					),
					array(
						'image' => $default_image,
						'alt'   => 'Mesa alta redonda',
						'label' => 'Mesa alta redonda',
					),
					array(
						'image' => $default_image,
						'alt'   => 'Silla lounge',
						'label' => 'Silla lounge',
					),
					array(
						'image' => $default_image,
						'alt'   => 'Barra iluminada',
						'label' => 'Barra iluminada',
					),
				),
				'cta_text' => 'Descargar brochure',
				'cta_url'  => '#',
			),
			'other_services'    => array(
				'title' => 'OTROS SERVICIOS QUE PODRIAN INTERESARTE',
				'items' => $other_services,
			),
			'final_cta'         => $final_cta,
		),
	);
}
