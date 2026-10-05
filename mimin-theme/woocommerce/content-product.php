<?php
/**
 * Mimin — product card used in every product loop.
 * Mirrors the static demo card: hover image, sale badge, hover actions,
 * add-to-cart slide-up, category, name, price.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$id         = $product->get_id();
$link       = $product->get_permalink();
$cats       = wp_get_post_terms( $id, 'product_cat', array( 'fields' => 'names' ) );
$gallery    = $product->get_gallery_image_ids();
$hover_id   = ! empty( $gallery ) ? $gallery[0] : 0;
$in_stock   = $product->is_in_stock();
$purchasable = $product->is_type( 'simple' ) && $product->is_purchasable() && $in_stock;
?>
<article class="product-card" data-name="<?php echo esc_attr( $product->get_name() ); ?>" data-price="<?php echo esc_attr( $product->get_price() ); ?>" data-img="<?php echo esc_url( wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_thumbnail' ) ); ?>" data-cat="<?php echo esc_attr( implode( ', ', $cats ) ); ?>">

	<div class="product-media relative overflow-hidden bg-mist">
		<?php if ( ! $in_stock ) : ?>
			<span class="sale-badge absolute top-4 left-4 z-10"><?php esc_html_e( 'Sold out', 'mimin' ); ?></span>
		<?php elseif ( $product->is_on_sale() ) : ?>
			<span class="sale-badge absolute top-4 left-4 z-10"><?php echo esc_html( mimin_sale_percentage( $product ) ); ?></span>
		<?php endif; ?>

		<a href="<?php echo esc_url( $link ); ?>" class="block aspect-square relative">
			<?php
			echo $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'img-main absolute inset-0 w-full h-full object-cover', 'loading' => 'lazy' ) ); // phpcs:ignore
			if ( $hover_id ) {
				echo wp_get_attachment_image( $hover_id, 'woocommerce_thumbnail', false, array( 'class' => 'img-hover absolute inset-0 w-full h-full object-cover opacity-0', 'loading' => 'lazy', 'alt' => '' ) ); // phpcs:ignore
			}
			?>
		</a>

		<div class="card-actions absolute right-3 top-3 flex flex-col gap-2">
			<button class="icon-btn quickview-btn" data-product-id="<?php echo esc_attr( $id ); ?>" aria-label="<?php esc_attr_e( 'Quick View', 'mimin' ); ?>"><?php echo mimin_icon( 'eye', 17 ); // phpcs:ignore ?></button>
			<button class="icon-btn wishlist-btn" data-product-id="<?php echo esc_attr( $id ); ?>" aria-label="<?php esc_attr_e( 'Wishlist', 'mimin' ); ?>"><?php echo mimin_icon( 'heart', 17 ); // phpcs:ignore ?></button>
			<button class="icon-btn compare-btn" aria-label="<?php esc_attr_e( 'Compare', 'mimin' ); ?>"><?php echo mimin_icon( 'compare', 17 ); // phpcs:ignore ?></button>
		</div>

		<?php if ( $purchasable ) : ?>
			<a href="<?php echo esc_url( '?add-to-cart=' . $id ); ?>" data-quantity="1" class="btn-atc add_to_cart_button ajax_add_to_cart absolute bottom-0 inset-x-0 bg-black text-white text-[13px] tracking-[1px] py-3.5 text-center" data-product_id="<?php echo esc_attr( $id ); ?>" data-product_sku="<?php echo esc_attr( $product->get_sku() ); ?>" rel="nofollow"><?php esc_html_e( 'Add to cart', 'mimin' ); ?></a>
		<?php elseif ( $in_stock ) : ?>
			<a href="<?php echo esc_url( $link ); ?>" class="btn-atc absolute bottom-0 inset-x-0 bg-black text-white text-[13px] tracking-[1px] py-3.5 text-center"><?php esc_html_e( 'Select options', 'mimin' ); ?></a>
		<?php endif; ?>
	</div>

	<div class="pt-4">
		<p class="text-[13px] text-soft mb-1.5"><?php echo esc_html( implode( ', ', $cats ) ); ?></p>
		<h3 class="text-[15.5px] font-normal leading-snug mb-1.5">
			<a href="<?php echo esc_url( $link ); ?>" class="hover:text-soft transition-colors"><?php echo esc_html( $product->get_name() ); ?></a>
		</h3>
		<p class="text-[15px]"><?php echo wp_kses_post( $product->get_price_html() ); ?></p>
	</div>
</article>
