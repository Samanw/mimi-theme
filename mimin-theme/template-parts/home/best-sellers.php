<?php
/**
 * Best Sellers — tabs of product categories with product grids.
 * Tabs = top-level product categories (max 3). Requires WooCommerce.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'WooCommerce' ) ) { return; }

$per_page = intval( mimin_get_option( 'best_count', 8 ) );
$per_page = $per_page > 0 ? $per_page : 8;

$terms = get_terms( array(
	'taxonomy'   => 'product_cat',
	'parent'     => 0,
	'hide_empty' => true,
	'number'     => 3,
) );

if ( is_wp_error( $terms ) || empty( $terms ) ) {
	/* No categories yet — fall back to latest products in a single tab */
	$terms = array( (object) array( 'term_id' => 0, 'name' => __( 'New Arrivals', 'mimin' ), 'slug' => 'all' ) );
}

$shop_url = wc_get_page_permalink( 'shop' );
?>
<!-- ══════════════════════ BEST SELLERS ══════════════════════ -->
<section class="max-w-boxed mx-auto px-[15px] mt-[80px] lg:mt-[120px]">
	<div class="reveal flex flex-wrap items-end justify-between gap-6 mb-12">
		<h2 class="text-[30px] sm:text-[36px] lg:text-[40px] leading-tight font-normal"><?php echo esc_html( mimin_get_option( 'best_title', 'Best Sellers' ) ); ?></h2>
		<div class="flex gap-8 text-[15px]" id="product-tabs">
			<?php foreach ( $terms as $i => $term ) : ?>
				<button class="tab-btn<?php echo 0 === $i ? ' is-active' : ''; ?>" data-tab="<?php echo esc_attr( $term->slug ); ?>"><?php echo esc_html( $term->name ); ?></button>
			<?php endforeach; ?>
		</div>
	</div>

	<?php foreach ( $terms as $i => $term ) : ?>
		<?php
		$args = array(
			'post_type'           => 'product',
			'posts_per_page'      => $per_page,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => 1,
		);
		if ( 0 === $term->term_id ) {
			$args['orderby'] = 'date';
			$args['order']   = 'DESC';
		} else {
			$args['tax_query'] = array( // phpcs:ignore
				array(
					'taxonomy' => 'product_cat',
					'field'    => 'term_id',
					'terms'    => $term->term_id,
				),
			);
		}

		$loop = new WP_Query( $args );
		?>
		<div class="products-pane<?php echo 0 === $i ? '' : ' hidden'; ?>" data-pane="<?php echo esc_attr( $term->slug ); ?>">
			<div class="grid grid-cols-2 lg:grid-cols-4 gap-x-[30px] gap-y-12">
				<?php
				if ( $loop->have_posts() ) {
					while ( $loop->have_posts() ) {
						$loop->the_post();
						wc_get_template_part( 'content', 'product' );
					}
					wp_reset_postdata();
				} else {
					echo '<p class="col-span-2 lg:col-span-4 text-soft text-[14.5px]">' . esc_html__( 'No products found. Add products in WooCommerce to fill this section.', 'mimin' ) . '</p>';
				}
				?>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="text-center mt-16 reveal">
		<a href="<?php echo esc_url( $shop_url ); ?>" class="btn-line"><?php echo esc_html( mimin_get_option( 'best_more_label', 'Shop More' ) ); ?></a>
	</div>
</section>
