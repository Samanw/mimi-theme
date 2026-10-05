<?php
/**
 * Mimin — cart page (theme-stilled, WooCommerce-native form fields).
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

do_action( 'woocommerce_before_cart' );
?>

<form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" class="woocommerce-cart-form">

        <div class="lg:grid lg:grid-cols-[1fr_360px] lg:gap-14">

                <!-- items -->
                <div class="min-w-0">
                        <div class="hidden md:grid grid-cols-[1fr_110px_140px_110px_36px] gap-4 border-b border-line pb-4 text-[13px] tracking-[1px] uppercase text-soft">
                                <span><?php esc_html_e( 'Product', 'mimin' ); ?></span>
                                <span><?php esc_html_e( 'Price', 'mimin' ); ?></span>
                                <span><?php esc_html_e( 'Quantity', 'mimin' ); ?></span>
                                <span class="text-right"><?php esc_html_e( 'Subtotal', 'mimin' ); ?></span>
                                <span></span>
                        </div>

                        <?php
                        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                                $product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                                if ( ! $product || ! $product->exists() || ! $product->is_purchasable() ) {
                                        continue;
                                }
                                $price         = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $product ), $cart_item, $cart_item_key );
                                $subtotal      = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                                $remove_url    = wc_get_cart_remove_url( $cart_item_key );
                                ?>
                                <div class="cart-row grid grid-cols-2 md:grid-cols-[1fr_110px_140px_110px_36px] gap-4 items-center border-b border-line py-6">

                                        <!-- product -->
                                        <div class="flex gap-4 items-center col-span-2 md:col-span-1">
                                                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="w-[80px] h-[80px] shrink-0 bg-mist overflow-hidden block">
                                                        <?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $product->get_image( 'woocommerce_thumbnail', array( 'class' => 'w-full h-full object-cover' ) ), $cart_item, $cart_item_key ); // phpcs:ignore ?>
                                                </a>
                                                <div class="min-w-0">
                                                        <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block text-[14.5px] leading-snug hover:text-soft transition-colors"><?php echo esc_html( $product->get_name() ); ?></a>
                                                        <?php echo wc_get_formatted_cart_item_data( $cart_item ); // phpcs:ignore ?>
                                                </div>
                                        </div>

                                        <!-- price -->
                                        <div class="hidden md:block text-[14px] cart-item-price"><?php echo wp_kses_post( $price ); ?></div>

                                        <!-- quantity (single input, responsive placement) -->
                                        <div class="mimin-qty">
                                                <button type="button" class="qty-minus" aria-label="<?php esc_attr_e( 'Decrease quantity', 'mimin' ); ?>">−</button>
                                                <?php
                                                $_qty = wc_stock_amount( $cart_item['quantity'] );
                                                $max  = $product->get_max_purchase_quantity();
                                                ?>
                                                <input type="number" class="qty" name="cart[<?php echo esc_attr( $cart_item_key ); ?>][qty]" value="<?php echo esc_attr( $_qty ); ?>" min="0" max="<?php echo esc_attr( is_numeric( $max ) ? $max : '' ); ?>" step="1" inputmode="numeric" aria-label="<?php esc_attr_e( 'Quantity', 'mimin' ); ?>">
                                                <button type="button" class="qty-plus" aria-label="<?php esc_attr_e( 'Increase quantity', 'mimin' ); ?>">+</button>
                                        </div>

                                        <!-- subtotal -->
                                        <div class="hidden md:block text-right text-[14.5px] cart-item-subtotal"><?php echo wp_kses_post( $subtotal ); ?></div>

                                        <!-- remove -->
                                        <div class="hidden md:flex justify-end">
                                                <a href="<?php echo esc_url( $remove_url ); ?>" class="p-1 text-soft hover:text-black transition-colors" aria-label="<?php esc_attr_e( 'Remove item', 'mimin' ); ?>">
                                                        <?php echo mimin_icon( 'close', 15 ); // phpcs:ignore ?>
                                                </a>
                                        </div>

                                        <!-- mobile subtotal + remove -->
                                        <div class="md:hidden col-span-2 flex items-center justify-between text-[14px]">
                                                <span class="text-[14.5px]"><?php echo wp_kses_post( $subtotal ); ?></span>
                                                <a href="<?php echo esc_url( $remove_url ); ?>" class="text-soft hover:text-black" aria-label="<?php esc_attr_e( 'Remove item', 'mimin' ); ?>"><?php echo mimin_icon( 'close', 14 ); // phpcs:ignore ?></a>
                                        </div>
                                </div>
                                <?php
                        endforeach;

                        do_action( 'woocommerce_cart_contents' );
                        ?>
                        <input type="hidden" name="update_cart" id="update_cart" value="">
                        <?php do_action( 'woocommerce_cart_actions' ); ?>
                        <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                        <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                </div>

                <!-- collaterals -->
                <aside class="mt-12 lg:mt-0">
                        <?php if ( WC()->cart->get_cart_contents_count() ) : ?>
                                <!-- coupon -->
                                <div class="border border-line p-6 mb-8">
                                        <button type="button" id="coupon-toggle" class="text-[13.5px] tracking-[1px] uppercase border-b border-black pb-0.5"><?php esc_html_e( 'Have a coupon?', 'mimin' ); ?></button>
                                        <div id="coupon-box" class="hidden mt-5">
                                                <div class="flex">
                                                        <input type="text" name="coupon_code" id="coupon_code" class="flex-1 min-w-0 border border-line2 border-r-0 px-4 py-3 text-[14px] outline-none focus:border-black transition-colors" placeholder="<?php esc_attr_e( 'Coupon code', 'mimin' ); ?>">
                                                        <button type="submit" class="shrink-0 bg-black text-white text-[13px] tracking-[1px] px-6 hover:bg-transparent hover:text-black border border-black transition-colors" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'mimin' ); ?>"><?php esc_html_e( 'Apply', 'mimin' ); ?></button>
                                                </div>
                                        </div>
                                </div>
                        <?php endif; ?>

                        <?php woocommerce_cart_totals(); ?>
                </aside>
        </div>
</form>

<?php do_action( 'woocommerce_after_cart' ); ?>

<?php
if ( WC()->cart->get_cart_contents_count() ) {
        woocommerce_cross_sell_display();
}
