<?php
/**
 * Template Name: Productos
 * Description: Listado administrable de productos ECHOS.
 *
 * @package Echos
 */

get_header();

$page_id = get_queried_object_id();
$data    = echos_product_get_listing_data( $page_id );
$hero_video_embed = echos_product_build_youtube_embed_url( (string) ( $data['hero']['video'] ?? '' ) );

$home       = esc_url( home_url( '/' ) );
$topbar_cta = trim( (string) ( $data['topbar_cta_url'] ?? '' ) );
$topbar_cta = '' !== $topbar_cta ? $topbar_cta : $home . '#contacto';

$current_category = isset( $_GET['categoria'] ) ? sanitize_title( wp_unslash( $_GET['categoria'] ) ) : '';
$current_search   = isset( $_GET['q'] ) ? sanitize_text_field( wp_unslash( $_GET['q'] ) ) : '';
$current_order    = isset( $_GET['orden'] ) ? sanitize_key( wp_unslash( $_GET['orden'] ) ) : 'recent';

$order_map = array(
	'recent'    => array(
		'orderby' => 'date',
		'order'   => 'DESC',
	),
	'old'       => array(
		'orderby' => 'date',
		'order'   => 'ASC',
	),
	'name_asc'  => array(
		'orderby' => 'title',
		'order'   => 'ASC',
	),
	'name_desc' => array(
		'orderby' => 'title',
		'order'   => 'DESC',
	),
);

if ( ! isset( $order_map[ $current_order ] ) ) {
	$current_order = 'recent';
}

$paged = max(
	1,
	absint( get_query_var( 'paged' ) ),
	absint( get_query_var( 'page' ) ),
	isset( $_GET['paged'] ) ? absint( wp_unslash( $_GET['paged'] ) ) : 0
);

$per_page = max( 1, absint( $data['listing']['per_page'] ?? 12 ) );

$query_args = array(
	'post_type'      => 'producto',
	'post_status'    => 'publish',
	'posts_per_page' => $per_page,
	'paged'          => $paged,
	'orderby'        => $order_map[ $current_order ]['orderby'],
	'order'          => $order_map[ $current_order ]['order'],
);

if ( '' !== $current_search ) {
	$query_args['s'] = $current_search;
}

if ( '' !== $current_category ) {
	$term = get_term_by( 'slug', $current_category, 'categoria_producto' );
	if ( $term instanceof WP_Term ) {
		$query_args['tax_query'] = array(
			array(
				'taxonomy' => 'categoria_producto',
				'field'    => 'slug',
				'terms'    => $current_category,
			),
		);
	} else {
		$current_category = '';
	}
}

$products_query = new WP_Query( $query_args );

