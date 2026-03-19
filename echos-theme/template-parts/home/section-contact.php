<?php
/**
 * Home section: Contact.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact = isset( $args['contact'] ) && is_array( $args['contact'] ) ? $args['contact'] : array();
$tabs    = isset( $contact['tabs'] ) && is_array( $contact['tabs'] ) ? array_values( $contact['tabs'] ) : array();

if ( empty( $tabs ) ) {
	$tabs[] = array(
		'label' => 'Infraestructura',
		'value' => 'Infraestructura',
	);
}

$default_service = ! empty( $tabs[0]['value'] ) ? (string) $tabs[0]['value'] : (string) $tabs[0]['label'];
$service_copy_defaults = array(
	'infraestructura'       => array(
		'title'       => 'Infraestructura para eventos',
		'description' => 'Disenamos y montamos estructuras seguras y funcionales para eventos corporativos y sociales.',
	),
	'iluminacion'           => array(
		'title'       => 'Iluminacion para experiencias',
		'description' => 'Creamos ambientes visuales con diseno de luz, equipos profesionales y operacion tecnica.',
	),
	'iluminacion-inteligente' => array(
		'title'       => 'Iluminacion inteligente',
		'description' => 'Programamos soluciones de iluminacion dinamica para reforzar el concepto de cada evento.',
	),
	'stands'                => array(
		'title'       => 'Stands para ferias',
		'description' => 'Desarrollamos stands funcionales y atractivos para destacar tu marca en ferias y exposiciones.',
	),
	'stands-para-ferias'    => array(
		'title'       => 'Stands para ferias',
		'description' => 'Desarrollamos stands funcionales y atractivos para destacar tu marca en ferias y exposiciones.',
	),
);

$resolve_service_copy = static function ( $value, $label ) use ( $service_copy_defaults ) {
	$source = '' !== trim( (string) $value ) ? (string) $value : (string) $label;
	$key    = sanitize_title( remove_accents( $source ) );

	if ( isset( $service_copy_defaults[ $key ] ) ) {
		return $service_copy_defaults[ $key ];
	}

	$label_clean = '' !== trim( (string) $label ) ? (string) $label : $source;

	return array(
		'title'       => sprintf( 'Servicio de %s', $label_clean ),
		'description' => sprintf( 'Comparte los detalles de tu requerimiento de %s y te ayudaremos a planificarlo.', $label_clean ),
	);
};

$default_label = isset( $tabs[0]['label'] ) ? (string) $tabs[0]['label'] : $default_service;
$default_copy  = $resolve_service_copy( $default_service, $default_label );
$initial_title = '' !== $default_copy['title'] ? $default_copy['title'] : ( isset( $contact['title'] ) ? (string) $contact['title'] : '' );
$initial_text  = '' !== $default_copy['description'] ? $default_copy['description'] : ( isset( $contact['text'] ) ? (string) $contact['text'] : '' );
?>
<section class="contact" id="contacto">
	<div class="container">
		<div class="contact__panel">
			<div class="contact__left">
				<h2 class="contact__title js-home-service-title" data-home-service-title><?php echo wp_kses_post( echos_home_multiline_text( $initial_title ) ); ?></h2>
				<p class="contact__text js-home-service-description" data-home-service-description><?php echo esc_html( $initial_text ); ?></p>

				<div class="contact__actions">
					<a class="pill pill--dark" href="<?php echo esc_url( isset( $contact['action_primary_url'] ) ? $contact['action_primary_url'] : '#' ); ?>">
						<span><?php echo esc_html( isset( $contact['action_primary_text'] ) ? $contact['action_primary_text'] : '' ); ?></span>
						<span class="pill__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 11.5a8.38 8.38 0 0 1-1 4 8.5 8.5 0 0 1-7.5 4.5A8.38 8.38 0 0 1 8 19L3 21l1.9-4.6A8.38 8.38 0 0 1 4 11.5 8.5 8.5 0 0 1 12.5 3a8.5 8.5 0 0 1 8.5 8.5Z"/></svg>
						</span>
					</a>
					<a class="pill pill--dark" href="<?php echo esc_url( isset( $contact['action_secondary_url'] ) ? $contact['action_secondary_url'] : '#' ); ?>">
						<span><?php echo esc_html( isset( $contact['action_secondary_text'] ) ? $contact['action_secondary_text'] : '' ); ?></span>
						<span class="pill__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16v14H4z"/><path d="m4 7 8 6 8-6"/></svg>
						</span>
					</a>
				</div>
			</div>

			<div class="contact__right">
				<div class="form-card">
					<div class="form-card__hint"><?php echo esc_html( isset( $contact['form_hint'] ) ? $contact['form_hint'] : '' ); ?></div>

					<div class="tabs" role="tablist" aria-label="Servicios">
						<?php foreach ( $tabs as $index => $tab ) : ?>
							<?php
							$label = isset( $tab['label'] ) ? $tab['label'] : '';
							$value = ! empty( $tab['value'] ) ? $tab['value'] : $label;
							$copy  = $resolve_service_copy( $value, $label );
							?>
							<button class="tab <?php echo 0 === $index ? 'is-active' : ''; ?>" type="button" data-service="<?php echo esc_attr( $value ); ?>" data-service-title="<?php echo esc_attr( $copy['title'] ); ?>" data-service-description="<?php echo esc_attr( $copy['description'] ); ?>"><?php echo esc_html( $label ); ?></button>
						<?php endforeach; ?>
					</div>

					<form id="quoteForm" class="form">
						<input class="input" name="nombre" placeholder="<?php echo esc_attr( isset( $contact['placeholder_name'] ) ? $contact['placeholder_name'] : 'Nombre' ); ?>" required />
						<input class="input" name="empresa" placeholder="<?php echo esc_attr( isset( $contact['placeholder_company'] ) ? $contact['placeholder_company'] : 'Empresa' ); ?>" required />
						<input class="input" name="email" placeholder="<?php echo esc_attr( isset( $contact['placeholder_email'] ) ? $contact['placeholder_email'] : 'Email corporativo' ); ?>" type="email" required />
						<input class="input" name="telefono" placeholder="<?php echo esc_attr( isset( $contact['placeholder_phone'] ) ? $contact['placeholder_phone'] : 'Telefono' ); ?>" />
						<textarea class="textarea" name="detalle" placeholder="<?php echo esc_attr( isset( $contact['placeholder_detail'] ) ? $contact['placeholder_detail'] : 'Cuentanos sobre su evento y necesidades especificas' ); ?>"></textarea>

						<input type="hidden" name="form_source" value="home_contact" />
						<input type="hidden" name="servicio" id="servicioElegido" value="<?php echo esc_attr( $default_service ); ?>" />

						<div class="form__footer">
							<button class="btn btn--orange btn--wide" type="submit">
								<span><?php echo esc_html( isset( $contact['submit_text'] ) ? $contact['submit_text'] : '' ); ?></span>
								<span class="btn__icon" aria-hidden="true">
									<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
								</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

