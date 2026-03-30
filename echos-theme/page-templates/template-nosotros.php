<?php
/**
 * Template Name: Nosotros
 * Description: Pagina Nosotros de ECHOS con contenido administrable.
 *
 * @package Echos
 */

get_header();

$nosotros_data = echos_nosotros_get_data( get_the_ID() );
$home          = esc_url( home_url( '/' ) );

$hero_background = echos_nosotros_resolve_image_url( isset( $nosotros_data['hero_background_image'] ) ? $nosotros_data['hero_background_image'] : '' );
$hero_bg_style   = '';
if ( '' !== $hero_background ) {
	$hero_bg_style = 'background-image:url(' . esc_url( $hero_background ) . ');';
}

$team_image     = echos_nosotros_resolve_image_url( isset( $nosotros_data['team_image'] ) ? $nosotros_data['team_image'] : '' );
$team_image_alt = isset( $nosotros_data['team_image_alt'] ) ? (string) $nosotros_data['team_image_alt'] : '';

$description_paragraphs = isset( $nosotros_data['description_paragraphs'] ) && is_array( $nosotros_data['description_paragraphs'] ) ? array_values( $nosotros_data['description_paragraphs'] ) : array();
$history_slides         = isset( $nosotros_data['history_slides'] ) && is_array( $nosotros_data['history_slides'] ) ? array_values( $nosotros_data['history_slides'] ) : array();
$process_steps          = isset( $nosotros_data['process_steps'] ) && is_array( $nosotros_data['process_steps'] ) ? array_values( $nosotros_data['process_steps'] ) : array();
$clients                = isset( $nosotros_data['clients'] ) && is_array( $nosotros_data['clients'] ) ? array_values( $nosotros_data['clients'] ) : array();

if ( empty( $history_slides ) ) {
	$history_slides = echos_nosotros_default_data()['history_slides'];
}

$history_first = isset( $history_slides[0] ) && is_array( $history_slides[0] ) ? $history_slides[0] : array();
$history_bg_1  = isset( $history_slides[0]['year'] ) ? (string) $history_slides[0]['year'] : '';
$history_bg_2  = isset( $history_slides[1]['year'] ) ? (string) $history_slides[1]['year'] : '';
$history_bg_3  = isset( $history_slides[2]['year'] ) ? (string) $history_slides[2]['year'] : '';

$history_js_slides = array();
foreach ( $history_slides as $slide ) {
	if ( ! is_array( $slide ) ) {
		continue;
	}

	$history_js_slides[] = array(
		'year'        => isset( $slide['year'] ) ? (string) $slide['year'] : '',
		'title'       => isset( $slide['title'] ) ? (string) $slide['title'] : '',
		'description' => isset( $slide['description'] ) ? (string) $slide['description'] : '',
	);
}

$history_json = wp_json_encode( $history_js_slides );
if ( ! is_string( $history_json ) ) {
	$history_json = '[]';
}
?>

<header class="nosotros-header">
	<?php
	get_template_part(
		'template-parts/topbar',
		null,
		array(
			'modifier'  => 'topbar--static',
			'cta_url'   => isset( $nosotros_data['topbar_cta_url'] ) ? $nosotros_data['topbar_cta_url'] : $home . '#contacto',
			'cta_label' => isset( $nosotros_data['topbar_cta_label'] ) ? $nosotros_data['topbar_cta_label'] : __( 'Cotiza tu proyecto', 'echos' ),
		)
	);
	?>
</header>

<section class="nosotros-hero">
	<div class="nosotros-hero__bg"<?php echo '' !== $hero_bg_style ? ' style="' . esc_attr( $hero_bg_style ) . '"' : ''; ?> aria-hidden="true"></div>
	<div class="container nosotros-hero__inner">
		<h1 class="nosotros-hero__title">
			<?php echo esc_html( isset( $nosotros_data['hero_title_prefix'] ) ? $nosotros_data['hero_title_prefix'] : '' ); ?>
			<span class="nosotros-hero__accent"><?php echo esc_html( isset( $nosotros_data['hero_title_accent'] ) ? $nosotros_data['hero_title_accent'] : '' ); ?></span>
		</h1>
		<p class="nosotros-hero__desc">
			<?php echo esc_html( isset( $nosotros_data['hero_description'] ) ? $nosotros_data['hero_description'] : '' ); ?>
		</p>
	</div>
</section>

