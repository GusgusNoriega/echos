<?php
/**
 * Shared render helpers for service templates.
 *
 * @package Echos
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders hero section.
 *
 * @param array $hero Hero data.
 * @return void
 */
function echos_service_render_hero( $hero ) {
	$home        = esc_url( home_url( '/' ) );
	$img_base    = get_template_directory_uri() . '/assets/img/inicio/';
	$fallback_bg = $img_base . 'baner1.jpg';
	$bg_image    = echos_service_resolve_image_url( isset( $hero['background_image'] ) ? $hero['background_image'] : '', $fallback_bg );
	$title       = isset( $hero['title'] ) ? $hero['title'] : '';
	$desc        = isset( $hero['description'] ) ? $hero['description'] : '';
	$button_text = isset( $hero['button_text'] ) ? $hero['button_text'] : '';
	$button_url  = isset( $hero['button_url'] ) ? $hero['button_url'] : '#portafolio';
	$topbar_cta  = isset( $hero['topbar_cta_url'] ) ? $hero['topbar_cta_url'] : $home . '#contacto';
	?>
	<section class="srv-hero">
		<div class="srv-hero__bg" aria-hidden="true" style="background-image:url('<?php echo esc_url( $bg_image ); ?>');"></div>
		<div class="srv-hero__overlay" aria-hidden="true"></div>

		<?php get_template_part( 'template-parts/topbar', null, array( 'modifier' => 'topbar--srv', 'cta_url' => $topbar_cta ) ); ?>

		<div class="srv-hero__content">
			<h1 class="srv-hero__title"><?php echo esc_html( $title ); ?></h1>
			<p class="srv-hero__desc"><?php echo esc_html( $desc ); ?></p>
			<a class="srv-hero__btn" href="<?php echo esc_url( $button_url ); ?>">
				<span><?php echo esc_html( $button_text ); ?></span>
				<span class="srv-hero__btn-icon" aria-hidden="true">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
						<path d="M12 5v14"/>
						<path d="M19 12l-7 7-7-7"/>
					</svg>
				</span>
			</a>
		</div>
	</section>
	<?php
}

/**
 * Renders infraestructura systems section.
 *
 * @param array $systems Systems data.
 * @return void
 */
