<?php
/**
 * Template Name: Proyectos
 * Description: Listado administrable de proyectos ECHOS.
 *
 * @package Echos
 */

get_header();

$page_id = get_queried_object_id();
$data    = echos_project_get_listing_data( $page_id );

$home       = esc_url( home_url( '/' ) );
$topbar_cta = trim( (string) ( $data['topbar_cta_url'] ?? '' ) );
$topbar_cta = '' !== $topbar_cta ? $topbar_cta : $home . '#contacto';

$current_category = isset( $_GET['categoria'] ) ? sanitize_title( wp_unslash( $_GET['categoria'] ) ) : '';

$paged = max(
	1,
	absint( get_query_var( 'paged' ) ),
	absint( get_query_var( 'page' ) ),
	isset( $_GET['paged'] ) ? absint( wp_unslash( $_GET['paged'] ) ) : 0
);

$per_page = max( 1, absint( $data['listing']['per_page'] ?? 9 ) );

$query_args = array(
	'post_type'      => 'proyecto',
	'post_status'    => 'publish',
	'posts_per_page' => $per_page,
	'paged'          => $paged,
	'orderby'        => 'date',
	'order'          => 'DESC',
);

if ( '' !== $current_category ) {
	$term = get_term_by( 'slug', $current_category, 'categoria_proyecto' );
	if ( $term instanceof WP_Term ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'categoria_proyecto',
				'field'    => 'slug',
				'terms'    => $current_category,
			),
		);
	} else {
		$current_category = '';
	}
}

$projects_query = new WP_Query( $query_args );

