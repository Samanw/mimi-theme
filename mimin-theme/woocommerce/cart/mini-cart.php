<?php
/**
 * Mimin — mini cart (cart drawer contents).
 * Adds quantity steppers keyed to the cart item so the drawer can
 * update quantities via AJAX.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

do_action( 'woocommerce_before_mini_cart' );
?>

<?php if ( ! WC()->cart->is_empty() ) : ?>

	<ul class="woocommerce-mini-cart cart_list product_list_widget">
		<?php
		do_action( 'woocommerce_before_mini_cart_contents' );

		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
			$_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			if ( ! $_product || ! $_product->exists() || $cart_item['quantity'] <= 0 ) {
				continue;
			}

			$product_name      = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key );
			$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover' ) ), $cart_item, $cart_item_key );
			$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
			$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
			?>
			<li class="woocommerce-mini-cart-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>" data-key="<?php echo esc_attr( $cart_item_key ); ?>">

				<a href="<?php echo esc_url( wc_get_cart_remove_url( $cart_item_key ) ); ?>" class="remove remove_from_cart_button" aria-label="<?php esc_attr_e( 'Remove this item', 'mimin' ); ?>" data-cart_item_key="<?php echo esc_attr( $cart_item_key ); ?>" data-product_id="<?php echo esc_attr( $_product->get_id() ); ?>" data-product_sku="<?php echo esc_attr( $_product->get_sku() ); ?>">&times;</a>

				<?php if ( ! $_product->is_visible() ) : ?>
					<span class="w-20 h-20 shrink-0 bg-mist overflow-hidden block"><?php echo wp_kses_post( $thumbnail ); ?></span>
				<?php else : ?>
					<a href="<?php echo esc_url( $product_permalink ); ?>" class="w-20 h-20 shrink-0 bg-mist overflow-hidden block"><?php echo wp_kses_post( $thumbnail ); ?></a>
				<?php endif; ?>

				<div class="flex-1 min-w-0">
					<?php if ( ! $product_permalink ) : ?>
						<span class="block"><?php echo wp_kses_post( $product_name ); ?></span>
					<?php else : ?>
						<a href="<?php echo esc_url( $product_permalink ); ?>" class="block"><?php echo wp_kses_post( $product_name ); ?></a>
					<?php endif; ?>

					<div class="quantity">
						<span class="mimin-mini-qty">
							<button type="button" class="mini-qty-btn" data-key="<?php echo esc_attr( $cart_item_key ); ?>" data-d="-1" aria-label="<?php esc_attr_e( 'Decrease quantity', 'mimin' ); ?>">&minus;</button>
							<span class="mini-qty-val"><?php echo esc_html( $cart_item['quantity'] ); ?></span>
							<button type="button" class="mini-qty-btn" data-key="<?php echo esc_attr( $cart_item_key ); ?>" data-d="1" aria-label="<?php esc_attr_e( 'Increase quantity', 'mimin' ); ?>">+</button>
						</span>
						<?php echo wp_kses_post( $product_price ); ?>
					</div>
				</div>
			</li>
			<?php
		endforeach;

		do_action( 'woocommerce_mini_cart_contents' );
		?>
	</ul>

	<p class="woocommerce-mini-cart__total total">
		<?php esc_html_e( 'Subtotal', 'mimin' ); ?>
		<strong><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></strong>
	</p>

	<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>

	<p class="woocommerce-mini-cart__buttons buttons">
		<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button btn-outline wc-forward"><?php esc_html_e( 'View cart', 'mimin' ); ?></a>
		<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout wc-forward"><?php esc_html_e( 'Checkout', 'mimin' ); ?></a>
	</p>

	<?php do_action( 'woocommerce_widget_shopping_cart_after_buttons' ); ?>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e( 'No products in the cart.', 'mimin' ); ?></p>

<?php endif; ?>

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
