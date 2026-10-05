<?php
/**
 * Mimin — shop sidebar (filters & widgets with demo fallback).
 *
 * WooCommerce filter widgets dropped into the "Shop Filters Sidebar"
 * area replace the demo filters. The demo filters use native WooCommerce
 * GET params: min_price/max_price, filter_color, filter_size, rating_filter.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<aside id="shop-sidebar" class="mb-12 lg:mb-0 max-lg:fixed max-lg:inset-y-0 max-lg:left-0 max-lg:w-[310px] max-lg:max-w-[85vw] max-lg:bg-white max-lg:z-[75] max-lg:-translate-x-full max-lg:transition-transform max-lg:duration-300 max-lg:overflow-y-auto max-lg:p-7">
	<button id="filter-close" class="max-lg:block hidden ml-auto mb-4 p-1.5" aria-label="<?php esc_attr_e( 'Close filters', 'mimin' ); ?>">
		<?php echo mimin_icon( 'close', 18 ); // phpcs:ignore ?>
	</button>

	<?php if ( is_active_sidebar( 'sidebar-shop' ) ) : ?>
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-shop' ); ?>
		</div>
	<?php else : ?>

		<!-- price filter -->
		<?php
		$min = isset( $_GET['min_price'] ) ? absint( $_GET['min_price'] ) : 0;  // phpcs:ignore
		$max = isset( $_GET['max_price'] ) ? absint( $_GET['max_price'] ) : 0; // phpcs:ignore
		$price_max = 700;
		?>
		<div class="widget-block">
			<h4 class="widget-title"><?php esc_html_e( 'Filter by price', 'mimin' ); ?></h4>
			<form method="get" action="<?php echo esc_url( get_permalink( function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0 ) ); ?>">
				<?php
				/* preserve taxonomy filters */
				foreach ( array( 'filter_color', 'filter_size', 'rating_filter', 'orderby' ) as $qk ) {
					if ( isset( $_GET[ $qk ] ) ) { // phpcs:ignore
						echo '<input type="hidden" name="' . esc_attr( $qk ) . '" value="' . esc_attr( sanitize_text_field( wp_unslash( $_GET[ $qk ] ) ) ) . '">'; // phpcs:ignore
					}
				}
				?>
				<div class="relative h-6 mb-4">
					<div class="absolute inset-x-0 top-1/2 -translate-y-1/2 h-[2px] bg-line"></div>
					<div id="price-track" class="absolute top-1/2 -translate-y-1/2 h-[2px] bg-black"></div>
					<input id="price-min" name="min_price" type="range" min="0" max="<?php echo esc_attr( $price_max ); ?>" step="5" value="<?php echo esc_attr( $min ); ?>" class="price-range" aria-label="<?php esc_attr_e( 'Minimum price', 'mimin' ); ?>">
					<input id="price-max" name="max_price" type="range" min="0" max="<?php echo esc_attr( $price_max ); ?>" step="5" value="<?php echo esc_attr( $max ? $max : $price_max ); ?>" class="price-range" aria-label="<?php esc_attr_e( 'Maximum price', 'mimin' ); ?>">
				</div>
				<p class="text-[14px]"><?php esc_html_e( 'Price:', 'mimin' ); ?> <span id="price-label" class="font-medium"></span></p>
				<button type="submit" class="btn-outline mt-4"><?php esc_html_e( 'Apply', 'mimin' ); ?></button>
			</form>
		</div>

		<!-- categories -->
		<div class="widget-block">
			<h4 class="widget-title"><?php esc_html_e( 'Product categories', 'mimin' ); ?></h4>
			<?php
			$cats = get_terms( array( 'taxonomy' => 'product_cat', 'hide_empty' => true, 'number' => 8 ) );
			if ( ! is_wp_error( $cats ) && $cats ) {
				echo '<ul class="space-y-3">';
				foreach ( $cats as $c ) {
					printf(
						'<li><a href="%1$s" class="check-row">%2$s <span class="text-[13px]">(%3$d)</span></a></li>',
						esc_url( get_term_link( $c ) ),
						esc_html( $c->name ),
						intval( $c->count )
					);
				}
				echo '</ul>';
			} else {
				echo '<p class="text-[13.5px] text-soft">' . esc_html__( 'No categories yet.', 'mimin' ) . '</p>';
			}
			?>
		</div>

		<!-- color attribute filter -->
		<?php
		if ( taxonomy_exists( 'pa_color' ) ) :
			$colors = get_terms( array( 'taxonomy' => 'pa_color', 'hide_empty' => true, 'number' => 12 ) );
			if ( ! is_wp_error( $colors ) && $colors ) :
				$base = get_permalink( wc_get_page_id( 'shop' ) );
				?>
				<div class="widget-block">
					<h4 class="widget-title"><?php esc_html_e( 'Filter by color', 'mimin' ); ?></h4>
					<div class="flex flex-wrap gap-3">
						<?php foreach ( $colors as $color ) : ?>
							<?php
							$hex = get_term_meta( $color->term_id, 'mimin_color_hex', true );
							$hex = $hex ? $hex : '#1c1c1c';
							$url = add_query_arg( 'filter_color', $color->slug, $base );
							?>
							<a href="<?php echo esc_url( $url ); ?>" class="color-swatch" style="background:<?php echo esc_attr( $hex ); ?>" aria-label="<?php echo esc_attr( $color->name ); ?>"></a>
						<?php endforeach; ?>
					</div>
				</div>
				<?php
			endif;
		endif;
		?>

		<!-- size attribute filter -->
		<?php
		if ( taxonomy_exists( 'pa_size' ) ) :
			$sizes = get_terms( array( 'taxonomy' => 'pa_size', 'hide_empty' => true, 'number' => 12 ) );
			if ( ! is_wp_error( $sizes ) && $sizes ) :
				$base = get_permalink( wc_get_page_id( 'shop' ) );
				?>
				<div class="widget-block">
					<h4 class="widget-title"><?php esc_html_e( 'Filter by size', 'mimin' ); ?></h4>
					<div class="flex flex-wrap gap-2.5">
						<?php foreach ( $sizes as $s ) : ?>
							<a href="<?php echo esc_url( add_query_arg( 'filter_size', $s->slug, $base ) ); ?>" class="size-btn"><?php echo esc_html( $s->name ); ?></a>
						<?php endforeach; ?>
					</div>
				</div>
				<?php
			endif;
		endif;
		?>

		<!-- rating filter -->
		<div class="widget-block">
			<h4 class="widget-title"><?php esc_html_e( 'Average rating', 'mimin' ); ?></h4>
			<?php
			$base = get_permalink( wc_get_page_id( 'shop' ) );
			?>
			<ul class="space-y-3 text-[14.5px]">
				<?php foreach ( array( 4, 3 ) as $r ) : ?>
					<li>
						<a href="<?php echo esc_url( add_query_arg( 'rating_filter', $r, $base ) ); ?>" class="check-row">
							<span class="text-[#F0A93B] tracking-[2px]"><?php echo esc_html( str_repeat( '★', $r ) ); ?></span>
							<span>&amp; up</span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<!-- top rated products -->
		<div class="widget-block">
			<h4 class="widget-title"><?php esc_html_e( 'Top rated products', 'mimin' ); ?></h4>
			<ul class="space-y-5">
				<?php
				$top = new WP_Query( array(
					'post_type'      => 'product',
					'posts_per_page' => 4,
					'meta_key'       => '_wc_average_rating', // phpcs:ignore
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC',
					'no_found_rows'  => 1,
				) );
				if ( $top->have_posts() ) :
					while ( $top->have_posts() ) :
						$top->the_post();
						$p = wc_get_product( get_the_ID() );
						?>
						<li class="flex gap-3.5 items-center group">
							<a href="<?php echo esc_url( $p->get_permalink() ); ?>" class="w-[64px] h-[64px] shrink-0 overflow-hidden zoom-img block bg-mist">
								<?php echo $p->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); // phpcs:ignore ?>
							</a>
							<div>
								<a href="<?php echo esc_url( $p->get_permalink() ); ?>" class="block text-[13.5px] leading-snug group-hover:text-soft transition-colors"><?php echo esc_html( $p->get_name() ); ?></a>
								<p class="text-[13px] mt-1"><?php echo wp_kses_post( $p->get_price_html() ); ?></p>
							</div>
						</li>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					echo '<li class="text-[13.5px] text-soft">' . esc_html__( 'No products yet.', 'mimin' ) . '</li>';
				endif;
				?>
			</ul>
		</div>

		<!-- product tags -->
		<?php
		$tags = get_terms( array( 'taxonomy' => 'product_tag', 'hide_empty' => true, 'number' => 10 ) );
		if ( ! is_wp_error( $tags ) && $tags ) :
			?>
			<div class="widget-block">
				<h4 class="widget-title"><?php esc_html_e( 'Product tags', 'mimin' ); ?></h4>
				<div class="flex flex-wrap gap-2">
					<?php foreach ( $tags as $t ) : ?>
						<a href="<?php echo esc_url( get_term_link( $t ) ); ?>" class="tag-chip"><?php echo esc_html( $t->name ); ?></a>
					<?php endforeach; ?>
				</div>
			</div>
			<?php
		endif;
		?>

		<!-- promo banner -->
		<div class="widget-block zoom-img relative overflow-hidden bg-sage">
			<img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/product-16-600x600.webp' ) ); ?>" alt="<?php esc_attr_e( 'Certosa Armchair', 'mimin' ); ?>" class="w-full aspect-[4/5] object-cover" loading="lazy">
			<div class="absolute inset-0 flex flex-col items-center justify-end pb-7 text-center bg-gradient-to-t from-black/35 to-transparent">
				<p class="text-[12px] tracking-[2px] text-white/85 uppercase mb-1.5"><?php esc_html_e( 'New season', 'mimin' ); ?></p>
				<p class="text-[19px] text-white font-medium mb-4"><?php esc_html_e( 'Certosa Armchair', 'mimin' ); ?></p>
				<a href="<?php echo esc_url( class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' ) ); ?>" class="text-[12.5px] tracking-[1px] text-white border-b border-white pb-0.5 hover:opacity-70 transition-opacity"><?php esc_html_e( 'Shop now', 'mimin' ); ?></a>
			</div>
		</div>

	<?php endif; ?>
</aside>