$categories = get_terms(
	array(
		'taxonomy'   => 'categoria_proyecto',
		'hide_empty' => true,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);

$featured_limit = max( 1, absint( $data['featured']['items_limit'] ?? 6 ) );
$featured_posts = echos_project_get_featured_projects( $featured_limit );

$hero_bg_image = echos_project_resolve_image_url( ( $data['hero']['background_image'] ?? '' ), get_template_directory_uri() . '/assets/img/inicio/baner1.jpg' );
$hero_title    = (string) ( $data['hero']['title'] ?? __( 'NUESTROS PROYECTOS', 'echos' ) );
$hero_desc     = (string) ( $data['hero']['description'] ?? '' );

$featured_title = (string) ( $data['featured']['title'] ?? __( 'LOS MAS DESTACADOS', 'echos' ) );

$listing_title      = (string) ( $data['listing']['title'] ?? __( 'ULTIMOS PROYECTOS', 'echos' ) );
$all_filter_label   = (string) ( $data['listing']['all_filter_label'] ?? __( 'Todos', 'echos' ) );
$empty_title        = (string) ( $data['listing']['empty_title'] ?? __( 'No encontramos proyectos', 'echos' ) );
$empty_text         = (string) ( $data['listing']['empty_text'] ?? '' );
$default_image      = get_template_directory_uri() . '/assets/img/inicio/baner1.jpg';
$listing_base_url   = get_permalink( $page_id );
?>

<header class="proyectos-header">
	<?php get_template_part( 'template-parts/topbar', null, array( 'modifier' => 'topbar--static', 'cta_url' => $topbar_cta ) ); ?>
</header>

<section class="proyectos-hero">
	<div class="proyectos-hero__bg" aria-hidden="true" style="background-image:url('<?php echo esc_url( $hero_bg_image ); ?>')"></div>
	<div class="proyectos-hero__overlay" aria-hidden="true"></div>
	<div class="container proyectos-hero__inner">
		<h1 class="proyectos-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="proyectos-hero__desc"><?php echo esc_html( $hero_desc ); ?></p>
	</div>
</section>

<?php if ( ! empty( $featured_posts ) ) : ?>
	<section class="destacados">
		<div class="container">
			<div class="destacados__head">
				<h2 class="destacados__title"><?php echo esc_html( $featured_title ); ?></h2>
				<div class="destacados__arrows">
					<button class="destacados__arrow destacados__arrow--prev" type="button" aria-label="<?php esc_attr_e( 'Anterior', 'echos' ); ?>">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
					</button>
					<button class="destacados__arrow destacados__arrow--next" type="button" aria-label="<?php esc_attr_e( 'Siguiente', 'echos' ); ?>">
						<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
					</button>
				</div>
			</div>

			<div class="destacados__viewport">
				<div class="destacados__track">
					<?php foreach ( $featured_posts as $featured_post ) : ?>
						<?php
						if ( ! $featured_post instanceof WP_Post ) {
							continue;
						}

						$featured_id    = $featured_post->ID;
						$featured_image = echos_project_resolve_image_url( get_the_post_thumbnail_url( $featured_id, 'full' ), $default_image );
						$featured_title_item = get_the_title( $featured_id );
						$featured_date  = get_the_date( 'd \\d\\e F, Y', $featured_id );
						?>
						<div class="destacados__card">
							<div class="destacados__img" style="background-image:url('<?php echo esc_url( $featured_image ); ?>')"></div>
							<div class="destacados__info">
								<div class="destacados__info-text">
									<span class="destacados__name"><?php echo esc_html( $featured_title_item ); ?></span>
									<span class="destacados__date"><?php echo esc_html( $featured_date ); ?></span>
								</div>
								<a href="<?php echo esc_url( get_permalink( $featured_id ) ); ?>" class="destacados__link" aria-label="<?php esc_attr_e( 'Ver proyecto', 'echos' ); ?>">
									<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
								</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="destacados__dots"></div>
		</div>
	</section>
<?php endif; ?>

<section class="ultimos-proyectos" id="ultimos-proyectos">
	<div class="container">
		<h2 class="ultimos-proyectos__title"><?php echo esc_html( $listing_title ); ?></h2>

		<?php if ( ! empty( $categories ) ) : ?>
			<div class="ultimos-proyectos__filters">
				<a class="ultimos-proyectos__filter <?php echo '' === $current_category ? 'is-active' : ''; ?>" href="<?php echo esc_url( $listing_base_url ); ?>">
					<?php echo esc_html( $all_filter_label ); ?>
				</a>
				<?php foreach ( $categories as $category ) : ?>
					<?php if ( ! $category instanceof WP_Term ) { continue; } ?>
					<a class="ultimos-proyectos__filter <?php echo $current_category === $category->slug ? 'is-active' : ''; ?>" href="<?php echo esc_url( add_query_arg( 'categoria', $category->slug, $listing_base_url ) ); ?>">
						<?php echo esc_html( $category->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $projects_query->have_posts() ) : ?>
			<div class="ultimos-proyectos__grid">
				<?php
				while ( $projects_query->have_posts() ) :
					$projects_query->the_post();

					$project_id   = get_the_ID();
					$project_data = echos_project_get_data( $project_id );
					$image        = echos_project_resolve_image_url( get_the_post_thumbnail_url( $project_id, 'full' ), $default_image );
					$badge        = echos_project_get_card_badge( $project_id, $project_data );
					$title        = get_the_title( $project_id );
					$date         = get_the_date( 'd \\d\\e F, Y', $project_id );
					?>
					<article class="up-card">
						<div class="up-card__img" style="background-image:url('<?php echo esc_url( $image ); ?>')"></div>
						<span class="up-card__badge"><?php echo esc_html( $badge ); ?></span>
						<div class="up-card__info">
							<div class="up-card__info-text">
								<span class="up-card__name"><?php echo esc_html( $title ); ?></span>
								<span class="up-card__date"><?php echo esc_html( $date ); ?></span>
							</div>
							<a href="<?php the_permalink(); ?>" class="up-card__link" aria-label="<?php esc_attr_e( 'Ver proyecto', 'echos' ); ?>">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
							</a>
						</div>
					</article>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<div class="ultimos-proyectos__empty">
				<h3 class="ultimos-proyectos__empty-title"><?php echo esc_html( $empty_title ); ?></h3>
				<p class="ultimos-proyectos__empty-text"><?php echo esc_html( $empty_text ); ?></p>
			</div>
		<?php endif; ?>

		<?php
		$pagination_links = paginate_links(
			array(
				'base'      => str_replace( 999999999, '%#%', esc_url_raw( get_pagenum_link( 999999999 ) ) ),
				'format'    => '?paged=%#%',
				'current'   => $paged,
				'total'     => max( 1, (int) $projects_query->max_num_pages ),
				'type'      => 'array',
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'add_args'  => array_filter(
					array(
						'categoria' => $current_category,
					)
				),
			)
		);

		if ( is_array( $pagination_links ) && count( $pagination_links ) > 1 ) :
			?>
			<nav class="proyectos-pagination" aria-label="<?php esc_attr_e( 'Paginacion de proyectos', 'echos' ); ?>">
				<?php foreach ( $pagination_links as $page_link ) : ?>
					<span class="proyectos-pagination__item"><?php echo wp_kses_post( $page_link ); ?></span>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>

		<?php wp_reset_postdata(); ?>
	</div>
</section>

<?php echos_product_render_final_cta( (array) ( $data['final_cta'] ?? array() ), 'prod' ); ?>

<?php
get_footer();
