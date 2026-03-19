<?php
/**
 * Template Name: Contacto
 * Description: Pagina de contacto de ECHOS con contenido administrable.
 *
 * @package Echos
 */

get_header();

$contact_data = echos_contact_get_data( get_the_ID() );
$home         = esc_url( home_url( '/' ) );

$tabs = isset( $contact_data['tabs'] ) && is_array( $contact_data['tabs'] ) ? array_values( $contact_data['tabs'] ) : array();
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
$initial_title = '' !== $default_copy['title'] ? $default_copy['title'] : ( isset( $contact_data['title'] ) ? (string) $contact_data['title'] : '' );
$initial_desc  = '' !== $default_copy['description'] ? $default_copy['description'] : ( isset( $contact_data['description'] ) ? (string) $contact_data['description'] : '' );
$social_links    = echos_contact_normalize_social_links( isset( $contact_data['social_links'] ) ? $contact_data['social_links'] : array() );
$background      = echos_contact_resolve_image_url( isset( $contact_data['background_image'] ) ? $contact_data['background_image'] : '' );
$left_image      = echos_contact_resolve_image_url( isset( $contact_data['left_image'] ) ? $contact_data['left_image'] : '' );
$left_image_alt  = isset( $contact_data['left_image_alt'] ) ? (string) $contact_data['left_image_alt'] : '';
$section_style   = '';

if ( '' !== $background ) {
	$section_style = '--echos-contact-bg-image:url(' . esc_url( $background ) . ');';
}

$primary_icon   = isset( $contact_data['action_primary_icon'] ) ? $contact_data['action_primary_icon'] : 'whatsapp';
$secondary_icon = isset( $contact_data['action_secondary_icon'] ) ? $contact_data['action_secondary_icon'] : 'email';
?>

