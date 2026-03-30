<?php
/**
 * Nosotros template default data.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Returns action icon options for CTA buttons.
 *
 * @return array
 */
function echos_nosotros_action_icon_options() {
	return array(
		'whatsapp' => 'WhatsApp',
		'email'    => 'Email',
		'arrow'    => 'Arrow',
	);
}

/**
 * Returns icon options for mision and vision cards.
 *
 * @return array
 */
function echos_nosotros_mv_icon_options() {
	return array(
		'ojo'     => 'Ojo (Mision)',
		'montana' => 'Montana (Vision)',
	);
}

/**
 * Returns default content for nosotros template.
 *
 * @return array
 */
function echos_nosotros_default_data() {
	$img_base = get_template_directory_uri() . '/assets/img/inicio/';

	return array(
		'topbar_cta_url'         => home_url( '/#contacto' ),
		'topbar_cta_label'       => 'Cotiza tu proyecto',
		'hero_background_image'  => $img_base . 'baner1.jpg',
		'hero_title_prefix'      => 'somos una empresa de',
		'hero_title_accent'      => 'infraestructura de eventos',
		'hero_description'       => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam.',
		'team_image'             => $img_base . 'baner1.jpg',
		'team_image_alt'         => 'Equipo ECHOS',
		'description_paragraphs' => array(
			array(
				'text' => 'Somos una empresa con mas de 15 anos de experiencia en el rubro. Partiendo desde soluciones estructurales arquitectonicas, sistema modular Octanorm para ferias y exposiciones, ahora iluminacion tecnologica led para eventos. Contamos con equipos profesionales para cubrir toda magnitud de eventos sociales y corporativos.',
			),
			array(
				'text' => 'Revolucionamos las formas de entretenimiento presentando diversas opciones que ofrecemos para que nuestros socios sean tendencia en el mercado.',
			),
		),
		'history_title'          => 'NUESTRA HISTORIA',
		'history_slides'         => array(
			array(
				'year'        => '2018',
				'title'       => 'Lanzamiento de ECHOS',
				'description' => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisi quis mauris viverra. Blandit vestibulum tempus lectus consequ.',
			),
			array(
				'year'        => '2019',
				'title'       => 'Expansion nacional',
				'description' => 'Lorem ipsum dolor sit amet consectetur. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation.',
			),
			array(
				'year'        => '2020',
				'title'       => 'Innovacion tecnologica',
				'description' => 'Lorem ipsum dolor sit amet consectetur. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur excepteur sint.',
			),
			array(
				'year'        => '2022',
				'title'       => 'Nuevos servicios',
				'description' => 'Lorem ipsum dolor sit amet consectetur. Excepteur sint occaecat cupidatat non proident sunt in culpa qui officia deserunt mollit anim id est laborum.',
			),
			array(
				'year'        => '2024',
				'title'       => 'Liderazgo en el mercado',
				'description' => 'Lorem ipsum dolor sit amet consectetur. Ut enim ad minima veniam quis nostrum exercitationem ullam corporis suscipit laboriosam nisi ut aliquid commodi.',
			),
		),
		'mission_title'          => 'MISION',
		'mission_icon'           => 'ojo',
		'mission_description'    => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas.',
		'vision_title'           => 'VISION',
		'vision_icon'            => 'montana',
		'vision_description'     => 'Lorem ipsum dolor sit amet consectetur. In donec id tortor sollicitudin varius gravida aenean sit. Quam nisl quis mauris viverra. Blandit vestibulum tempus lectus consequat auctor velit egestas.',
		'process_title'          => 'COMO TRABAJAMOS?',
		'process_description'    => 'Lorem ipsum dolor sit amet consectetur. Viverra amet semper sed quam lobortis lacus sit. Nulla id.',
		'process_steps'          => array(
			array(
				'number'      => '01',
				'title'       => 'Consultoria inicial',
				'description' => 'Analisis de necesidades y objetivos del evento.',
			),
			array(
				'number'      => '02',
				'title'       => 'Diseno y propuesta',
				'description' => 'Desarrollo de propuesta tecnica y presupuesto detallado.',
			),
			array(
				'number'      => '03',
				'title'       => 'Planificacion',
				'description' => 'Cronograma de instalacion y coordinacion logistica.',
			),
			array(
				'number'      => '04',
				'title'       => 'Implementacion',
				'description' => 'Instalacion, pruebas y puesta en marcha.',
			),
		),
		'clients'                => array(
			array(
				'image'      => '',
				'alt'        => 'BCP',
				'label'      => 'BCP',
				'logo_class' => 'logo logo--bcp',
			),
			array(
				'image'      => '',
				'alt'        => 'Ipsos',
				'label'      => 'Ipsos',
				'logo_class' => 'logo logo--ipsos',
			),
			array(
				'image'      => '',
				'alt'        => 'BCP',
				'label'      => 'BCP',
				'logo_class' => 'logo logo--bcp',
			),
			array(
				'image'      => '',
				'alt'        => 'Ipsos',
				'label'      => 'Ipsos',
				'logo_class' => 'logo logo--ipsos',
			),
			array(
				'image'      => '',
				'alt'        => 'BCP',
				'label'      => 'BCP',
				'logo_class' => 'logo logo--bcp',
			),
			array(
				'image'      => '',
				'alt'        => 'BCP',
				'label'      => 'BCP',
				'logo_class' => 'logo logo--bcp',
			),
		),
		'cta_title'              => 'LISTO PARA COMENZAR?',
		'cta_text'               => 'Todo gran proyecto comienza con una conversacion.',
		'cta_primary_text'       => 'Conversemos ahora',
		'cta_primary_url'        => 'https://wa.me/',
		'cta_primary_icon'       => 'whatsapp',
		'cta_secondary_text'     => 'contacto@echosperu.com.pe',
		'cta_secondary_url'      => 'mailto:contacto@echosperu.com.pe',
		'cta_secondary_icon'     => 'email',
	);
}


