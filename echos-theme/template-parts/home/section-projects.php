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
			<a class="btn btn--orange" href="<?php echo esc_url( isset( $projects['cta_url'] ) ? $projects['cta_url'] : '#proyectos' ); ?>">
				<span><?php echo esc_html( isset( $projects['cta_text'] ) ? $projects['cta_text'] : '' ); ?></span>
				<span class="btn__icon" aria-hidden="true">
					<svg class="echos-arrow-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.25" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>
				</span>
			</a>
		</div>
	</div>
</section>
