<?php
/**
 * Lookbook — image with product hotspots + horizontal product carousel.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$hotspot_positions = mimin_get_option( 'lookbook_hotspots', '30%|34%, 56%|56%, 72%|26%' );
$positions         = array_filter( array_map( 'trim', explode( ',', $hotspot_positions ) ) );

/* Build hotspot products: customizer IDs or static demo fallbacks */
$products = array();
if ( class_exists( 'WooCommerce' ) ) {
	$ids = array_filter( array_map( 'absint', explode( ',', mimin_get_option( 'lookbook_products', '' ) ) ) );
	foreach ( $ids as $id ) {
		$p = wc_get_product( $id );
		if ( $p && $p->is_visible() ) {
			$products[] = $p;
		}
	}
}

$demo = array(
	array( 'img' => 'product-19-600x600.webp', 'img2' => 'product-19-2-600x600.webp', 'name' => 'Bathrobe holder', 'cat' => 'Bathroom', 'old' => '$120.00', 'price' => '$100.00', 'url' => class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#' ),
	array( 'img' => 'product-1-600x600.jpg', 'img2' => 'product-1-2-600x600.jpg', 'name' => 'Bedside table', 'cat' => 'Bedroom', 'old' => '$200.00', 'price' => '$180.00', 'url' => class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#' ),
	array( 'img' => 'product-7-600x600.webp', 'img2' => 'product-7-2-600x600.webp', 'name' => 'Storage Cabinet', 'cat' => 'Storage', 'old' => '$125.00', 'price' => '$100.00', 'url' => class_exists( 'WooCommerce' ) ? wc_get_page_permalink( 'shop' ) : '#' ),
);
?>
<!-- ══════════════════════ LOOKBOOK ══════════════════════ -->
<section class="max-w-boxed mx-auto px-[15px] mt-[80px] lg:mt-[120px]">
	<div class="grid lg:grid-cols-12 gap-[30px] items-stretch">

		<!-- image with hotspots -->
		<div class="lg:col-span-7 reveal relative zoom-img">
			<img src="<?php echo esc_url( mimin_img_url( 'lookbook_img', 'look-3.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Lookbook', 'mimin' ); ?>" class="w-full h-full object-cover">

			<?php
			/* Hotspots from products */
			if ( ! empty( $products ) ) :
				foreach ( $products as $i => $p ) :
					if ( ! isset( $positions[ $i ] ) ) { break; }
					$pos = explode( '|', str_replace( array( ' ', '%' ), '', $positions[ $i ] ) );
					$left = isset( $pos[0] ) ? absint( $pos[0] ) : 30;
					$top  = isset( $pos[1] ) ? absint( $pos[1] ) : 34;
					?>
					<div class="hotspot absolute" style="left:<?php echo esc_attr( $left ); ?>%; top:<?php echo esc_attr( $top ); ?>%;">
						<button class="hotspot-dot relative z-10 w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-lg" aria-label="<?php esc_attr_e( 'View product', 'mimin' ); ?>">
							<span class="block w-3 h-[1.5px] bg-black absolute"></span>
							<span class="block w-[1.5px] h-3 bg-black absolute"></span>
						</button>
						<div class="hotspot-pop absolute left-1/2 -translate-x-1/2 top-11 w-[230px] bg-white shadow-[0_18px_40px_rgba(0,0,0,.14)] p-4 flex gap-3.5 items-center">
							<?php echo $p->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-14 h-14 object-cover shrink-0' ) ); // phpcs:ignore ?>
							<div>
								<a href="<?php echo esc_url( $p->get_permalink() ); ?>" class="block text-[14px] font-medium leading-snug hover:text-soft transition-colors"><?php echo esc_html( $p->get_name() ); ?></a>
								<p class="text-[13px] mt-1"><?php echo wp_kses_post( $p->get_price_html() ); ?></p>
							</div>
						</div>
					</div>
					<?php
				endforeach;
			else :
				/* Demo hotspots */
				$demo_pos = array( array( 30, 34 ), array( 56, 56 ), array( 72, 26 ) );
				foreach ( $demo_pos as $i => $pos ) :
					$d = $demo[ $i ];
					?>
					<div class="hotspot absolute" style="left:<?php echo esc_attr( $pos[0] ); ?>%; top:<?php echo esc_attr( $pos[1] ); ?>%;">
						<button class="hotspot-dot relative z-10 w-8 h-8 rounded-full bg-white flex items-center justify-center shadow-lg" aria-label="<?php esc_attr_e( 'View product', 'mimin' ); ?>">
							<span class="block w-3 h-[1.5px] bg-black absolute"></span>
							<span class="block w-[1.5px] h-3 bg-black absolute"></span>
						</button>
						<div class="hotspot-pop absolute left-1/2 -translate-x-1/2 top-11 w-[230px] bg-white shadow-[0_18px_40px_rgba(0,0,0,.14)] p-4 flex gap-3.5 items-center">
							<img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/' . $d['img'] ) ); ?>" alt="" class="w-14 h-14 object-cover shrink-0">
							<div>
								<a href="<?php echo esc_url( $d['url'] ); ?>" class="block text-[14px] font-medium leading-snug hover:text-soft transition-colors"><?php echo esc_html( $d['name'] ); ?></a>
								<p class="text-[13px] mt-1"><del class="text-soft font-normal mr-1.5"><?php echo esc_html( $d['old'] ); ?></del><span><?php echo esc_html( $d['price'] ); ?></span></p>
							</div>
						</div>
					</div>
					<?php
				endforeach;
			endif;
			?>
		</div>

		<!-- product carousel -->
		<div class="lg:col-span-5 reveal flex flex-col justify-center">
			<div class="flex gap-[30px] overflow-x-auto snap-x snap-mandatory thin-scroll pb-2 lg:pb-0" id="lookbook-track">
				<?php
				if ( ! empty( $products ) ) :
					$carousel = $products;
				else :
					$carousel = array();
					if ( class_exists( 'WooCommerce' ) ) {
						$loop = new WP_Query( array(
							'post_type'      => 'product',
							'posts_per_page' => 3,
							'orderby'        => 'date',
							'order'          => 'DESC',
							'no_found_rows'  => true,
						) );
						while ( $loop->have_posts() ) {
							$loop->the_post();
							$carousel[] = wc_get_product( get_the_ID() );
						}
						wp_reset_postdata();
					}
				endif;

				if ( ! empty( $carousel ) ) :
					foreach ( $carousel as $p ) :
						if ( ! $p || ! $p->is_visible() ) { continue; }
						?>
						<article class="product-card snap-start shrink-0 w-[250px] lg:w-[calc(50%-15px)]" data-name="<?php echo esc_attr( $p->get_name() ); ?>" data-price="<?php echo esc_attr( $p->get_price() ); ?>" data-img="<?php echo esc_url( wp_get_attachment_image_url( $p->get_image_id(), 'woocommerce_thumbnail' ) ); ?>" data-cat="<?php echo esc_attr( implode( ', ', wp_get_post_terms( $p->get_id(), 'product_cat', array( 'fields' => 'names' ) ) ) ); ?>">
							<div class="product-media relative overflow-hidden bg-mist">
								<?php if ( $p->is_on_sale() ) : ?>
									<span class="sale-badge absolute top-4 left-4 z-10"><?php echo esc_html( mimin_sale_percentage( $p ) ); ?></span>
								<?php endif; ?>
								<a href="<?php echo esc_url( $p->get_permalink() ); ?>" class="block aspect-square relative">
									<?php echo $p->get_image( 'woocommerce_thumbnail', array( 'class' => 'img-main absolute inset-0 w-full h-full object-cover', 'loading' => 'lazy' ) ); // phpcs:ignore ?>
								</a>
								<div class="card-actions absolute right-3 top-3 flex flex-col gap-2">
									<button class="icon-btn quickview-btn" data-product-id="<?php echo esc_attr( $p->get_id() ); ?>" aria-label="<?php esc_attr_e( 'Quick View', 'mimin' ); ?>"><?php echo mimin_icon( 'eye', 17 ); // phpcs:ignore ?></button>
									<button class="icon-btn wishlist-btn" data-product-id="<?php echo esc_attr( $p->get_id() ); ?>" aria-label="<?php esc_attr_e( 'Wishlist', 'mimin' ); ?>"><?php echo mimin_icon( 'heart', 17 ); // phpcs:ignore ?></button>
									<button class="icon-btn compare-btn" aria-label="<?php esc_attr_e( 'Compare', 'mimin' ); ?>"><?php echo mimin_icon( 'compare', 17 ); // phpcs:ignore ?></button>
								</div>
								<?php if ( $p->is_type( 'simple' ) && $p->is_purchasable() && $p->is_in_stock() ) : ?>
									<a href="<?php echo esc_url( '?add-to-cart=' . $p->get_id() ); ?>" data-quantity="1" class="btn-atc add_to_cart_button ajax_add_to_cart absolute bottom-0 inset-x-0 bg-black text-white text-[13px] tracking-[1px] py-3.5 text-center" data-product_id="<?php echo esc_attr( $p->get_id() ); ?>" rel="nofollow"><?php esc_html_e( 'Add to cart', 'mimin' ); ?></a>
								<?php else : ?>
									<a href="<?php echo esc_url( $p->get_permalink() ); ?>" class="btn-atc absolute bottom-0 inset-x-0 bg-black text-white text-[13px] tracking-[1px] py-3.5 text-center"><?php esc_html_e( 'Add to cart', 'mimin' ); ?></a>
								<?php endif; ?>
							</div>
							<div class="pt-4">
								<p class="text-[13px] text-soft mb-1.5"><?php echo esc_html( implode( ', ', wp_get_post_terms( $p->get_id(), 'product_cat', array( 'fields' => 'names' ) ) ) ); ?></p>
								<h3 class="text-[15.5px] font-normal leading-snug mb-1.5"><a href="<?php echo esc_url( $p->get_permalink() ); ?>" class="hover:text-soft transition-colors"><?php echo esc_html( $p->get_name() ); ?></a></h3>
								<p class="text-[15px]"><?php echo wp_kses_post( $p->get_price_html() ); ?></p>
							</div>
						</article>
						<?php
					endforeach;
				else :
					/* Static demo cards when no products exist yet */
					foreach ( $demo as $d ) :
						?>
						<article class="product-card snap-start shrink-0 w-[250px] lg:w-[calc(50%-15px)]">
							<div class="product-media relative overflow-hidden bg-mist">
								<span class="sale-badge absolute top-4 left-4 z-10">-<?php echo esc_html( round( ( 1 - floatval( str_replace( '$', '', $d['price'] ) ) / floatval( str_replace( '$', '', $d['old'] ) ) ) * 100 ) ); ?>%</span>
								<a href="<?php echo esc_url( $d['url'] ); ?>" class="block aspect-square relative">
									<img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/' . $d['img'] ) ); ?>" alt="<?php echo esc_attr( $d['name'] ); ?>" class="img-main absolute inset-0 w-full h-full object-cover" loading="lazy">
								</a>
							</div>
							<div class="pt-4">
								<p class="text-[13px] text-soft mb-1.5"><?php echo esc_html( $d['cat'] ); ?></p>
								<h3 class="text-[15.5px] font-normal leading-snug mb-1.5"><a href="<?php echo esc_url( $d['url'] ); ?>" class="hover:text-soft transition-colors"><?php echo esc_html( $d['name'] ); ?></a></h3>
								<p class="text-[15px]"><del class="text-soft font-normal mr-2"><?php echo esc_html( $d['old'] ); ?></del><span><?php echo esc_html( $d['price'] ); ?></span></p>
							</div>
						</article>
						<?php
					endforeach;
				endif;
				?>
			</div>
		</div>
	</div>
</section>
