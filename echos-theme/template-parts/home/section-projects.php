<?php
/**
 * Home section: Projects.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$projects = isset( $args['projects'] ) && is_array( $args['projects'] ) ? $args['projects'] : array();
$cards    = isset( $projects['cards'] ) && is_array( $projects['cards'] ) ? $projects['cards'] : array();
$variants = array( 'blue', 'red', 'green', 'purple' );

$default_image = get_template_directory_uri() . '/assets/img/inicio/baner1.jpg';
$cards_limit   = ! empty( $cards ) ? count( $cards ) : 5;
$cards_limit   = max( 1, min( 24, absint( $cards_limit ) ) );

$project_posts = get_posts(
	array(
		'post_type'      => 'proyecto',
		'post_status'    => 'publish',
		'posts_per_page' => $cards_limit,
		'orderby'        => 'date',
		'order'          => 'DESC',
	)
);

if ( ! empty( $project_posts ) ) {
	$dynamic_cards = array();

	foreach ( $project_posts as $index => $project_post ) {
		if ( ! $project_post instanceof WP_Post ) {
			continue;
		}

		$project_id   = $project_post->ID;
		$project_data = function_exists( 'echos_project_get_data' ) ? echos_project_get_data( $project_id ) : array();
		$image        = get_the_post_thumbnail_url( $project_id, 'full' );
		$chip         = function_exists( 'echos_project_get_card_badge' ) ? echos_project_get_card_badge( $project_id, $project_data ) : __( 'Proyecto', 'echos' );

		if ( '' === trim( (string) $image ) ) {
			$image = $default_image;
		}

		$dynamic_cards[] = array(
			'image'   => $image,
			'chip'    => $chip,
			'title'   => get_the_title( $project_id ),
			'date'    => get_the_date( 'd \\d\\e F, Y', $project_id ),
			'url'     => get_permalink( $project_id ),
			'variant' => $variants[ $index % count( $variants ) ],
		);
	}

	if ( ! empty( $dynamic_cards ) ) {
		$cards = $dynamic_cards;
	}
}

$cta_url = isset( $projects['cta_url'] ) ? trim( (string) $projects['cta_url'] ) : '';
if ( '' === $cta_url || '#proyectos' === $cta_url ) {
	$projects_page = get_posts(
		array(
			'post_type'      => 'page',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_key'       => '_wp_page_template',
			'meta_value'     => 'page-templates/template-proyectos.php',
		)
	);

	if ( ! empty( $projects_page ) ) {
		$cta_url = get_permalink( (int) $projects_page[0] );
	}
}

if ( '' === $cta_url ) {
	$cta_url = '#proyectos';
}
?>
<section class="projects" id="proyectos">
	<div class="container">
		<div class="projects__head">
			<div>
				<h2 class="section-title"><?php echo esc_html( isset( $projects['title'] ) ? $projects['title'] : '' ); ?></h2>
				<p class="section-sub"><?php echo esc_html( isset( $projects['subtitle'] ) ? $projects['subtitle'] : '' ); ?></p>
			</div>

			<div class="projects__arrows">
				<button class="icon-btn icon-btn--prev" type="button" id="projPrev" aria-label="Anterior">
					<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
				</button>
				<button class="icon-btn icon-btn--next" type="button" id="projNext" aria-label="Siguiente">
					<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
				</button>
			</div>
		</div>

		<div class="projects__rail" id="projectsRail" aria-label="Carrusel de proyectos">
			<?php foreach ( $cards as $card ) : ?>
				<?php
				$image   = echos_home_resolve_image_url( isset( $card['image'] ) ? $card['image'] : '' );
				$chip    = isset( $card['chip'] ) ? $card['chip'] : '';
				$title   = isset( $card['title'] ) ? $card['title'] : '';
				$date    = isset( $card['date'] ) ? $card['date'] : '';
				$url     = isset( $card['url'] ) ? $card['url'] : '';
				$variant = isset( $card['variant'] ) ? sanitize_key( $card['variant'] ) : 'blue';
				if ( ! in_array( $variant, $variants, true ) ) {
					$variant = 'blue';
				}
				?>
				<article class="proj-card">
					<div class="proj-card__media media media--<?php echo esc_attr( $variant ); ?>" style="--media-image: url('<?php echo esc_url( $image ); ?>');">
						<span class="chip"><?php echo esc_html( $chip ); ?></span>
					</div>
					<div class="proj-card__meta">
						<div>
							<div class="proj-card__title"><?php echo esc_html( $title ); ?></div>
							<div class="proj-card__date"><?php echo esc_html( $date ); ?></div>
						</div>
						<?php if ( '' !== trim( (string) $url ) ) : ?>
							<a class="proj-card__go" href="<?php echo esc_url( $url ); ?>" aria-label="Ver proyecto">
								<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
							</a>
						<?php else : ?>
							<button class="proj-card__go" type="button" aria-label="Ver proyecto">
								<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
							</button>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>

		<div class="projects__cta">
			<a class="btn btn--orange" href="<?php echo esc_url( $cta_url ); ?>">
				<span><?php echo esc_html( isset( $projects['cta_text'] ) ? $projects['cta_text'] : '' ); ?></span>
				<span class="btn__icon" aria-hidden="true">
					<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
				</span>
			</a>
		</div>
	</div>
</section>