$categories = get_terms(
	array(
		'taxonomy'   => 'categoria_producto',
		'hide_empty' => false,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);

$filters = is_array( $data['filters'] ?? null ) ? $data['filters'] : array();
?>

<header class="prod-header">
	<?php get_template_part( 'template-parts/topbar', null, array( 'modifier' => 'topbar--static', 'cta_url' => $topbar_cta ) ); ?>
</header>

<section class="productos-hero<?php echo '' !== $hero_video_embed ? ' has-video' : ''; ?>">
	<div class="productos-hero__bg" aria-hidden="true"></div>
	<?php if ( '' !== $hero_video_embed ) : ?>
		<div class="productos-hero__video" aria-hidden="true">
			<iframe
				src="<?php echo esc_url( $hero_video_embed ); ?>"
				title="<?php esc_attr_e( 'Video de fondo de productos', 'echos' ); ?>"
				loading="eager"
				allow="autoplay; encrypted-media; picture-in-picture"
				referrerpolicy="strict-origin-when-cross-origin"
				tabindex="-1"
			></iframe>
		</div>
	<?php endif; ?>
	<div class="productos-hero__overlay" aria-hidden="true"></div>
	<div class="container productos-hero__inner">
		<h1 class="productos-hero__title"><?php echo esc_html( (string) ( $data['hero']['title'] ?? __( 'NUESTROS PRODUCTOS', 'echos' ) ) ); ?></h1>
		<p class="productos-hero__desc"><?php echo esc_html( (string) ( $data['hero']['description'] ?? '' ) ); ?></p>
	</div>
</section>

<section class="productos-grid-section">
	<div class="container">
		<form class="productos-filters" method="get" action="<?php echo esc_url( get_permalink( $page_id ) ); ?>">
			<div class="productos-filters__row">
				<div class="productos-filters__field">
					<label for="productos-filter-categoria"><?php esc_html_e( 'Categoria', 'echos' ); ?></label>
					<select id="productos-filter-categoria" name="categoria">
						<option value=""><?php echo esc_html( (string) ( $filters['all_categories_label'] ?? __( 'Todas las categorias', 'echos' ) ) ); ?></option>
						<?php foreach ( $categories as $category ) : ?>
							<?php if ( ! $category instanceof WP_Term ) { continue; } ?>
							<option value="<?php echo esc_attr( $category->slug ); ?>" <?php selected( $current_category, $category->slug ); ?>>
								<?php echo esc_html( $category->name ); ?>
							</option>
						<?php endforeach; ?>
					</select>
				</div>

				<div class="productos-filters__field productos-filters__field--search">
					<label for="productos-filter-q"><?php esc_html_e( 'Buscar', 'echos' ); ?></label>
					<input id="productos-filter-q" type="search" name="q" value="<?php echo esc_attr( $current_search ); ?>" placeholder="<?php echo esc_attr( (string) ( $filters['search_placeholder'] ?? __( 'Buscar producto...', 'echos' ) ) ); ?>" />
				</div>

				<div class="productos-filters__field">
					<label for="productos-filter-order"><?php esc_html_e( 'Ordenar', 'echos' ); ?></label>
					<select id="productos-filter-order" name="orden">
						<option value="recent" <?php selected( $current_order, 'recent' ); ?>><?php echo esc_html( (string) ( $filters['order_recent_label'] ?? __( 'Mas recientes', 'echos' ) ) ); ?></option>
						<option value="old" <?php selected( $current_order, 'old' ); ?>><?php echo esc_html( (string) ( $filters['order_old_label'] ?? __( 'Mas antiguos', 'echos' ) ) ); ?></option>
						<option value="name_asc" <?php selected( $current_order, 'name_asc' ); ?>><?php echo esc_html( (string) ( $filters['order_name_asc_label'] ?? __( 'Nombre (A-Z)', 'echos' ) ) ); ?></option>
						<option value="name_desc" <?php selected( $current_order, 'name_desc' ); ?>><?php echo esc_html( (string) ( $filters['order_name_desc_label'] ?? __( 'Nombre (Z-A)', 'echos' ) ) ); ?></option>
					</select>
				</div>

				<div class="productos-filters__actions">
					<button type="submit" class="productos-filters__btn productos-filters__btn--submit"><?php echo esc_html( (string) ( $filters['submit_label'] ?? __( 'Filtrar', 'echos' ) ) ); ?></button>
					<a class="productos-filters__btn productos-filters__btn--reset" href="<?php echo esc_url( get_permalink( $page_id ) ); ?>"><?php echo esc_html( (string) ( $filters['reset_label'] ?? __( 'Limpiar', 'echos' ) ) ); ?></a>
				</div>
			</div>
		</form>

		<?php if ( $products_query->have_posts() ) : ?>
			<div class="productos-grid">
				<?php
				while ( $products_query->have_posts() ) :
					$products_query->the_post();

					$product_id = get_the_ID();
					$product    = echos_product_get_data( $product_id );
					$image      = echos_product_resolve_image_url( get_the_post_thumbnail_url( $product_id, 'full' ), get_template_directory_uri() . '/assets/img/inicio/baner1.jpg' );
					$title      = get_the_title( $product_id );
					$summary    = echos_product_get_card_summary( $product_id, $product );
					?>
					<a href="<?php the_permalink(); ?>" class="producto-card">
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="producto-card__img" />
						<div class="producto-card__info">
							<div class="producto-card__text">
								<strong><?php echo esc_html( $title ); ?></strong>
								<p><?php echo esc_html( $summary ); ?></p>
							</div>
							<span class="producto-card__btn" aria-hidden="true">+</span>
						</div>
					</a>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<div class="productos-empty">
				<h3 class="productos-empty__title"><?php echo esc_html( (string) ( $data['listing']['empty_title'] ?? __( 'No encontramos productos', 'echos' ) ) ); ?></h3>
				<p class="productos-empty__text"><?php echo esc_html( (string) ( $data['listing']['empty_text'] ?? '' ) ); ?></p>
			</div>
		<?php endif; ?>

		<?php
		$pagination_links = paginate_links(
			array(
				'base'      => str_replace( 999999999, '%#%', esc_url_raw( get_pagenum_link( 999999999 ) ) ),
				'format'    => '?paged=%#%',
				'current'   => $paged,
				'total'     => max( 1, (int) $products_query->max_num_pages ),
				'type'      => 'array',
				'prev_text' => '&larr;',
				'next_text' => '&rarr;',
				'add_args'  => array_filter(
					array(
						'categoria' => $current_category,
						'q'         => $current_search,
						'orden'     => $current_order,
					)
				),
			)
		);

		if ( is_array( $pagination_links ) && count( $pagination_links ) > 1 ) :
			?>
			<nav class="productos-pagination" aria-label="<?php esc_attr_e( 'Paginacion de productos', 'echos' ); ?>">
				<?php foreach ( $pagination_links as $page_link ) : ?>
					<span class="productos-pagination__item"><?php echo wp_kses_post( $page_link ); ?></span>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>

		<?php wp_reset_postdata(); ?>
	</div>
</section>

<?php echos_product_render_final_cta( (array) ( $data['final_cta'] ?? array() ), 'productos' ); ?>

<?php
get_footer();