function echos_service_render_systems_rows( $systems ) {
	$rows = isset( $systems['rows'] ) && is_array( $systems['rows'] ) ? $systems['rows'] : array();
	if ( empty( $rows ) ) {
		return;
	}

	$img_base  = get_template_directory_uri() . '/assets/img/inicio/';
	$fallback  = $img_base . 'baner1.jpg';
	$last_index = count( $rows ) - 1;
	?>
	<section class="srv-systems">
		<div class="srv-systems__inner">
			<?php foreach ( $rows as $index => $row ) : ?>
				<?php
				$image   = echos_service_resolve_image_url( isset( $row['image'] ) ? $row['image'] : '', $fallback );
				$title   = isset( $row['title'] ) ? $row['title'] : '';
				$text_1  = isset( $row['paragraph_1'] ) ? $row['paragraph_1'] : '';
				$text_2  = isset( $row['paragraph_2'] ) ? $row['paragraph_2'] : '';
				$alt     = isset( $row['alt'] ) ? $row['alt'] : $title;
				$reverse = isset( $row['reverse'] ) && 'yes' === sanitize_key( $row['reverse'] );
				$row_cls = $reverse ? 'srv-systems__row srv-systems__row--reverse' : 'srv-systems__row';
				?>
				<div class="<?php echo esc_attr( $row_cls ); ?>">
					<?php if ( $reverse ) : ?>
						<div class="srv-systems__img">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
						</div>
					<?php endif; ?>

					<div class="srv-systems__text">
						<h2 class="srv-systems__title"><?php echo esc_html( $title ); ?></h2>
						<p><?php echo esc_html( $text_1 ); ?></p>
						<p><?php echo esc_html( $text_2 ); ?></p>
					</div>

					<?php if ( ! $reverse ) : ?>
						<div class="srv-systems__img">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
						</div>
					<?php endif; ?>
				</div>

				<?php if ( $index < $last_index ) : ?>
					<hr class="srv-systems__divider" />
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/**
 * Renders text-only systems section (iluminacion).
 *
 * @param array $systems Systems data.
 * @return void
 */
function echos_service_render_systems_text( $systems ) {
	$paragraphs = isset( $systems['paragraphs'] ) && is_array( $systems['paragraphs'] ) ? $systems['paragraphs'] : array();
	?>
	<section class="srv-systems">
		<div class="srv-systems__inner srv-systems__inner--text-only">
			<h2 class="srv-systems__title srv-systems__title--centered"><?php echo esc_html( isset( $systems['title'] ) ? $systems['title'] : '' ); ?></h2>
			<hr class="srv-systems__divider" />

			<div class="srv-systems__paragraphs">
				<?php foreach ( $paragraphs as $paragraph ) : ?>
					<?php if ( ! is_array( $paragraph ) ) { continue; } ?>
					<p><?php echo esc_html( isset( $paragraph['text'] ) ? $paragraph['text'] : '' ); ?></p>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Renders stands description section.
 *
 * @param array $description Description data.
 * @return void
 */
function echos_service_render_description( $description ) {
	$paragraphs = isset( $description['paragraphs'] ) && is_array( $description['paragraphs'] ) ? $description['paragraphs'] : array();
	?>
	<section class="srv-description">
		<div class="srv-description__inner">
			<h2 class="srv-description__title"><?php echo esc_html( isset( $description['title'] ) ? $description['title'] : '' ); ?></h2>
			<?php foreach ( $paragraphs as $paragraph ) : ?>
				<?php if ( ! is_array( $paragraph ) ) { continue; } ?>
				<p class="srv-description__text"><?php echo esc_html( isset( $paragraph['text'] ) ? $paragraph['text'] : '' ); ?></p>
			<?php endforeach; ?>
		</div>
	</section>
	<?php
}

/**
 * Renders stands ficha section.
 *
 * @param array $ficha Ficha data.
 * @return void
 */
function echos_service_render_ficha( $ficha ) {
	$img_base = get_template_directory_uri() . '/assets/img/inicio/';
	$image    = echos_service_resolve_image_url( isset( $ficha['image'] ) ? $ficha['image'] : '', $img_base . 'baner1.jpg' );
	$alt      = isset( $ficha['alt'] ) ? $ficha['alt'] : '';
	?>
	<section class="srv-ficha">
		<div class="srv-ficha__inner">
			<div class="srv-ficha__card">
				<div class="srv-ficha__img-wrap">
					<div class="srv-ficha__tablet">
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
					</div>
				</div>
				<div class="srv-ficha__content">
					<h2 class="srv-ficha__title"><?php echo esc_html( isset( $ficha['title'] ) ? $ficha['title'] : '' ); ?></h2>
					<p class="srv-ficha__text"><?php echo esc_html( isset( $ficha['text'] ) ? $ficha['text'] : '' ); ?></p>
					<a class="srv-ficha__btn" href="<?php echo esc_url( isset( $ficha['button_url'] ) ? $ficha['button_url'] : '#' ); ?>" download>
						<span><?php echo esc_html( isset( $ficha['button_text'] ) ? $ficha['button_text'] : '' ); ?></span>
						<span class="srv-ficha__btn-icon" aria-hidden="true">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
								<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
								<polyline points="7 10 12 15 17 10"/>
								<line x1="12" y1="15" x2="12" y2="3"/>
							</svg>
						</span>
					</a>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Normalizes post IDs and optionally validates post type.
 *
 * @param mixed  $values    Raw values.
 * @param string $post_type Optional post type.
 * @return array
 */
function echos_service_normalize_post_ids( $values, $post_type = '' ) {
	$values = is_array( $values ) ? $values : array( $values );
	$ids    = array();

	foreach ( $values as $value ) {
		if ( ! is_scalar( $value ) ) {
			continue;
		}

		$id = absint( $value );
		if ( ! $id ) {
			continue;
		}

		if ( '' !== $post_type && $post_type !== get_post_type( $id ) ) {
			continue;
		}

		$ids[] = $id;
	}

	if ( empty( $ids ) ) {
		return array();
	}

	return array_values( array_unique( $ids ) );
}

/**
 * Resolves current service post ID.
 *
 * @param int $service_id Optional service ID.
 * @return int
 */
function echos_service_resolve_service_id( $service_id = 0 ) {
	$service_id = absint( $service_id );
	if ( $service_id ) {
		return $service_id;
	}

	return absint( get_queried_object_id() );
}

/**
 * Returns products from CPT for the current service.
 *
 * @param int   $service_id Service ID.
 * @param array $products   Products section data.
 * @return array
 */
function echos_service_get_products_from_cpt( $service_id, $products ) {
	$selected_ids = echos_service_normalize_post_ids(
		isset( $products['selected_product_ids'] ) ? $products['selected_product_ids'] : array(),
		'producto'
	);

	if ( ! empty( $selected_ids ) ) {
		$selected = get_posts(
			array(
				'post_type'      => 'producto',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'post__in'       => $selected_ids,
				'orderby'        => 'post__in',
			)
		);

		return is_array( $selected ) ? $selected : array();
	}

	$fallback_limit = isset( $products['items'] ) && is_array( $products['items'] ) ? count( $products['items'] ) : 0;
	if ( $fallback_limit < 1 ) {
		$fallback_limit = 6;
	}
	$fallback_limit = min( 12, max( 1, $fallback_limit ) );

	$args = array(
		'post_type'      => 'producto',
		'post_status'    => 'publish',
		'posts_per_page' => $fallback_limit,
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$service_terms  = echos_service_get_term_slugs( $service_id, 'categoria_servicio' );
	$matching_terms = echos_service_get_matching_term_ids_by_slug( $service_id, 'categoria_servicio', 'categoria_producto' );

	if ( ! empty( $service_terms ) && empty( $matching_terms ) ) {
		return array();
	}

	if ( ! empty( $matching_terms ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'categoria_producto',
				'field'    => 'term_id',
				'terms'    => $matching_terms,
			),
		);
	}

	$posts = get_posts( $args );
	return is_array( $posts ) ? $posts : array();
}

/**
 * Returns featured projects from CPT for a service.
 *
 * @param int $service_id Service ID.
 * @param int $limit      Max items.
 * @return array
 */
function echos_service_get_featured_projects_from_cpt( $service_id, $limit = 6 ) {
	$limit      = min( 12, max( 1, absint( $limit ) ) );
	$collected  = array();
	$collected_ids = array();
	$service_project_terms = echos_service_get_matching_term_ids_by_slug( $service_id, 'categoria_servicio', 'categoria_proyecto' );

	$query_steps = array(
		array(
			'featured' => true,
			'terms'    => $service_project_terms,
		),
		array(
			'featured' => true,
			'terms'    => array(),
		),
		array(
			'featured' => false,
			'terms'    => $service_project_terms,
		),
		array(
			'featured' => false,
			'terms'    => array(),
		),
	);

	foreach ( $query_steps as $step ) {
		$remaining = $limit - count( $collected );
		if ( $remaining <= 0 ) {
			break;
		}

		$args = array(
			'post_type'      => 'proyecto',
			'post_status'    => 'publish',
			'posts_per_page' => $remaining,
			'post__not_in'   => $collected_ids,
			'orderby'        => 'date',
			'order'          => 'DESC',
		);

		if ( ! empty( $step['featured'] ) ) {
			$args['meta_key']   = '_echos_project_is_featured';
			$args['meta_value'] = 'yes';
		}

		if ( ! empty( $step['terms'] ) ) {
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'categoria_proyecto',
					'field'    => 'term_id',
					'terms'    => $step['terms'],
				),
			);
		}

		$batch = get_posts( $args );
		if ( ! is_array( $batch ) || empty( $batch ) ) {
			continue;
		}

		foreach ( $batch as $project_post ) {
			if ( ! $project_post instanceof WP_Post ) {
				continue;
			}

			$project_id = (int) $project_post->ID;
			if ( in_array( $project_id, $collected_ids, true ) ) {
				continue;
			}

			$collected[]    = $project_post;
			$collected_ids[] = $project_id;

			if ( count( $collected ) >= $limit ) {
				break 2;
			}
		}
	}

	return $collected;
}

/**
 * Renders products section.
 *
 * @param array $products   Products data.
 * @param int   $service_id Current service ID.
 * @return void
 */
function echos_service_render_products( $products, $service_id = 0 ) {
	$img_base    = get_template_directory_uri() . '/assets/img/inicio/';
	$fallback    = $img_base . 'baner1.jpg';
	$service_id  = echos_service_resolve_service_id( $service_id );
	$manual_items = isset( $products['items'] ) && is_array( $products['items'] ) ? $products['items'] : array();
	$items       = array();

	$cpt_products = echos_service_get_products_from_cpt( $service_id, $products );
	if ( ! empty( $cpt_products ) ) {
		foreach ( $cpt_products as $product_post ) {
			if ( ! $product_post instanceof WP_Post ) {
				continue;
			}

			$product_id = (int) $product_post->ID;
			$image      = echos_service_resolve_image_url( get_the_post_thumbnail_url( $product_id, 'full' ), $fallback );
			$title      = get_the_title( $product_id );
			$thumb_id   = get_post_thumbnail_id( $product_id );
			$alt        = $thumb_id ? trim( (string) get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ) ) : '';

			if ( '' === $alt ) {
				$alt = $title;
			}

			$items[] = array(
				'image' => $image,
				'alt'   => $alt,
				'label' => $title,
				'url'   => get_permalink( $product_id ),
				'icon'  => 'external',
			);
		}
	}

	if ( empty( $items ) ) {
		$items = $manual_items;
	}
	?>
	<section class="srv-products">
		<div class="srv-products__deco srv-products__deco--tl" aria-hidden="true"></div>
		<div class="srv-products__deco srv-products__deco--tr" aria-hidden="true"></div>
		<div class="srv-products__deco srv-products__deco--bl" aria-hidden="true"></div>
		<div class="srv-products__deco srv-products__deco--br" aria-hidden="true"></div>

		<div class="srv-products__inner">
			<h2 class="srv-products__title"><?php echo esc_html( isset( $products['title'] ) ? $products['title'] : '' ); ?></h2>
			<p class="srv-products__subtitle"><?php echo esc_html( isset( $products['subtitle'] ) ? $products['subtitle'] : '' ); ?></p>

			<div class="srv-products__grid">
				<?php foreach ( $items as $item ) : ?>
					<?php
					if ( ! is_array( $item ) ) {
						continue;
					}

					$image = echos_service_resolve_image_url( isset( $item['image'] ) ? $item['image'] : '', $fallback );
					$alt   = isset( $item['alt'] ) ? $item['alt'] : ( isset( $item['label'] ) ? $item['label'] : '' );
					$label = isset( $item['label'] ) ? $item['label'] : '';
					$url   = isset( $item['url'] ) && '' !== trim( (string) $item['url'] ) ? $item['url'] : '#';
					$icon  = isset( $item['icon'] ) ? sanitize_key( $item['icon'] ) : 'external';
					if ( ! in_array( $icon, array( 'plus', 'external' ), true ) ) {
						$icon = 'external';
					}
					?>
					<a class="srv-products__card" href="<?php echo esc_url( $url ); ?>">
						<div class="srv-products__card-img">
							<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
						</div>
						<div class="srv-products__card-label">
							<span><?php echo esc_html( $label ); ?></span>
							<span class="srv-products__card-icon" aria-hidden="true">
								<?php if ( 'plus' === $icon ) : ?>
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
								<?php else : ?>
									<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
								<?php endif; ?>
							</span>
						</div>
					</a>
				<?php endforeach; ?>
			</div>

			<div class="srv-products__cta-wrap">
				<a class="srv-products__cta" href="<?php echo esc_url( isset( $products['cta_url'] ) ? $products['cta_url'] : '#contacto' ); ?>">
					<span><?php echo esc_html( isset( $products['cta_text'] ) ? $products['cta_text'] : '' ); ?></span>
					<span class="srv-products__cta-arrow" aria-hidden="true">&rarr;</span>
				</a>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Renders featured projects section.
 *
 * @param array $featured   Featured data.
 * @param int   $service_id Current service ID.
 * @return void
 */
function echos_service_render_featured( $featured, $service_id = 0 ) {
	$manual_cards = isset( $featured['cards'] ) && is_array( $featured['cards'] ) ? $featured['cards'] : array();
	$img_base     = get_template_directory_uri() . '/assets/img/inicio/';
	$fallback     = $img_base . 'baner1.jpg';
	$service_id   = echos_service_resolve_service_id( $service_id );
	$limit        = count( $manual_cards );
	$cards        = array();

	if ( $limit < 1 ) {
		$limit = 6;
	}

	$cpt_projects = echos_service_get_featured_projects_from_cpt( $service_id, $limit );
	if ( ! empty( $cpt_projects ) ) {
		foreach ( $cpt_projects as $project_post ) {
			if ( ! $project_post instanceof WP_Post ) {
				continue;
			}

			$project_id = (int) $project_post->ID;
			$data       = echos_project_get_data( $project_id );
			$cards[]    = array(
				'image' => echos_service_resolve_image_url( get_the_post_thumbnail_url( $project_id, 'full' ), $fallback ),
				'name'  => get_the_title( $project_id ),
				'date'  => get_the_date( 'd \\d\\e F, Y', $project_id ),
				'badge' => echos_project_get_card_badge( $project_id, $data ),
				'url'   => get_permalink( $project_id ),
			);
		}
	}

	if ( empty( $cards ) ) {
		$cards = $manual_cards;
	}
	?>
	<section class="srv-featured" id="portafolio">
		<div class="srv-featured__inner">
			<div class="srv-featured__header">
				<div class="srv-featured__header-text">
					<h2 class="srv-featured__title"><?php echo esc_html( isset( $featured['title'] ) ? $featured['title'] : '' ); ?></h2>
					<p class="srv-featured__subtitle"><?php echo esc_html( isset( $featured['subtitle'] ) ? $featured['subtitle'] : '' ); ?></p>
				</div>
				<div class="srv-featured__nav">
					<button class="srv-featured__arrow srv-featured__arrow--prev" aria-label="Anterior">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
					</button>
					<button class="srv-featured__arrow srv-featured__arrow--next" aria-label="Siguiente">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><polyline points="12 5 19 12 12 19"/></svg>
					</button>
				</div>
			</div>

			<div class="srv-featured__slider">
				<div class="srv-featured__track">
					<?php foreach ( $cards as $card ) : ?>
						<?php
						if ( ! is_array( $card ) ) {
							continue;
						}

						$image = echos_service_resolve_image_url( isset( $card['image'] ) ? $card['image'] : '', $fallback );
						$name  = isset( $card['name'] ) ? $card['name'] : '';
						$date  = isset( $card['date'] ) ? $card['date'] : '';
						$badge = isset( $card['badge'] ) ? $card['badge'] : '';
						$url   = isset( $card['url'] ) ? $card['url'] : '';
						?>
						<div class="srv-featured__card">
							<div class="srv-featured__card-img">
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $name ); ?>" />
								<?php if ( '' !== trim( $badge ) ) : ?>
									<span class="srv-featured__badge"><?php echo esc_html( $badge ); ?></span>
								<?php endif; ?>
							</div>
							<div class="srv-featured__card-info">
								<div class="srv-featured__card-text">
									<span class="srv-featured__card-name"><?php echo esc_html( $name ); ?></span>
									<span class="srv-featured__card-date"><?php echo esc_html( $date ); ?></span>
								</div>
								<?php if ( '' !== trim( $url ) ) : ?>
									<a class="srv-featured__card-link" href="<?php echo esc_url( $url ); ?>" aria-label="Ver proyecto">
										<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
									</a>
								<?php else : ?>
									<span class="srv-featured__card-link" aria-hidden="true">
										<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
									</span>
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="srv-featured__cta-wrap">
				<a class="srv-featured__cta" href="<?php echo esc_url( isset( $featured['cta_url'] ) ? $featured['cta_url'] : '#proyectos' ); ?>">
					<span><?php echo esc_html( isset( $featured['cta_text'] ) ? $featured['cta_text'] : '' ); ?></span>
					<span class="srv-featured__cta-arrow" aria-hidden="true">&rarr;</span>
				</a>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Renders iluminacion additional section.
 *
 * @param array $additional Additional section data.
 * @return void
 */
function echos_service_render_iluminacion_additional( $additional ) {
	$img_base = get_template_directory_uri() . '/assets/img/inicio/';
	$image    = echos_service_resolve_image_url( isset( $additional['card_image'] ) ? $additional['card_image'] : '', $img_base . 'baner1.jpg' );
	$alt      = isset( $additional['card_alt'] ) ? $additional['card_alt'] : '';
	?>
	<section class="srv-additional">
		<div class="srv-additional__inner">
			<h2 class="srv-additional__title"><?php echo esc_html( isset( $additional['title'] ) ? $additional['title'] : '' ); ?></h2>
			<p class="srv-additional__subtitle"><?php echo esc_html( isset( $additional['subtitle'] ) ? $additional['subtitle'] : '' ); ?></p>

			<div class="srv-additional__card">
				<div class="srv-additional__card-img">
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
				</div>
				<div class="srv-additional__card-body">
					<h3 class="srv-additional__card-title"><?php echo esc_html( isset( $additional['card_title'] ) ? $additional['card_title'] : '' ); ?></h3>
					<p class="srv-additional__card-desc"><?php echo esc_html( isset( $additional['card_text'] ) ? $additional['card_text'] : '' ); ?></p>
					<a class="srv-additional__card-btn" href="<?php echo esc_url( isset( $additional['button_url'] ) ? $additional['button_url'] : '#contacto' ); ?>"><?php echo esc_html( isset( $additional['button_text'] ) ? $additional['button_text'] : '' ); ?></a>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Renders infraestructura certifications section.
 *
 * @param array $certifications Certifications data.
 * @return void
 */
function echos_service_render_certifications( $certifications ) {
	$cards = isset( $certifications['cards'] ) && is_array( $certifications['cards'] ) ? $certifications['cards'] : array();
	?>
	<section class="srv-certifications">
		<div class="srv-certifications__inner">
			<h2 class="srv-certifications__title"><?php echo esc_html( isset( $certifications['title'] ) ? $certifications['title'] : '' ); ?></h2>
			<p class="srv-certifications__subtitle"><?php echo esc_html( isset( $certifications['subtitle'] ) ? $certifications['subtitle'] : '' ); ?></p>

			<div class="srv-certifications__cards">
				<?php foreach ( $cards as $card ) : ?>
					<?php if ( ! is_array( $card ) ) { continue; } ?>
					<div class="srv-certifications__card">
						<div class="srv-certifications__card-header">
							<span class="srv-certifications__card-icon" aria-hidden="true">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ff5c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
									<path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
									<path d="M9 12l2 2 4-4"/>
								</svg>
							</span>
							<h3 class="srv-certifications__card-title"><?php echo esc_html( isset( $card['title'] ) ? $card['title'] : '' ); ?></h3>
						</div>
						<p class="srv-certifications__card-desc"><?php echo esc_html( isset( $card['description'] ) ? $card['description'] : '' ); ?></p>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Renders stands additional slider section.
 *
 * @param array $section Section data.
 * @return void
 */
function echos_service_render_stands_additional_slider( $section ) {
	$items    = isset( $section['items'] ) && is_array( $section['items'] ) ? $section['items'] : array();
	$img_base = get_template_directory_uri() . '/assets/img/inicio/';
	$fallback = $img_base . 'baner1.jpg';
	?>
	<section class="srv-additional">
		<div class="srv-additional__inner">
			<h2 class="srv-additional__title"><?php echo esc_html( isset( $section['title'] ) ? $section['title'] : '' ); ?></h2>
			<p class="srv-additional__subtitle"><?php echo esc_html( isset( $section['subtitle'] ) ? $section['subtitle'] : '' ); ?></p>

			<div class="srv-additional__slider">
				<div class="srv-additional__track">
					<?php foreach ( $items as $item ) : ?>
						<?php
						if ( ! is_array( $item ) ) {
							continue;
						}

						$image = echos_service_resolve_image_url( isset( $item['image'] ) ? $item['image'] : '', $fallback );
						$alt   = isset( $item['alt'] ) ? $item['alt'] : ( isset( $item['title'] ) ? $item['title'] : '' );
						?>
						<div class="srv-additional__card">
							<div class="srv-additional__card-img">
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
							</div>
							<div class="srv-additional__card-content">
								<h3 class="srv-additional__card-title"><?php echo esc_html( isset( $item['title'] ) ? $item['title'] : '' ); ?></h3>
								<p class="srv-additional__card-text"><?php echo esc_html( isset( $item['text'] ) ? $item['text'] : '' ); ?></p>
								<a class="srv-additional__card-btn" href="<?php echo esc_url( isset( $item['button_url'] ) ? $item['button_url'] : '#' ); ?>"><?php echo esc_html( isset( $item['button_text'] ) ? $item['button_text'] : '' ); ?></a>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="srv-additional__nav">
				<button class="srv-additional__arrow srv-additional__arrow--prev" aria-label="Anterior">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5"/><polyline points="12 19 5 12 12 5"/></svg>
				</button>
				<div class="srv-additional__dots"></div>
				<button class="srv-additional__arrow srv-additional__arrow--next" aria-label="Siguiente">
					<svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><polyline points="12 5 19 12 12 19"/></svg>
				</button>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Renders stands furniture section.
 *
 * @param array $furniture Furniture data.
 * @return void
 */
function echos_service_render_furniture( $furniture ) {
	$items    = isset( $furniture['items'] ) && is_array( $furniture['items'] ) ? $furniture['items'] : array();
	$img_base = get_template_directory_uri() . '/assets/img/inicio/';
	$fallback = $img_base . 'baner1.jpg';
	?>
	<section class="srv-furniture">
		<div class="srv-furniture__inner">
			<h2 class="srv-furniture__title"><?php echo esc_html( isset( $furniture['title'] ) ? $furniture['title'] : '' ); ?></h2>
			<p class="srv-furniture__subtitle"><?php echo esc_html( isset( $furniture['subtitle'] ) ? $furniture['subtitle'] : '' ); ?></p>

			<div class="srv-furniture__slider">
				<div class="srv-furniture__track">
					<?php foreach ( $items as $item ) : ?>
						<?php
						if ( ! is_array( $item ) ) {
							continue;
						}

						$image = echos_service_resolve_image_url( isset( $item['image'] ) ? $item['image'] : '', $fallback );
						$alt   = isset( $item['alt'] ) ? $item['alt'] : ( isset( $item['label'] ) ? $item['label'] : '' );
						?>
						<div class="srv-furniture__card">
							<div class="srv-furniture__card-img">
								<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
							</div>
							<div class="srv-furniture__card-label"><?php echo esc_html( isset( $item['label'] ) ? $item['label'] : '' ); ?></div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="srv-furniture__cta-wrap">
				<a class="srv-furniture__cta" href="<?php echo esc_url( isset( $furniture['cta_url'] ) ? $furniture['cta_url'] : '#' ); ?>" download>
					<span><?php echo esc_html( isset( $furniture['cta_text'] ) ? $furniture['cta_text'] : '' ); ?></span>
					<span class="srv-furniture__cta-icon" aria-hidden="true">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
							<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
							<polyline points="7 10 12 15 17 10"/>
							<line x1="12" y1="15" x2="12" y2="3"/>
						</svg>
					</span>
				</a>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Returns related service posts for "other services" section.
 *
 * @param int $service_id Current service ID.
 * @param int $limit      Max items.
 * @return array
 */
function echos_service_get_other_services_from_cpt( $service_id, $limit = 2 ) {
	$service_id = absint( $service_id );
	$limit      = max( 1, min( 8, absint( $limit ) ) );
	$items      = array();
	$exclude    = array( $service_id );

	$term_ids = wp_get_post_terms(
		$service_id,
		'categoria_servicio',
		array(
			'fields' => 'ids',
		)
	);

	if ( ! is_wp_error( $term_ids ) && ! empty( $term_ids ) ) {
		$by_term = get_posts(
			array(
				'post_type'      => 'servicio',
				'post_status'    => 'publish',
				'posts_per_page' => $limit,
				'post__not_in'   => $exclude,
				'orderby'        => 'date',
				'order'          => 'DESC',
				'tax_query'      => array(
					array(
						'taxonomy' => 'categoria_servicio',
						'field'    => 'term_id',
						'terms'    => $term_ids,
					),
				),
			)
		);

		if ( is_array( $by_term ) && ! empty( $by_term ) ) {
			$items = $by_term;
			foreach ( $by_term as $service_post ) {
				if ( $service_post instanceof WP_Post ) {
					$exclude[] = (int) $service_post->ID;
				}
			}
		}
	}

	$remaining = $limit - count( $items );
	if ( $remaining > 0 ) {
		$fallback = get_posts(
			array(
				'post_type'      => 'servicio',
				'post_status'    => 'publish',
				'posts_per_page' => $remaining,
				'post__not_in'   => $exclude,
				'orderby'        => 'date',
				'order'          => 'DESC',
			)
		);

		if ( is_array( $fallback ) && ! empty( $fallback ) ) {
			$items = array_merge( $items, $fallback );
		}
	}

	return $items;
}

/**
 * Renders other services section.
 *
 * @param array $other      Other services data.
 * @param int   $service_id Current service ID.
 * @return void
 */
function echos_service_render_other_services( $other, $service_id = 0 ) {
	$service_id   = echos_service_resolve_service_id( $service_id );
	$manual_items = isset( $other['items'] ) && is_array( $other['items'] ) ? $other['items'] : array();
	$items        = array();
	$limit        = count( $manual_items );

	if ( $limit < 1 ) {
		$limit = 2;
	}

	$related_services = echos_service_get_other_services_from_cpt( $service_id, $limit );
	if ( ! empty( $related_services ) ) {
		foreach ( $related_services as $service_post ) {
			if ( ! $service_post instanceof WP_Post ) {
				continue;
			}

			$related_id      = (int) $service_post->ID;
			$related_variant = echos_service_get_variant_from_template( $related_id );
			$related_data    = echos_service_get_variant_data( $related_id, $related_variant );
			$description     = trim( (string) ( $related_data['hero']['description'] ?? '' ) );

			if ( '' === $description ) {
				$description = echos_service_get_post_summary( $related_id );
			}

			$items[] = array(
				'title'       => get_the_title( $related_id ),
				'description' => $description,
				'url'         => get_permalink( $related_id ),
				'bg_variant'  => 'stands' === $related_variant ? 'stands' : 'iluminacion',
			);
		}
	}

	if ( empty( $items ) ) {
		$items = $manual_items;
	}
	?>
	<section class="srv-other">
		<div class="srv-other__inner">
			<h2 class="srv-other__title"><?php echo esc_html( isset( $other['title'] ) ? $other['title'] : '' ); ?></h2>

			<div class="srv-other__grid">
				<?php foreach ( $items as $item ) : ?>
					<?php
					if ( ! is_array( $item ) ) {
						continue;
					}

					$variant = isset( $item['bg_variant'] ) ? sanitize_key( $item['bg_variant'] ) : 'iluminacion';
					if ( ! in_array( $variant, array( 'iluminacion', 'stands' ), true ) ) {
						$variant = 'iluminacion';
					}
					?>
					<a href="<?php echo esc_url( isset( $item['url'] ) ? $item['url'] : '#' ); ?>" class="srv-other__card">
						<div class="srv-other__card-bg srv-other__card-bg--<?php echo esc_attr( $variant ); ?>" aria-hidden="true"></div>
						<div class="srv-other__card-content">
							<h3 class="srv-other__card-title"><?php echo esc_html( isset( $item['title'] ) ? $item['title'] : '' ); ?></h3>
							<p class="srv-other__card-desc"><?php echo esc_html( isset( $item['description'] ) ? $item['description'] : '' ); ?></p>
						</div>
						<span class="srv-other__card-arrow" aria-hidden="true">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="7" y1="17" x2="17" y2="7"/><polyline points="7 7 17 7 17 17"/></svg>
						</span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Renders final CTA section.
 *
 * @param array $cta CTA data.
 * @return void
 */
function echos_service_render_final_cta( $cta ) {
	?>
	<section class="prod-cta">
		<div class="container">
			<div class="prod-cta__card">
				<h2 class="prod-cta__title"><?php echo esc_html( isset( $cta['title'] ) ? $cta['title'] : '' ); ?></h2>
				<p class="prod-cta__text"><?php echo esc_html( isset( $cta['text'] ) ? $cta['text'] : '' ); ?></p>
				<div class="prod-cta__buttons">
					<a class="btn-cta-dark" href="<?php echo esc_url( isset( $cta['primary_url'] ) ? $cta['primary_url'] : '#' ); ?>" target="_blank" rel="noopener">
						<span><?php echo esc_html( isset( $cta['primary_text'] ) ? $cta['primary_text'] : '' ); ?></span>
						<span class="btn-cta-dark__icon" aria-hidden="true">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.025.507 3.932 1.396 5.608L.05 23.708a.6.6 0 00.735.728L6.53 22.64A11.94 11.94 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 21.6a9.56 9.56 0 01-5.175-1.516l-.372-.222-3.843.985 1.028-3.752-.243-.387A9.56 9.56 0 012.4 12c0-5.302 4.298-9.6 9.6-9.6s9.6 4.298 9.6 9.6-4.298 9.6-9.6 9.6z"/></svg>
						</span>
					</a>
					<a class="btn-cta-dark" href="<?php echo esc_url( isset( $cta['secondary_url'] ) ? $cta['secondary_url'] : '#' ); ?>" target="_blank" rel="noopener">
						<span><?php echo esc_html( isset( $cta['secondary_text'] ) ? $cta['secondary_text'] : '' ); ?></span>
						<span class="btn-cta-dark__icon" aria-hidden="true">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M22 4L12 13 2 4"/></svg>
						</span>
					</a>
				</div>
			</div>
		</div>
	</section>
	<?php
}
