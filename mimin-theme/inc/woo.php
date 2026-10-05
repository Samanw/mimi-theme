<?php
/**
 * Mimin — WooCommerce integration.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* -------------------------------------------------------------------------
 * Setup
 * ---------------------------------------------------------------------- */
function mimin_woo_support() {
        add_theme_support( 'woocommerce', array(
                'thumbnail_image_width' => 600,
                'single_image_width'    => 900,
                'product_grid'          => array(
                        'default_rows'    => 3,
                        'min_rows'        => 1,
                        'default_columns' => 4,
                        'min_columns'     => 2,
                        'max_columns'     => 5,
                ),
        ) );
        add_theme_support( 'wc-product-gallery-zoom' );
        add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'mimin_woo_support' );

/* 12 products per page */
add_filter( 'loop_shop_per_page', function () {
        return 12;
}, 20 );

/* Related products — 4 columns */
add_filter( 'woocommerce_output_related_products_args', function ( $args ) {
        $args['posts_per_page'] = 4;
        $args['columns']        = 4;
        return $args;
}, 20 );

/* Remove default Woo sidebar (theme renders its own inside archive-product.php) */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/* Keep Woo breadcrumb off (theme renders mimin_breadcrumbs) */
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

/* Theme provides its own wrappers — drop Woo's content-area divs */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/* -------------------------------------------------------------------------
 * Cart count for header badge
 * ---------------------------------------------------------------------- */
function mimin_cart_count() {
        if ( function_exists( 'WC' ) && null !== WC()->cart ) {
                return WC()->cart->get_cart_contents_count();
        }
        return 0;
}

function mimin_header_count_fragment( $fragments ) {
        $count = mimin_cart_count();
        $fragments['#cart-count'] = '<span id="cart-count" class="absolute -top-0.5 -right-1.5 text-[11px] leading-none' . ( $count ? '' : ' hidden' ) . '">' . esc_html( $count ) . '</span>';
        return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'mimin_header_count_fragment' );

/* -------------------------------------------------------------------------
 * Add-to-cart fragments — refresh the theme cart drawer
 * ---------------------------------------------------------------------- */
function mimin_cart_drawer_fragment( $fragments ) {
        ob_start();
        echo '<div id="cart-items" class="thin-scroll flex-1 overflow-y-auto px-7 py-6">';
        mimin_cart_drawer_items();
        echo '</div>';
        $fragments['#cart-items'] = ob_get_clean();
        return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'mimin_cart_drawer_fragment' );

/**
 * Cart drawer item list (mini cart content, theme-styled).
 */
function mimin_cart_drawer_items() {
        if ( ! function_exists( 'woocommerce_mini_cart' ) ) {
                return;
        }
        ?>
        <div class="widget_shopping_cart_content"><?php woocommerce_mini_cart(); ?></div>
        <?php
}

/* -------------------------------------------------------------------------
 * AJAX — quantity stepper in cart drawer
 * ---------------------------------------------------------------------- */
function mimin_ajax_cart_qty() {
        check_ajax_referer( 'mimin', 'nonce' );

        if ( ! function_exists( 'WC' ) || ! isset( $_POST['key'], $_POST['delta'] ) ) {
                wp_send_json_error();
        }

        $key   = sanitize_text_field( wp_unslash( $_POST['key'] ) );
        $delta = intval( $_POST['delta'] );

        if ( ! WC()->cart->get_cart_item( $key ) ) {
                wp_send_json_error( array( 'message' => __( 'Item not found.', 'mimin' ) ) );
        }

        $qty = WC()->cart->get_cart_item( $key )['quantity'] + $delta;

        if ( $qty < 1 ) {
                WC()->cart->remove_cart_item( $key );
        } else {
                WC()->cart->set_quantity( $key, $qty );
        }

        WC()->cart->calculate_totals();

        ob_start();
        mimin_cart_drawer_items();
        $drawer = ob_get_clean();

        wp_send_json_success( array(
                'count'    => WC()->cart->get_cart_contents_count(),
                'subtotal' => wp_strip_all_tags( wc_price( WC()->cart->get_subtotal() ) ),
                'drawer'   => $drawer,
        ) );
}
add_action( 'wp_ajax_mimin_cart_qty', 'mimin_ajax_cart_qty' );
add_action( 'wp_ajax_nopriv_mimin_cart_qty', 'mimin_ajax_cart_qty' );

/* -------------------------------------------------------------------------
 * AJAX — quick view
 * ---------------------------------------------------------------------- */
