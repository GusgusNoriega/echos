<?php
/**
 * Product single content.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$product_id = isset( $args['product_id'] ) ? absint( $args['product_id'] ) : 0;

if ( ! $product_id || 'producto' !== get_post_type( $product_id ) ) {
	?>
	<section class="prod-ideal">
		<div class="container prod-ideal__inner">
			<h2 class="prod-ideal__title"><?php esc_html_e( 'No hay productos disponibles', 'echos' ); ?></h2>
		</div>
	</section>
	<?php
	return;
}

$data = echos_product_get_data( $product_id );

$img_base      = get_template_directory_uri() . '/assets/img/inicio/';
$default_image = $img_base . 'baner1.jpg';
$home          = esc_url( home_url( '/' ) );

$hero_title = trim( (string) ( $data['hero']['title'] ?? '' ) );
if ( '' === $hero_title ) {
	$hero_title = get_the_title( $product_id );
}

$hero_desc = trim( (string) ( $data['hero']['description'] ?? '' ) );
if ( '' === $hero_desc ) {
	$hero_desc = trim( (string) get_the_excerpt( $product_id ) );
}
if ( '' === $hero_desc ) {
	$hero_desc = wp_trim_words( wp_strip_all_tags( (string) get_post_field( 'post_content', $product_id ) ), 35, '...' );
}
$hero_video_embed = echos_product_build_youtube_embed_url( (string) ( $data['hero']['video'] ?? '' ) );

$hero_image = echos_product_resolve_image_url( ( $data['hero']['image'] ?? '' ), get_the_post_thumbnail_url( $product_id, 'full' ) );
$hero_image = echos_product_resolve_image_url( $hero_image, $default_image );
$hero_alt   = trim( (string) ( $data['hero']['image_alt'] ?? '' ) );
if ( '' === $hero_alt ) {
	$hero_alt = $hero_title;
}

$topbar_cta       = trim( (string) ( $data['hero']['topbar_cta_url'] ?? '' ) );
$topbar_cta       = '' !== $topbar_cta ? $topbar_cta : $home . '#contacto';
$hero_button_text = trim( (string) ( $data['hero']['button_text'] ?? '' ) );
$hero_button_url  = trim( (string) ( $data['hero']['button_url'] ?? '' ) );
$hero_button_url  = '' !== $hero_button_url ? $hero_button_url : $home . '#contacto';

$specs       = is_array( $data['specs'] ?? null ) ? $data['specs'] : array();
$specs_items = is_array( $specs['items'] ?? null ) ? $specs['items'] : array();

$ficha = is_array( $data['ficha'] ?? null ) ? $data['ficha'] : array();
$ideal = is_array( $data['ideal'] ?? null ) ? $data['ideal'] : array();

$gallery       = is_array( $data['gallery'] ?? null ) ? $data['gallery'] : array();
$gallery_items = is_array( $gallery['items'] ?? null ) ? $gallery['items'] : array();

$recommended      = is_array( $data['recommended'] ?? null ) ? $data['recommended'] : array();
$recommended_posts = echos_product_get_recommended_products( $product_id, $data );

$final_cta = is_array( $data['final_cta'] ?? null ) ? $data['final_cta'] : array();
?>

<header class="prod-header">
	<?php get_template_part( 'template-parts/topbar', null, array( 'modifier' => 'topbar--static', 'cta_url' => $topbar_cta ) ); ?>
</header>

<section class="prod-hero<?php echo '' !== $hero_video_embed ? ' has-video' : ''; ?>">
	<div class="prod-hero__bg" aria-hidden="true"></div>
	<?php if ( '' !== $hero_video_embed ) : ?>
		<div class="prod-hero__video" aria-hidden="true">
			<iframe
				src="<?php echo esc_url( $hero_video_embed ); ?>"
				title="<?php esc_attr_e( 'Video de fondo del producto', 'echos' ); ?>"
				loading="eager"
				allow="autoplay; encrypted-media; picture-in-picture"
				referrerpolicy="strict-origin-when-cross-origin"
				tabindex="-1"
			></iframe>
		</div>
		<div class="prod-hero__overlay" aria-hidden="true"></div>
	<?php endif; ?>
	<div class="container prod-hero__inner">
		<div class="prod-hero__copy">
			<h1 class="prod-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
			<p class="prod-hero__desc"><?php echo esc_html( $hero_desc ); ?></p>
			<a class="btn btn--orange" href="<?php echo esc_url( $hero_button_url ); ?>">
				<span><?php echo esc_html( '' !== $hero_button_text ? $hero_button_text : __( 'Cotizar', 'echos' ) ); ?></span>
				<span class="btn__icon" aria-hidden="true">&rarr;</span>
			</a>
		</div>
		<div class="prod-hero__media">
			<img src="<?php echo esc_url( $hero_image ); ?>" alt="<?php echo esc_attr( $hero_alt ); ?>" class="prod-hero__img" />
		</div>
	</div>
</section>

<section class="prod-specs" id="caracteristicas">
	<div class="container">
		<h2 class="prod-specs__title"><?php echo esc_html( (string) ( $specs['title'] ?? __( 'CARACTERISTICAS', 'echos' ) ) ); ?></h2>
		<div class="prod-specs__inner">
			<div class="prod-specs__content">
				<div class="prod-specs__gallery">
					<?php
					$specs_image = echos_product_resolve_image_url( ( $specs['image'] ?? '' ), $hero_image );
					$specs_image = echos_product_resolve_image_url( $specs_image, $default_image );
					$specs_alt   = trim( (string) ( $specs['image_alt'] ?? '' ) );
					$specs_alt   = '' !== $specs_alt ? $specs_alt : $hero_title;
					?>
					<img src="<?php echo esc_url( $specs_image ); ?>" alt="<?php echo esc_attr( $specs_alt ); ?>" class="prod-specs__img" />
					<?php if ( '' !== trim( (string) ( $specs['caption'] ?? '' ) ) ) : ?>
						<p class="prod-specs__caption"><?php echo esc_html( (string) $specs['caption'] ); ?></p>
					<?php endif; ?>
				</div>
				<div class="prod-specs__list">
					<?php foreach ( $specs_items as $item ) : ?>
						<?php if ( ! is_array( $item ) ) { continue; } ?>
						<div class="spec-card">
							<div class="spec-card__header">
								<span class="spec-card__dot"></span>
								<strong><?php echo esc_html( (string) ( $item['title'] ?? '' ) ); ?></strong>
							</div>
							<p class="spec-card__text"><?php echo esc_html( (string) ( $item['text'] ?? '' ) ); ?></p>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="prod-ficha" id="ficha">
	<div class="container">
		<div class="prod-ficha__card">
			<div class="prod-ficha__inner">
				<div class="prod-ficha__media">
					<div class="prod-ficha__device">
						<?php
						$ficha_image = echos_product_resolve_image_url( ( $ficha['image'] ?? '' ), $hero_image );
						$ficha_image = echos_product_resolve_image_url( $ficha_image, $default_image );
						$ficha_alt   = trim( (string) ( $ficha['image_alt'] ?? '' ) );
						$ficha_alt   = '' !== $ficha_alt ? $ficha_alt : $hero_title;
						?>
						<img src="<?php echo esc_url( $ficha_image ); ?>" alt="<?php echo esc_attr( $ficha_alt ); ?>" class="prod-ficha__img" />
					</div>
				</div>
				<div class="prod-ficha__content">
					<h2 class="prod-ficha__title"><?php echo esc_html( (string) ( $ficha['title'] ?? __( 'FICHA TECNICA', 'echos' ) ) ); ?></h2>
					<p class="prod-ficha__text"><?php echo esc_html( (string) ( $ficha['text'] ?? '' ) ); ?></p>
					<?php
					$ficha_button_url  = trim( (string) ( $ficha['button_url'] ?? '' ) );
					$ficha_button_text = trim( (string) ( $ficha['button_text'] ?? '' ) );
					?>
					<a class="btn-ficha-download" href="<?php echo esc_url( '' !== $ficha_button_url ? $ficha_button_url : '#' ); ?>" download>
						<span><?php echo esc_html( '' !== $ficha_button_text ? $ficha_button_text : __( 'Descargar ficha tecnica', 'echos' ) ); ?></span>
						<svg class="btn-ficha-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
							<polyline points="7 10 12 15 17 10"></polyline>
							<line x1="12" y1="15" x2="12" y2="3"></line>
						</svg>
					</a>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="prod-ideal" id="ideal">
	<div class="container prod-ideal__inner">
		<h2 class="prod-ideal__title"><?php echo esc_html( (string) ( $ideal['title'] ?? __( 'IDEAL PARA', 'echos' ) ) ); ?></h2>
		<div class="prod-ideal__content">
			<?php
			$ideal_paragraphs = is_array( $ideal['paragraphs'] ?? null ) ? $ideal['paragraphs'] : array();
			foreach ( $ideal_paragraphs as $paragraph ) :
				if ( ! is_array( $paragraph ) ) {
					continue;
				}
				$text = trim( (string) ( $paragraph['text'] ?? '' ) );
				if ( '' === $text ) {
					continue;
				}
				?>
				<p><?php echo esc_html( $text ); ?></p>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php
$gallery_chunks = array_chunk( $gallery_items, 2 );
if ( ! empty( $gallery_chunks ) ) :
	?>
	<section class="prod-gallery" id="galeria">
		<div class="container">
			<h2 class="prod-gallery__title"><?php echo esc_html( (string) ( $gallery['title'] ?? __( 'GALERIA DE EXPERIENCIAS', 'echos' ) ) ); ?></h2>
			<div class="prod-gallery__grid">
				<?php foreach ( $gallery_chunks as $row_index => $row_items ) : ?>
					<div class="prod-gallery__row">
						<?php foreach ( $row_items as $item_index => $item ) : ?>
							<?php
							if ( ! is_array( $item ) ) {
								continue;
							}

							$is_large = ( 0 === ( $row_index % 2 ) ) ? ( 0 === $item_index ) : ( 1 === $item_index );
							$size     = $is_large ? 'prod-gallery__item--lg' : 'prod-gallery__item--sm';

							$image = echos_product_resolve_image_url( ( $item['image'] ?? '' ), $default_image );
							$alt   = trim( (string) ( $item['alt'] ?? '' ) );
							$alt   = '' !== $alt ? $alt : $hero_title;
							?>
							<div class="prod-gallery__item <?php echo esc_attr( $size ); ?>">
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
							</div>
						<?php endforeach; ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $recommended_posts ) ) : ?>
	<section class="prod-recomendados" id="recomendados">
		<div class="container">
			<div class="prod-recomendados__header">
				<h2 class="prod-recomendados__title"><?php echo esc_html( (string) ( $recommended['title'] ?? __( 'PRODUCTOS RECOMENDADOS', 'echos' ) ) ); ?></h2>
				<div class="prod-recomendados__nav">
					<button class="prod-recomendados__arrow prod-recomendados__arrow--prev" aria-label="Anterior">&larr;</button>
					<button class="prod-recomendados__arrow prod-recomendados__arrow--next" aria-label="Siguiente">&rarr;</button>
				</div>
			</div>
			<div class="prod-recomendados__slider">
				<div class="prod-recomendados__track">
					<?php foreach ( $recommended_posts as $recommended_post ) : ?>
						<?php
						if ( ! $recommended_post instanceof WP_Post ) {
							continue;
						}
						$rec_id    = $recommended_post->ID;
						$rec_image = echos_product_resolve_image_url( get_the_post_thumbnail_url( $rec_id, 'full' ), $default_image );
						$rec_title = get_the_title( $rec_id );
						$rec_desc  = echos_product_get_card_summary( $rec_id, echos_product_get_data( $rec_id ) );
						?>
						<div class="prod-recomendados__card">
							<img src="<?php echo esc_url( $rec_image ); ?>" alt="<?php echo esc_attr( $rec_title ); ?>" class="prod-recomendados__img" />
							<div class="prod-recomendados__info">
								<div class="prod-recomendados__text">
									<strong><?php echo esc_html( $rec_title ); ?></strong>
									<p><?php echo esc_html( $rec_desc ); ?></p>
								</div>
								<a href="<?php echo esc_url( get_permalink( $rec_id ) ); ?>" class="prod-recomendados__btn" aria-label="<?php esc_attr_e( 'Ver producto', 'echos' ); ?>">+</a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php echos_product_render_final_cta( $final_cta, 'prod' ); ?>
