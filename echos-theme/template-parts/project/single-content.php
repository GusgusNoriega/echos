<?php
/**
 * Project single content.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$project_id = isset( $args['project_id'] ) ? absint( $args['project_id'] ) : 0;

if ( ! $project_id || 'proyecto' !== get_post_type( $project_id ) ) {
	?>
	<section class="proy-ind-detalle">
		<div class="container proy-ind-detalle__inner">
			<h2 class="proy-ind-detalle__title"><?php esc_html_e( 'No hay proyectos disponibles', 'echos' ); ?></h2>
		</div>
	</section>
	<?php
	return;
}

$data = echos_project_get_data( $project_id );

$img_base      = get_template_directory_uri() . '/assets/img/inicio/';
$default_image = $img_base . 'baner1.jpg';
$home          = esc_url( home_url( '/' ) );

$hero_title = trim( (string) ( $data['hero']['title'] ?? '' ) );
if ( '' === $hero_title ) {
	$hero_title = get_the_title( $project_id );
}

$hero_desc = trim( (string) ( $data['hero']['description'] ?? '' ) );
if ( '' === $hero_desc ) {
	$hero_desc = trim( (string) get_the_excerpt( $project_id ) );
}
if ( '' === $hero_desc ) {
	$hero_desc = wp_trim_words( wp_strip_all_tags( (string) get_post_field( 'post_content', $project_id ) ), 35, '...' );
}

$hero_image = echos_project_resolve_image_url( ( $data['hero']['image'] ?? '' ), get_the_post_thumbnail_url( $project_id, 'full' ) );
$hero_image = echos_project_resolve_image_url( $hero_image, $default_image );
$hero_alt   = trim( (string) ( $data['hero']['image_alt'] ?? '' ) );
if ( '' === $hero_alt ) {
	$hero_alt = $hero_title;
}

$topbar_cta = trim( (string) ( $data['hero']['topbar_cta_url'] ?? '' ) );
$topbar_cta = '' !== $topbar_cta ? $topbar_cta : $home . '#contacto';

$detail            = is_array( $data['detail'] ?? null ) ? $data['detail'] : array();
$detail_tag        = trim( (string) ( $detail['tag'] ?? '' ) );
$detail_date       = trim( (string) ( $detail['date_label'] ?? '' ) );
$detail_title      = trim( (string) ( $detail['title'] ?? '' ) );
$detail_intro      = trim( (string) ( $detail['intro'] ?? '' ) );
$detail_highlight  = trim( (string) ( $detail['highlight'] ?? '' ) );
$detail_body       = trim( (string) ( $detail['body'] ?? '' ) );
$detail_cta_text   = trim( (string) ( $detail['cta_text'] ?? '' ) );
$detail_cta_url    = trim( (string) ( $detail['cta_url'] ?? '' ) );
$detail_date_attr  = get_post_time( 'c', false, $project_id );
$detail_date_attr  = $detail_date_attr ? $detail_date_attr : '';

if ( '' === $detail_tag ) {
	$detail_tag = echos_project_get_card_badge( $project_id, $data );
}

if ( '' === $detail_date ) {
	$detail_date = get_the_date( 'd \\d\\e F, Y', $project_id );
}

if ( '' === $detail_title ) {
	$detail_title = $hero_title;
}

if ( '' === $detail_intro ) {
	$detail_intro = trim( (string) get_the_excerpt( $project_id ) );
}

if ( '' === $detail_body ) {
	$detail_body = wp_trim_words( wp_strip_all_tags( (string) get_post_field( 'post_content', $project_id ) ), 60, '...' );
}

if ( '' === $detail_cta_text ) {
	$detail_cta_text = __( 'Cotizar proyecto', 'echos' );
}

if ( '' === $detail_cta_url ) {
	$detail_cta_url = $home . '#contacto';
}

$video_data      = is_array( $data['video'] ?? null ) ? $data['video'] : array();
$video_id        = trim( (string) ( $video_data['video_id'] ?? '' ) );
$video_thumb     = echos_project_resolve_image_url( ( $video_data['thumbnail'] ?? '' ), $hero_image );
$video_thumb     = echos_project_resolve_image_url( $video_thumb, $default_image );
$video_thumb_alt = trim( (string) ( $video_data['thumbnail_alt'] ?? '' ) );
if ( '' === $video_thumb_alt ) {
	$video_thumb_alt = __( 'Video del proyecto', 'echos' );
}

$used_products       = is_array( $data['used_products'] ?? null ) ? $data['used_products'] : array();
$used_products_title = trim( (string) ( $used_products['title'] ?? '' ) );
$used_products_items = echos_project_get_used_products_items( $project_id, $data );
if ( '' === $used_products_title ) {
	$used_products_title = __( 'Productos utilizados', 'echos' );
}

$related_data  = is_array( $data['related'] ?? null ) ? $data['related'] : array();
$related_title = trim( (string) ( $related_data['title'] ?? '' ) );
if ( '' === $related_title ) {
	$related_title = __( 'Conoce otros proyectos', 'echos' );
}
$related_projects = echos_project_get_related_projects( $project_id, $data );

$final_cta = is_array( $data['final_cta'] ?? null ) ? $data['final_cta'] : array();
?>

<header class="proyecto-ind-header">
	<?php get_template_part( 'template-parts/topbar', null, array( 'modifier' => 'topbar--static', 'cta_url' => $topbar_cta ) ); ?>
</header>

<section class="proy-ind-hero">
	<div class="proy-ind-hero__bg" style="background-image:url('<?php echo esc_url( $hero_image ); ?>')" aria-hidden="true"></div>
	<div class="container proy-ind-hero__inner">
		<h1 class="proy-ind-hero__title"><?php echo esc_html( $hero_title ); ?></h1>
		<p class="proy-ind-hero__desc"><?php echo esc_html( $hero_desc ); ?></p>
	</div>
</section>

<section class="proy-ind-detalle">
	<div class="container proy-ind-detalle__inner">
		<div class="proy-ind-detalle__meta">
			<span class="proy-ind-detalle__tag"><?php echo esc_html( $detail_tag ); ?></span>
			<time class="proy-ind-detalle__date" datetime="<?php echo esc_attr( $detail_date_attr ); ?>"><?php echo esc_html( $detail_date ); ?></time>
		</div>

		<h2 class="proy-ind-detalle__title"><?php echo esc_html( $detail_title ); ?></h2>
		<hr class="proy-ind-detalle__sep" />

		<?php if ( '' !== $detail_intro ) : ?>
			<p class="proy-ind-detalle__text"><?php echo esc_html( $detail_intro ); ?></p>
		<?php endif; ?>

		<?php if ( '' !== $detail_highlight ) : ?>
			<blockquote class="proy-ind-detalle__highlight">
				<p><?php echo esc_html( $detail_highlight ); ?></p>
			</blockquote>
		<?php endif; ?>

		<?php if ( '' !== $detail_body ) : ?>
			<p class="proy-ind-detalle__text"><?php echo esc_html( $detail_body ); ?></p>
		<?php endif; ?>

		<div class="proy-ind-detalle__cta-wrap">
			<a class="proy-ind-detalle__cta" href="<?php echo esc_url( $detail_cta_url ); ?>">
				<span><?php echo esc_html( $detail_cta_text ); ?></span>
				<span class="proy-ind-detalle__cta-icon" aria-hidden="true">&rarr;</span>
			</a>
		</div>
	</div>
</section>

<?php if ( '' !== $video_id ) : ?>
	<section class="proy-ind-video">
		<div class="container proy-ind-video__inner">
			<div class="proy-ind-video__wrapper"
				data-video-id="<?php echo esc_attr( $video_id ); ?>"
				role="button"
				tabindex="0"
				aria-label="<?php esc_attr_e( 'Reproducir video del proyecto', 'echos' ); ?>">
				<img class="proy-ind-video__thumb" src="<?php echo esc_url( $video_thumb ); ?>" alt="<?php echo esc_attr( $video_thumb_alt ); ?>" loading="lazy" />
				<div class="proy-ind-video__overlay" aria-hidden="true"></div>
				<button class="proy-ind-video__play" type="button" aria-label="<?php esc_attr_e( 'Reproducir video', 'echos' ); ?>">
					<svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
						<circle cx="40" cy="40" r="39" fill="white"/>
						<polygon points="32,24 58,40 32,56" fill="#1a1a1a"/>
					</svg>
				</button>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $used_products_items ) ) : ?>
	<section class="proy-ind-productos">
		<div class="container proy-ind-productos__inner">
			<h2 class="proy-ind-productos__title"><?php echo esc_html( $used_products_title ); ?></h2>
			<div class="proy-ind-productos__grid">
				<?php foreach ( $used_products_items as $item ) : ?>
					<?php
					if ( ! is_array( $item ) ) {
						continue;
					}
					$item_name  = trim( (string) ( $item['name'] ?? '' ) );
					$item_url   = trim( (string) ( $item['url'] ?? '' ) );
					$item_image = echos_project_resolve_image_url( ( $item['image'] ?? '' ), $default_image );
					$item_alt   = trim( (string) ( $item['image_alt'] ?? '' ) );
					$features   = array();

					if ( '' === $item_name ) {
						$item_name = __( 'Producto', 'echos' );
					}

					if ( '' === $item_alt ) {
						$item_alt = $item_name;
					}

					if ( isset( $item['features'] ) && is_array( $item['features'] ) ) {
						foreach ( $item['features'] as $feature ) {
							if ( is_array( $feature ) ) {
								$feature = $feature['title'] ?? ( $feature['text'] ?? '' );
							}
							$feature_text = trim( (string) $feature );
							if ( '' !== $feature_text ) {
								$features[] = $feature_text;
							}
						}
					}

					if ( '' === $item_name && empty( $features ) ) {
						continue;
					}
					?>
					<article class="proy-ind-productos__item">
						<div class="proy-ind-productos__image-wrap">
							<img class="proy-ind-productos__image" src="<?php echo esc_url( $item_image ); ?>" alt="<?php echo esc_attr( $item_alt ); ?>" loading="lazy" />
							<span class="proy-ind-productos__image-overlay" aria-hidden="true"></span>
						</div>

						<div class="proy-ind-productos__card">
							<div class="proy-ind-productos__card-header">
								<span class="proy-ind-productos__card-name"><?php echo esc_html( $item_name ); ?></span>
								<?php if ( '' !== $item_url ) : ?>
									<a class="proy-ind-productos__card-link" href="<?php echo esc_url( $item_url ); ?>" aria-label="<?php esc_attr_e( 'Ver producto', 'echos' ); ?>">
										<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
											<line x1="7" y1="17" x2="17" y2="7"/>
											<polyline points="7 7 17 7 17 17"/>
										</svg>
									</a>
								<?php else : ?>
									<span class="proy-ind-productos__card-link" aria-hidden="true">
										<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
											<line x1="7" y1="17" x2="17" y2="7"/>
											<polyline points="7 7 17 7 17 17"/>
										</svg>
									</span>
								<?php endif; ?>
							</div>

							<?php if ( ! empty( $features ) ) : ?>
								<div class="proy-ind-productos__card-body">
									<h3 class="proy-ind-productos__card-subtitle"><?php esc_html_e( 'CARACTERISTICAS', 'echos' ); ?></h3>
									<ul class="proy-ind-productos__card-list">
										<?php foreach ( $features as $feature_text ) : ?>
											<li><?php echo esc_html( $feature_text ); ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( ! empty( $related_projects ) ) : ?>
	<section class="proy-ind-otros">
		<div class="container proy-ind-otros__inner">
			<h2 class="proy-ind-otros__title"><?php echo esc_html( $related_title ); ?></h2>

			<div class="proy-ind-otros__nav">
				<button class="proy-ind-otros__arrow proy-ind-otros__arrow--prev" type="button" aria-label="<?php esc_attr_e( 'Anterior', 'echos' ); ?>">
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<line x1="19" y1="12" x2="5" y2="12"/>
						<polyline points="12 19 5 12 12 5"/>
					</svg>
					<span><?php esc_html_e( 'Anterior', 'echos' ); ?></span>
				</button>
				<button class="proy-ind-otros__arrow proy-ind-otros__arrow--next" type="button" aria-label="<?php esc_attr_e( 'Siguiente', 'echos' ); ?>">
					<span><?php esc_html_e( 'Siguiente', 'echos' ); ?></span>
					<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
						<line x1="5" y1="12" x2="19" y2="12"/>
						<polyline points="12 5 19 12 12 19"/>
					</svg>
				</button>
			</div>

			<div class="proy-ind-otros__viewport">
				<div class="proy-ind-otros__track">
					<?php foreach ( $related_projects as $related_post ) : ?>
						<?php
						if ( ! $related_post instanceof WP_Post ) {
							continue;
						}

						$related_id    = $related_post->ID;
						$related_data  = echos_project_get_data( $related_id );
						$related_image = echos_project_resolve_image_url( get_the_post_thumbnail_url( $related_id, 'full' ), $default_image );
						$related_badge = echos_project_get_card_badge( $related_id, $related_data );
						$related_title_item = get_the_title( $related_id );
						$related_date  = get_the_date( 'd \\d\\e F, Y', $related_id );
						?>
						<a href="<?php echo esc_url( get_permalink( $related_id ) ); ?>" class="proy-ind-otros__card">
							<div class="proy-ind-otros__card-img-wrap">
								<img class="proy-ind-otros__card-img" src="<?php echo esc_url( $related_image ); ?>" alt="<?php echo esc_attr( $related_title_item ); ?>" loading="lazy" />
								<span class="proy-ind-otros__card-badge"><?php echo esc_html( $related_badge ); ?></span>
							</div>
							<div class="proy-ind-otros__card-info">
								<div class="proy-ind-otros__card-text">
									<span class="proy-ind-otros__card-name"><?php echo esc_html( $related_title_item ); ?></span>
									<span class="proy-ind-otros__card-date"><?php echo esc_html( $related_date ); ?></span>
								</div>
								<span class="proy-ind-otros__card-link" aria-hidden="true">
									<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
										<line x1="7" y1="17" x2="17" y2="7"/>
										<polyline points="7 7 17 7 17 17"/>
									</svg>
								</span>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php echos_product_render_final_cta( $final_cta, 'prod' ); ?>