function mimin_ajax_quickview() {
        check_ajax_referer( 'mimin', 'nonce' );

        if ( ! isset( $_POST['product_id'] ) ) {
                wp_send_json_error();
        }

        $product = wc_get_product( intval( $_POST['product_id'] ) );
        if ( ! $product || ! $product->is_visible() ) {
                wp_send_json_error();
        }

        $image = wp_get_attachment_image( $product->get_image_id(), 'woocommerce_single', false, array( 'class' => 'w-full h-full object-cover aspect-square' ) );
        $cat   = wp_get_post_terms( $product->get_id(), 'product_cat', array( 'fields' => 'names' ) );

        $price_html = $product->get_price_html();
        $desc       = wp_trim_words( wp_strip_all_tags( $product->get_short_description() ? $product->get_short_description() : $product->get_description() ), 28, '…' );

        /* Add-to-cart control: simple → AJAX button; variable → link to product */
        if ( $product->is_type( 'simple' ) && $product->is_purchasable() && $product->is_in_stock() ) {
                $url = add_query_arg( 'add-to-cart', $product->get_id(), home_url( '/' ) );
                $atc = '<a href="' . esc_url( $url ) . '" data-quantity="1" class="add_to_cart_button ajax_add_to_cart btn-solid flex-1 text-center" data-product_id="' . esc_attr( $product->get_id() ) . '" rel="nofollow">' . esc_html__( 'Add to cart', 'mimin' ) . '</a>';
        } else {
                $atc = '<a href="' . esc_url( $product->get_permalink() ) . '" class="btn-solid flex-1 text-center">' . esc_html__( 'Select options', 'mimin' ) . '</a>';
        }

        ob_start();
        ?>
        <div class="relative bg-white w-full max-w-[760px] grid md:grid-cols-2">
                <button id="quickview-close" class="absolute top-3 right-3 z-10 p-1.5 bg-white/80 hover:opacity-60" aria-label="<?php esc_attr_e( 'Close', 'mimin' ); ?>">
                        <?php echo mimin_icon( 'close', 20 ); // phpcs:ignore ?>
                </button>
                <div class="bg-mist flex items-center justify-center overflow-hidden">
                        <?php echo $image; // phpcs:ignore ?>
                </div>
                <div class="p-8 flex flex-col justify-center">
                        <p class="text-[13px] text-soft mb-2"><?php echo esc_html( implode( ', ', $cat ) ); ?></p>
                        <h3 class="text-[22px] font-medium leading-snug mb-3"><a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a></h3>
                        <div class="text-[17px] font-medium mb-5"><?php echo wp_kses_post( $price_html ); ?></div>
                        <p class="text-[14px] text-soft leading-relaxed mb-6"><?php echo esc_html( $desc ); ?></p>
                        <div class="flex gap-3">
                                <div class="mimin-qty">
                                        <button type="button" class="qv-qty-btn qty-minus" aria-label="<?php esc_attr_e( 'Decrease quantity', 'mimin' ); ?>">−</button>
                                        <span id="qv-qty" class="w-10 text-center text-[14px]">1</span>
                                        <button type="button" class="qv-qty-btn qty-plus" aria-label="<?php esc_attr_e( 'Increase quantity', 'mimin' ); ?>">+</button>
                                </div>
                                <?php echo $atc; // phpcs:ignore ?>
                        </div>
                </div>
        </div>
        <?php
        $html = ob_get_clean();

        wp_send_json_success( array( 'html' => $html ) );
}
add_action( 'wp_ajax_mimin_quickview', 'mimin_ajax_quickview' );
add_action( 'wp_ajax_nopriv_mimin_quickview', 'mimin_ajax_quickview' );

/* -------------------------------------------------------------------------
 * AJAX — newsletter signup
 * ---------------------------------------------------------------------- */
function mimin_ajax_newsletter() {
        check_ajax_referer( 'mimin', 'nonce' );

        $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
        if ( ! is_email( $email ) ) {
                wp_send_json_error( array( 'message' => __( 'Please enter a valid email address.', 'mimin' ) ) );
        }

        $subs   = get_option( 'mimin_subscribers', array() );
        $subs[] = array(
                'email' => $email,
                'time'  => current_time( 'mysql' ),
        );
        update_option( 'mimin_subscribers', $subs, false );

        wp_send_json_success( array( 'message' => __( 'Thanks for subscribing — check your inbox for 10% off.', 'mimin' ) ) );
}
add_action( 'wp_ajax_mimin_newsletter', 'mimin_ajax_newsletter' );
add_action( 'wp_ajax_nopriv_mimin_newsletter', 'mimin_ajax_newsletter' );

/* -------------------------------------------------------------------------
 * WooCommerce pages get the boxed container via woocommerce.php wrapper
 * ---------------------------------------------------------------------- */

/* Add wishlist/quickview data attributes handled in JS */

/* Sale badge percentage helper */
function mimin_sale_percentage( $product ) {
        if ( ! $product || ! $product->is_on_sale() ) {
                return '';
        }
        $regular = (float) $product->get_regular_price();
        $sale    = (float) $product->get_sale_price();
        if ( $regular > 0 && $sale > 0 ) {
                return '-' . round( ( 1 - $sale / $regular ) * 100 ) . '%';
        }
        return __( 'Sale', 'mimin' );
}

/* Star rating as text stars (theme style) */
function mimin_star_rating( $rating, $count = 0 ) {
        $full  = floor( $rating );
        $half  = ( $rating - $full ) >= 0.5;
        $stars = str_repeat( '★', intval( $full ) );
        if ( $half ) {
                $stars .= '★';
                $full++;
        }
        $empty = str_repeat( '<span class="text-[#D8D8D8]">★</span>', 5 - intval( $full ) );
        $label = '<span class="text-[#F0A93B] tracking-[2px]" aria-hidden="true">' . esc_html( $stars ) . $empty . '</span>';
        if ( $count ) {
                /* translators: %d: review count */
                $label .= '<span class="text-[13.5px] text-soft hover:text-black transition-colors"> (' . sprintf( _n( '%d customer review', '%d customer reviews', $count, 'mimin' ), $count ) . ')</span>';
        }
        return $label;
}
