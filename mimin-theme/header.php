<?php
/**
 * Mimin — site header.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'mimin' ); ?></a>

<?php if ( mimin_get_option( 'announcement_enable', true ) && mimin_get_option( 'announcement_text' ) ) : ?>
<!-- ══════════════════════ ANNOUNCEMENT BAR ══════════════════════ -->
<div class="bg-black text-white text-center text-[12.5px] tracking-[1px] py-2.5 px-4">
        <?php echo esc_html( mimin_get_option( 'announcement_text' ) ); ?>
</div>
<?php endif; ?>

<!-- ══════════════════════ HEADER ══════════════════════ -->
<header id="site-header" class="sticky top-0 z-40 bg-white transition-shadow duration-300">
        <div class="max-w-boxed mx-auto px-[15px]">
                <div class="grid grid-cols-[auto_1fr_auto] lg:grid-cols-[20%_60%_20%] items-center h-[76px] gap-4">

                        <!-- mobile hamburger -->
                        <button id="mobile-menu-open" class="lg:hidden p-2 -ml-2" aria-label="<?php esc_attr_e( 'Open menu', 'mimin' ); ?>">
                                <?php echo mimin_icon( 'menu', 22 ); // phpcs:ignore ?>
                        </button>

                        <!-- logo -->
                        <div class="flex items-center justify-center lg:justify-start">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-logo flex items-center" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                                        <?php mimin_logo(); ?>
                                        <span class="site-logo-text text-[20px] font-medium tracking-wide ml-2"><?php bloginfo( 'name' ); ?></span>
                                </a>
                        </div>

                        <!-- desktop nav -->
                        <nav class="hidden lg:flex items-center justify-center gap-9 text-[15px]" aria-label="<?php esc_attr_e( 'Primary menu', 'mimin' ); ?>">
                                <?php
                                wp_nav_menu( array(
                                        'theme_location' => 'primary',
                                        'container'      => false,
                                        'items_wrap'     => '%3$s',
                                        'depth'          => 3,
                                        'fallback_cb'    => 'mimin_default_menu',
                                        'walker'         => new Mimin_Walker_Desktop(),
                                ) );
                                ?>
                        </nav>

                        <!-- action icons -->
                        <div class="flex items-center justify-end gap-5">
                                <button id="search-open" class="p-1 hover:opacity-60 transition-opacity" aria-label="<?php esc_attr_e( 'Search', 'mimin' ); ?>">
                                        <?php echo mimin_icon( 'search', 20 ); // phpcs:ignore ?>
                                </button>
                                <a id="account-open" href="<?php echo esc_url( mimin_account_url() ); ?>" class="hidden md:block p-1 hover:opacity-60 transition-opacity" aria-label="<?php esc_attr_e( 'My account', 'mimin' ); ?>">
                                        <?php echo mimin_icon( 'account', 20 ); // phpcs:ignore ?>
                                </a>
                                <button id="wishlist-open" class="hidden md:block relative p-1 hover:opacity-60 transition-opacity" aria-label="<?php esc_attr_e( 'Wishlist', 'mimin' ); ?>">
                                        <?php echo mimin_icon( 'heart', 20 ); // phpcs:ignore ?>
                                        <span id="wishlist-count" class="absolute -top-0.5 -right-1.5 text-[11px] leading-none hidden">0</span>
                                </button>
                                <button id="cart-open" class="relative p-1 hover:opacity-60 transition-opacity" aria-label="<?php esc_attr_e( 'Cart', 'mimin' ); ?>">
                                        <?php echo mimin_icon( 'bag', 20 ); // phpcs:ignore ?>
                                        <?php
                                        $count = function_exists( 'mimin_cart_count' ) ? mimin_cart_count() : 0;
                                        ?>
                                        <span id="cart-count" class="absolute -top-0.5 -right-1.5 text-[11px] leading-none<?php echo $count ? '' : ' hidden'; ?>"><?php echo esc_html( $count ); ?></span>
                                </button>
                        </div>
                </div>
        </div>
</header>

<!-- ══════════════════════ MOBILE MENU DRAWER ══════════════════════ -->
<div id="mobile-menu-backdrop" class="modal-backdrop fixed inset-0 z-[60] bg-black/60 opacity-0 invisible"></div>
<aside id="mobile-menu" class="overlay-panel fixed left-0 top-0 bottom-0 z-[70] w-[320px] max-w-[85vw] bg-white -translate-x-full invisible flex flex-col" aria-label="<?php esc_attr_e( 'Mobile menu', 'mimin' ); ?>">
        <div class="flex items-center justify-between px-6 h-[76px] border-b border-line">
                <?php mimin_logo(); ?>
                <button id="mobile-menu-close" class="p-2 -mr-2 hover:opacity-60" aria-label="<?php esc_attr_e( 'Close menu', 'mimin' ); ?>">
                        <?php echo mimin_icon( 'close', 20 ); // phpcs:ignore ?>
                </button>
        </div>
        <nav class="thin-scroll flex-1 overflow-y-auto px-6 py-6 text-[15px]" aria-label="<?php esc_attr_e( 'Mobile menu', 'mimin' ); ?>">
                <ul class="divide-y divide-line">
                        <?php
                        wp_nav_menu( array(
                                'theme_location' => 'primary',
                                'container'      => false,
                                'items_wrap'     => '%3$s',
                                'depth'          => 3,
                                'fallback_cb'    => 'mimin_default_menu',
                                'walker'         => new Mimin_Walker_Mobile(),
                        ) );
                        ?>
                </ul>
        </nav>
        <div class="px-6 py-5 border-t border-line text-[14px] text-soft space-y-2">
                <?php $email = mimin_get_option( 'contact_email' ); $phone = mimin_get_option( 'contact_phone' ); ?>
                <?php if ( $email ) : ?>
                        <p>Email: <a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-black"><?php echo esc_html( $email ); ?></a></p>
                <?php endif; ?>
                <?php if ( $phone ) : ?>
                        <p>Call Us: <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>" class="text-black"><?php echo esc_html( $phone ); ?></a></p>
                <?php endif; ?>
        </div>
</aside>

<!-- ══════════════════════ SEARCH POPUP ══════════════════════ -->
<div id="search-modal" class="modal-backdrop fixed inset-0 z-[80] bg-black/85 opacity-0 invisible flex items-center justify-center p-5" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Search', 'mimin' ); ?>">
        <div class="w-full max-w-[720px]">
                <div class="flex items-center justify-between mb-6">
                        <h3 class="text-white text-[18px] font-medium tracking-wide"><?php esc_html_e( 'Search our store', 'mimin' ); ?></h3>
                        <button id="search-close" class="text-white/80 hover:text-white transition-colors" aria-label="<?php esc_attr_e( 'Close search', 'mimin' ); ?>">
                                <?php echo mimin_icon( 'close', 26, 'stroke-width="1.4"' ); // phpcs:ignore ?>
                        </button>
                </div>
                <form role="search" method="get" class="flex items-center gap-4 bg-white px-6" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php echo mimin_icon( 'search', 20, 'class="shrink-0"' ); // phpcs:ignore ?>
                        <input type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( "I'm looking for...", 'mimin' ); ?>" class="flex-1 h-[64px] bg-transparent outline-none text-[16px] placeholder:text-soft">
                        <button type="submit" class="text-[13px] tracking-[1px] uppercase hover:opacity-60 transition-opacity shrink-0"><?php esc_html_e( 'Search', 'mimin' ); ?></button>
                </form>
                <p class="text-white/50 text-[13px] mt-4 tracking-wide"><?php esc_html_e( 'Popular: side table, accent chair, lamp, bench', 'mimin' ); ?></p>
        </div>
</div>

<!-- ══════════════════════ CART DRAWER ══════════════════════ -->
<div id="cart-backdrop" class="modal-backdrop fixed inset-0 z-[60] bg-black/60 opacity-0 invisible"></div>
<aside id="cart-drawer" class="overlay-panel fixed right-0 top-0 bottom-0 z-[70] w-[400px] max-w-[92vw] bg-white translate-x-full invisible flex flex-col" aria-label="<?php esc_attr_e( 'Shopping cart', 'mimin' ); ?>">
        <div class="flex items-center justify-between px-7 h-[76px] border-b border-line">
                <h3 class="text-[18px] font-medium"><?php esc_html_e( 'Your Cart', 'mimin' ); ?></h3>
                <button id="cart-close" class="p-2 -mr-2 hover:opacity-60" aria-label="<?php esc_attr_e( 'Close cart', 'mimin' ); ?>">
                        <?php echo mimin_icon( 'close', 20 ); // phpcs:ignore ?>
                </button>
        </div>
        <div id="cart-items" class="thin-scroll flex-1 overflow-y-auto px-7 py-6">
                <?php
                if ( function_exists( 'woocommerce_mini_cart' ) ) {
                        mimin_cart_drawer_items();
                } else {
                        echo '<div class="h-full flex flex-col items-center justify-center text-center gap-5 py-16">';
                        echo mimin_icon( 'bag', 54, 'stroke="#d5d5d5" stroke-width="1.2"' ); // phpcs:ignore
                        echo '<p class="text-soft text-[14.5px]">' . esc_html__( 'Install WooCommerce to start selling.', 'mimin' ) . '</p>';
                        echo '</div>';
                }
                ?>
        </div>
        <?php if ( function_exists( 'wc_get_cart_url' ) ) : ?>
        <div id="cart-footer" class="border-t border-line px-7 py-6">
                <div class="grid grid-cols-2 gap-3">
                        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="btn-outline text-center"><?php esc_html_e( 'View Cart', 'mimin' ); ?></a>
                        <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="btn-solid text-center"><?php esc_html_e( 'Checkout', 'mimin' ); ?></a>
                </div>
        </div>
        <?php endif; ?>
</aside>

<!-- ══════════════════════ QUICK VIEW MODAL ══════════════════════ -->
<div id="quickview-modal" class="modal-backdrop fixed inset-0 z-[80] bg-black/85 opacity-0 invisible flex items-center justify-center p-5" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Quick view', 'mimin' ); ?>">
        <div id="quickview-body"></div>
</div>

<main id="main" class="site-main">