<div class="contacto-page">
	<header class="contacto-header">
		<?php
		get_template_part(
			'template-parts/topbar',
			null,
			array(
				'modifier'  => 'topbar--static',
				'cta_url'   => isset( $contact_data['topbar_cta_url'] ) ? $contact_data['topbar_cta_url'] : $home . '#contacto',
				'cta_label' => isset( $contact_data['topbar_cta_label'] ) ? $contact_data['topbar_cta_label'] : __( 'Cotiza tu proyecto', 'echos' ),
			)
		);
		?>
	</header>

	<section class="contacto-section"<?php echo '' !== $section_style ? ' style="' . esc_attr( $section_style ) . '"' : ''; ?>>
		<div class="contacto-deco" aria-hidden="true"></div>

		<div class="container">
			<div class="contacto-grid">
				<div class="contacto-left">
					<h1 class="contacto-title js-contact-service-title" data-contact-service-title><?php echo wp_kses_post( echos_contact_multiline_text( $initial_title ) ); ?></h1>

					<p class="contacto-desc js-contact-service-description" data-contact-service-description>
						<?php echo esc_html( $initial_desc ); ?>
					</p>

					<?php if ( '' !== $left_image ) : ?>
						<figure class="contacto-left-media">
							<img src="<?php echo esc_url( $left_image ); ?>" alt="<?php echo esc_attr( $left_image_alt ); ?>" />
						</figure>
					<?php endif; ?>

					<div class="contacto-actions">
						<a class="contacto-pill" href="<?php echo esc_url( isset( $contact_data['action_primary_url'] ) ? $contact_data['action_primary_url'] : '#' ); ?>">
							<span><?php echo esc_html( isset( $contact_data['action_primary_text'] ) ? $contact_data['action_primary_text'] : '' ); ?></span>
							<span class="contacto-pill__icon" aria-hidden="true">
								<?php echo echos_contact_get_action_icon_markup( $primary_icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</a>

						<a class="contacto-pill" href="<?php echo esc_url( isset( $contact_data['action_secondary_url'] ) ? $contact_data['action_secondary_url'] : '#' ); ?>">
							<span><?php echo esc_html( isset( $contact_data['action_secondary_text'] ) ? $contact_data['action_secondary_text'] : '' ); ?></span>
							<span class="contacto-pill__icon" aria-hidden="true">
								<?php echo echos_contact_get_action_icon_markup( $secondary_icon ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</span>
						</a>
					</div>

					<div class="contacto-social">
						<div class="contacto-social-label"><?php echo esc_html( isset( $contact_data['social_label'] ) ? $contact_data['social_label'] : '' ); ?></div>
						<div class="contacto-social-icons" aria-label="<?php esc_attr_e( 'Redes sociales', 'echos' ); ?>">
							<?php foreach ( $social_links as $social ) : ?>
								<a href="<?php echo esc_url( isset( $social['url'] ) ? $social['url'] : '#' ); ?>" aria-label="<?php echo esc_attr( isset( $social['label'] ) ? $social['label'] : '' ); ?>">
									<?php echo echos_contact_get_social_icon_markup( isset( $social['platform'] ) ? $social['platform'] : 'custom' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>

				<div class="contacto-form-wrap">
					<div class="contacto-form-hint"><?php echo esc_html( isset( $contact_data['form_hint'] ) ? $contact_data['form_hint'] : '' ); ?></div>

					<div class="contacto-tabs" role="tablist" aria-label="<?php esc_attr_e( 'Servicios', 'echos' ); ?>">
						<?php foreach ( $tabs as $index => $tab ) : ?>
							<?php
							$label = isset( $tab['label'] ) ? (string) $tab['label'] : '';
							$value = ! empty( $tab['value'] ) ? (string) $tab['value'] : $label;
							$copy  = $resolve_service_copy( $value, $label );
							?>
							<button class="contacto-tab<?php echo 0 === $index ? ' is-active' : ''; ?>" type="button" data-service="<?php echo esc_attr( $value ); ?>" data-service-title="<?php echo esc_attr( $copy['title'] ); ?>" data-service-description="<?php echo esc_attr( $copy['description'] ); ?>"><?php echo esc_html( $label ); ?></button>
						<?php endforeach; ?>
					</div>

					<form id="contactoForm" class="contacto-form" novalidate>
						<input class="contacto-input" name="nombre" placeholder="<?php echo esc_attr( isset( $contact_data['placeholder_name'] ) ? $contact_data['placeholder_name'] : 'Nombre' ); ?>" autocomplete="name" required />
						<input class="contacto-input" name="empresa" placeholder="<?php echo esc_attr( isset( $contact_data['placeholder_company'] ) ? $contact_data['placeholder_company'] : 'Empresa' ); ?>" autocomplete="organization" required />
						<input class="contacto-input" name="email" placeholder="<?php echo esc_attr( isset( $contact_data['placeholder_email'] ) ? $contact_data['placeholder_email'] : 'Email corporativo' ); ?>" type="email" autocomplete="email" required />
						<input class="contacto-input" name="telefono" placeholder="<?php echo esc_attr( isset( $contact_data['placeholder_phone'] ) ? $contact_data['placeholder_phone'] : 'Telefono' ); ?>" type="tel" autocomplete="tel" />
						<textarea class="contacto-textarea" name="detalle" placeholder="<?php echo esc_attr( isset( $contact_data['placeholder_detail'] ) ? $contact_data['placeholder_detail'] : 'Cuentanos sobre tu evento y necesidades especificas' ); ?>"></textarea>

						<input type="hidden" name="form_source" value="contact_page" />
						<input type="hidden" name="servicio" id="contactoServicio" value="<?php echo esc_attr( $default_service ); ?>" />

						<div class="contacto-form__footer">
							<button class="contacto-submit" type="submit">
								<span><?php echo esc_html( isset( $contact_data['submit_text'] ) ? $contact_data['submit_text'] : '' ); ?></span>
								<span class="contacto-submit__icon" aria-hidden="true">&rarr;</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>
</div>

<?php
get_footer( 'contacto' );
