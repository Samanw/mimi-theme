<?php
/**
 * Mimin — single product.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

while ( have_posts() ) :
	the_post();

	global $product;
	?>
	<div id="product-<?php the_ID(); ?>" <?php post_class( 'product' ); ?>>

		<div class="max-w-boxed mx-auto px-[15px]">
			<?php mimin_breadcrumbs(); ?>
		</div>

		<section class="max-w-boxed mx-auto px-[15px] pb-24">

			<?php do_action( 'woocommerce_before_single_product' ); ?>

			<div class="lg:grid lg:grid-cols-2 lg:gap-16">

				<!-- gallery -->
				<div class="reveal">
					<?php woocommerce_show_product_images(); ?>
				</div>

				<!-- summary -->
				<div class="mt-10 lg:mt-0 reveal">
					<div class="summary entry-summary">
						<h1 class="text-[30px] sm:text-[36px] leading-tight font-normal mb-3"><?php echo esc_html( $product->get_name() ); ?></h1>

						<?php if ( wc_review_ratings_enabled() && $product->get_review_count() ) : ?>
							<div class="flex items-center gap-3 mb-5 text-[14px]">
								<?php echo mimin_star_rating( (float) $product->get_average_rating(), 0 ); // phpcs:ignore ?>
								<a href="#tab-reviews" class="text-[13.5px] text-soft hover:text-black transition-colors mimin-reviews-link">
									<?php
									/* translators: %d: review count */
									printf( esc_html__( '(%d customer reviews)', 'mimin' ), intval( $product->get_review_count() ) );
									?>
								</a>
							</div>
						<?php endif; ?>

						<div class="text-[21px] mb-7"><?php echo wp_kses_post( $product->get_price_html() ); ?></div>

						<?php woocommerce_template_single_excerpt(); ?>

						<div class="mt-8">
							<?php woocommerce_template_single_add_to_cart(); ?>
						</div>

						<?php woocommerce_template_single_meta(); ?>

						<!-- wishlist / share -->
						<div class="flex items-center gap-5 mt-8">
							<button class="icon-btn !w-[44px] !h-[44px] !rounded-none wishlist-btn" data-product-id="<?php echo esc_attr( $product->get_id() ); ?>" aria-label="<?php esc_attr_e( 'Add to wishlist', 'mimin' ); ?>">
								<?php echo mimin_icon( 'heart', 18 ); // phpcs:ignore ?>
							</button>
							<div class="flex items-center gap-3.5 text-soft">
								<span class="text-[13.5px] font-medium text-black mr-1"><?php esc_html_e( 'Share:', 'mimin' ); ?></span>
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="Facebook" class="hover:text-black transition-colors"><?php echo mimin_icon( 'facebook', 15 ); // phpcs:ignore ?></a>
								<a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&text=<?php echo esc_attr( $product->get_name() ); ?>" target="_blank" rel="noopener" aria-label="X" class="hover:text-black transition-colors"><?php echo mimin_icon( 'x', 14 ); // phpcs:ignore ?></a>
								<a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="Pinterest" class="hover:text-black transition-colors"><?php echo mimin_icon( 'pinterest', 15 ); // phpcs:ignore ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- tabs (description / additional information / reviews) -->
			<div class="mt-20 lg:mt-28 reveal">
				<?php woocommerce_output_all_data_tabs(); ?>
			</div>

			<!-- related products -->
			<?php woocommerce_output_related_products(); ?>

			<?php do_action( 'woocommerce_after_single_product' ); ?>
		</section>
	</div>

	<?php
endwhile;

get_footer();