<section class="nosotros-imagen">
	<div class="container nosotros-imagen__inner">
		<div class="nosotros-imagen__wrap">
			<?php if ( '' !== $team_image ) : ?>
				<img class="nosotros-imagen__img" src="<?php echo esc_url( $team_image ); ?>" alt="<?php echo esc_attr( $team_image_alt ); ?>" loading="lazy" />
			<?php endif; ?>
		</div>
	</div>
</section>

<section class="nosotros-descripcion">
	<div class="container nosotros-descripcion__inner">
		<?php foreach ( $description_paragraphs as $paragraph ) : ?>
			<?php
			$text = isset( $paragraph['text'] ) ? (string) $paragraph['text'] : '';
			if ( '' === trim( $text ) ) {
				continue;
			}
			?>
			<p class="nosotros-descripcion__text"><?php echo esc_html( $text ); ?></p>
		<?php endforeach; ?>
	</div>
</section>

<section class="nosotros-historia" data-history-slides="<?php echo esc_attr( $history_json ); ?>">
	<div class="nosotros-historia__bg-years" aria-hidden="true">
		<span class="nosotros-historia__bg-year nosotros-historia__bg-year--prev"><?php echo esc_html( $history_bg_1 ); ?></span>
		<span class="nosotros-historia__bg-year nosotros-historia__bg-year--next"><?php echo esc_html( $history_bg_2 ); ?></span>
		<span class="nosotros-historia__bg-year nosotros-historia__bg-year--far"><?php echo esc_html( $history_bg_3 ); ?></span>
	</div>

	<div class="container nosotros-historia__inner">
		<h2 class="nosotros-historia__title"><?php echo esc_html( isset( $nosotros_data['history_title'] ) ? $nosotros_data['history_title'] : '' ); ?></h2>

		<div class="nosotros-historia__card">
			<span class="nosotros-historia__badge"><?php echo esc_html( isset( $history_first['year'] ) ? $history_first['year'] : '' ); ?></span>

			<div class="nosotros-historia__nav">
				<button class="nosotros-historia__arrow nosotros-historia__arrow--prev" aria-label="Anterior">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
				</button>
				<button class="nosotros-historia__arrow nosotros-historia__arrow--next" aria-label="Siguiente">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</button>
			</div>

			<div class="nosotros-historia__content">
				<h3 class="nosotros-historia__slide-title"><?php echo esc_html( isset( $history_first['title'] ) ? $history_first['title'] : '' ); ?></h3>
				<p class="nosotros-historia__slide-desc"><?php echo esc_html( isset( $history_first['description'] ) ? $history_first['description'] : '' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="nosotros-mv">
	<div class="container nosotros-mv__inner">
		<div class="nosotros-mv__grid">
			<div class="nosotros-mv__card">
				<div class="nosotros-mv__header">
					<h3 class="nosotros-mv__title"><?php echo esc_html( isset( $nosotros_data['mission_title'] ) ? $nosotros_data['mission_title'] : '' ); ?></h3>
					<div class="nosotros-mv__icon">
						<?php echo echos_nosotros_get_mv_icon_markup( isset( $nosotros_data['mission_icon'] ) ? $nosotros_data['mission_icon'] : 'ojo' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
				<p class="nosotros-mv__desc"><?php echo esc_html( isset( $nosotros_data['mission_description'] ) ? $nosotros_data['mission_description'] : '' ); ?></p>
			</div>

			<div class="nosotros-mv__card">
				<div class="nosotros-mv__header">
					<h3 class="nosotros-mv__title"><?php echo esc_html( isset( $nosotros_data['vision_title'] ) ? $nosotros_data['vision_title'] : '' ); ?></h3>
					<div class="nosotros-mv__icon">
						<?php echo echos_nosotros_get_mv_icon_markup( isset( $nosotros_data['vision_icon'] ) ? $nosotros_data['vision_icon'] : 'montana' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</div>
				<p class="nosotros-mv__desc"><?php echo esc_html( isset( $nosotros_data['vision_description'] ) ? $nosotros_data['vision_description'] : '' ); ?></p>
			</div>
		</div>
	</div>
</section>

<section class="nosotros-proceso">
	<div class="container nosotros-proceso__inner">
		<h2 class="nosotros-proceso__title"><?php echo esc_html( isset( $nosotros_data['process_title'] ) ? $nosotros_data['process_title'] : '' ); ?></h2>
		<p class="nosotros-proceso__desc"><?php echo esc_html( isset( $nosotros_data['process_description'] ) ? $nosotros_data['process_description'] : '' ); ?></p>

		<div class="nosotros-proceso__grid">
			<?php foreach ( $process_steps as $step ) : ?>
				<?php
				if ( ! is_array( $step ) ) {
					continue;
				}
				?>
				<div class="nosotros-proceso__card">
					<span class="nosotros-proceso__number"><?php echo esc_html( isset( $step['number'] ) ? $step['number'] : '' ); ?></span>
					<h3 class="nosotros-proceso__card-title"><?php echo esc_html( isset( $step['title'] ) ? $step['title'] : '' ); ?></h3>
					<p class="nosotros-proceso__card-desc"><?php echo esc_html( isset( $step['description'] ) ? $step['description'] : '' ); ?></p>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="nosotros-clientes">
	<div class="container">
		<div class="clients__row" aria-label="Logos de clientes">
			<?php foreach ( $clients as $client ) : ?>
				<?php
				if ( ! is_array( $client ) ) {
					continue;
				}

				$image_url  = echos_nosotros_resolve_image_url( isset( $client['image'] ) ? $client['image'] : '' );
				$logo_label = isset( $client['label'] ) ? (string) $client['label'] : '';
				$logo_alt   = isset( $client['alt'] ) ? (string) $client['alt'] : $logo_label;

				$raw_classes = isset( $client['logo_class'] ) ? (string) $client['logo_class'] : '';
				$classes     = array();
				if ( '' !== trim( $raw_classes ) ) {
					foreach ( preg_split( '/\s+/', trim( $raw_classes ) ) as $class_name ) {
						$classes[] = sanitize_html_class( $class_name );
					}
				}
				$classes = array_filter( $classes );
				?>

				<?php if ( '' !== $image_url ) : ?>
					<?php
					$img_classes = array( 'clients__logo' );
					foreach ( $classes as $class_name ) {
						if ( 0 === strpos( $class_name, 'clients__logo' ) ) {
							$img_classes[] = $class_name;
						}
					}
					?>
					<img class="<?php echo esc_attr( implode( ' ', array_filter( $img_classes ) ) ); ?>" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $logo_alt ); ?>" loading="lazy" style="max-height:50px;width:auto;object-fit:contain;" />
				<?php else : ?>
					<?php
					if ( empty( $classes ) ) {
						$classes[] = 'logo';
					}
					?>
					<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"><?php echo esc_html( $logo_label ); ?></div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="prod-cta">
	<div class="container">
		<div class="prod-cta__card">
			<h2 class="prod-cta__title"><?php echo esc_html( isset( $nosotros_data['cta_title'] ) ? $nosotros_data['cta_title'] : '' ); ?></h2>
			<p class="prod-cta__text"><?php echo esc_html( isset( $nosotros_data['cta_text'] ) ? $nosotros_data['cta_text'] : '' ); ?></p>
			<div class="prod-cta__buttons">
				<a class="btn-cta-dark" href="<?php echo esc_url( isset( $nosotros_data['cta_primary_url'] ) ? $nosotros_data['cta_primary_url'] : '#' ); ?>" target="_blank" rel="noopener">
					<span><?php echo esc_html( isset( $nosotros_data['cta_primary_text'] ) ? $nosotros_data['cta_primary_text'] : '' ); ?></span>
					<span class="btn-cta-dark__icon" aria-hidden="true">
						<?php echo echos_nosotros_get_action_icon_markup( isset( $nosotros_data['cta_primary_icon'] ) ? $nosotros_data['cta_primary_icon'] : 'whatsapp' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
				</a>
				<a class="btn-cta-dark" href="<?php echo esc_url( isset( $nosotros_data['cta_secondary_url'] ) ? $nosotros_data['cta_secondary_url'] : '#' ); ?>" target="_blank" rel="noopener">
					<span><?php echo esc_html( isset( $nosotros_data['cta_secondary_text'] ) ? $nosotros_data['cta_secondary_text'] : '' ); ?></span>
					<span class="btn-cta-dark__icon" aria-hidden="true">
						<?php echo echos_nosotros_get_action_icon_markup( isset( $nosotros_data['cta_secondary_icon'] ) ? $nosotros_data['cta_secondary_icon'] : 'email' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
					</span>
				</a>
			</div>
		</div>
	</div>
</section>

<main class="nosotros" id="nosotros">
	<div class="container">
		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				the_content();
			endwhile;
		endif;
		?>
	</div>
</main>

<?php
get_footer();





