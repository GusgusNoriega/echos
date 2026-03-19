<?php
/**
 * Home template default data.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns default content for home sections.
 *
 * @return array
 */
function echos_home_default_data() {
	$img_base   = get_template_directory_uri() . '/assets/img/inicio/';
	$hero_image = $img_base . 'baner1.jpg';

	return array(
		'hero'     => array(
			'cta_url' => '#contacto',
			'slides'  => array(
				array(
					'image'       => $hero_image,
					'video'       => '',
					'accent'      => 'CREAMOS',
					'title'       => "ESPECTACULOS\nMEMORABLES",
					'description' => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus at. Nunc.',
				),
				array(
					'image'       => $hero_image,
					'video'       => '',
					'accent'      => 'DISENAMOS',
					'title'       => "EXPERIENCIAS\nA MEDIDA",
					'description' => 'Transformamos espacios en escenarios con identidad, luz y detalle tecnico.',
				),
				array(
					'image'       => $hero_image,
					'video'       => '',
					'accent'      => 'PRODUCIMOS',
					'title'       => "EVENTOS\nIMPACTANTES",
					'description' => 'Equipo, montaje y operacion para que todo salga perfecto de principio a fin.',
				),
			),
		),
		'clients'  => array(
			'title'    => 'NUESTROS CLIENTES',
			'subtitle' => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla.',
			'logos'    => array(
				array(
					'image'      => $img_base . 'bcp.png',
					'alt'        => 'BCP',
					'logo_class' => 'clients__logo--bcp',
				),
				array(
					'image'      => $img_base . 'ipsos1.png',
					'alt'        => 'Ipsos',
					'logo_class' => 'clients__logo--ipsos',
				),
				array(
					'image'      => $img_base . 'bcp.png',
					'alt'        => 'BCP',
					'logo_class' => 'clients__logo--bcp',
				),
				array(
					'image'      => $img_base . 'ipsos1.png',
					'alt'        => 'Ipsos',
					'logo_class' => 'clients__logo--ipsos',
				),
				array(
					'image'      => $img_base . 'bcp.png',
					'alt'        => 'BCP',
					'logo_class' => 'clients__logo--bcp',
				),
				array(
					'image'      => $img_base . 'bcp.png',
					'alt'        => 'BCP',
					'logo_class' => 'clients__logo--bcp',
				),
			),
		),
		'about'    => array(
			'title'       => 'QUIENES SOMOS?',
			'text'        => 'Somos una empresa de infraestructura para eventos, brindamos soluciones efectivas, creativas en diseno y estructuracion de eventos corporativos y sociales.',
			'button_text' => 'Conocenos',
			'button_url'  => '#conocenos',
			'image'       => $hero_image,
		),
		'projects' => array(
			'title'      => 'NUESTROS PROYECTOS',
			'subtitle'   => 'Mira como convertimos espacios en experiencias extraordinarias.',
			'cta_text'   => 'Ver todos los proyectos',
			'cta_url'    => '#proyectos',
			'cards'      => array(
				array(
					'image'   => $hero_image,
					'chip'    => 'Eventos',
					'title'   => 'BCP Lanzamiento',
					'date'    => '05 de junio, 2025',
					'url'     => '#',
					'variant' => 'blue',
				),
				array(
					'image'   => $hero_image,
					'chip'    => 'Eventos',
					'title'   => 'BCP Lanzamiento',
					'date'    => '05 de junio, 2025',
					'url'     => '#',
					'variant' => 'red',
				),
				array(
					'image'   => $hero_image,
					'chip'    => 'Entretenimiento',
					'title'   => 'Ecoferia Madre Tierra',
					'date'    => '05 de junio, 2025',
					'url'     => '#',
					'variant' => 'green',
				),
				array(
					'image'   => $hero_image,
					'chip'    => 'Eventos',
					'title'   => 'BCP Lanzamiento',
					'date'    => '05 de junio, 2025',
					'url'     => '#',
					'variant' => 'purple',
				),
				array(
					'image'   => $hero_image,
					'chip'    => 'Eventos',
					'title'   => 'BCP Lanzamiento',
					'date'    => '05 de junio, 2025',
					'url'     => '#',
					'variant' => 'blue',
				),
			),
		),
		'services' => array(
			'title'    => 'NUESTROS SERVICIOS',
			'subtitle' => 'Lorem ipsum dolor sit amet consectetur. Enim suspendisse eget viverra integer tortor morbi bi.',
			'cta_text' => 'Ver todos los servicios',
			'cta_url'  => '#servicios',
			'items'    => array(
				array(
					'image'   => $hero_image,
					'label'   => 'Infraestructura',
					'url'     => '#contacto',
					'variant' => 'stage',
				),
				array(
					'image'   => $hero_image,
					'label'   => 'Iluminacion inteligente',
					'url'     => '#contacto',
					'variant' => 'lights',
				),
				array(
					'image'   => $hero_image,
					'label'   => 'Stands para ferias',
					'url'     => '#contacto',
					'variant' => 'booth',
				),
			),
		),
		'contact'  => array(
			'title'                 => "CUENTANOS SOBRE\nTU PROYECTO",
			'text'                  => 'Unete a nosotros y haz que tu proxima activacion brille con proposito e impacto.',
			'action_primary_text'   => 'Conversemos ahora',
			'action_primary_url'    => '#',
			'action_secondary_text' => 'echosperu.com.pe',
			'action_secondary_url'  => 'mailto:contacto@echosperu.com.pe',
			'form_hint'             => 'Selecciona el servicio en el que estas interesado',
			'submit_text'           => 'Enviar mis datos',
			'placeholder_name'      => 'Nombre',
			'placeholder_company'   => 'Empresa',
			'placeholder_email'     => 'Email corporativo',
			'placeholder_phone'     => 'Telefono',
			'placeholder_detail'    => 'Cuentanos sobre su evento y necesidades especificas',
			'tabs'                  => array(
				array(
					'label' => 'Infraestructura',
					'value' => 'Infraestructura',
				),
				array(
					'label' => 'Iluminacion',
					'value' => 'Iluminacion',
				),
				array(
					'label' => 'Stands',
					'value' => 'Stands',
				),
			),
		),
	);
}
