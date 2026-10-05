<?php
/**
 * Mimin — template tags & helpers.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

/* -------------------------------------------------------------------------
 * SVG icons
 * ---------------------------------------------------------------------- */
function mimin_icon( $name, $size = 20, $extra = '' ) {
        $a = 'width="' . esc_attr( $size ) . '" height="' . esc_attr( $size ) . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"';
        $icons = array(
                'search'     => '<circle cx="11" cy="11" r="7"/><path d="m21 21-4.3-4.3"/>',
                'account'    => '<circle cx="12" cy="8" r="4"/><path d="M5 21c.9-4 3.6-6 7-6s6.1 2 7 6"/>',
                'heart'      => '<path d="M12 20.5S3.5 15.5 3.5 9.3A4.8 4.8 0 0 1 12 6.4a4.8 4.8 0 0 1 8.5 2.9c0 6.2-8.5 11.2-8.5 11.2Z"/>',
                'bag'        => '<path d="M5 8h14l-1.2 12.2a1.8 1.8 0 0 1-1.8 1.6H8a1.8 1.8 0 0 1-1.8-1.6L5 8Z"/><path d="M8.5 10V6.5a3.5 3.5 0 0 1 7 0V10"/>',
                'close'      => '<path d="M18 6 6 18M6 6l12 12"/>',
                'chevron'    => '<path d="m6 9 6 6 6-6"/>',
                'chevron-l'  => '<path d="M15 18l-6-6 6-6"/>',
                'chevron-r'  => '<path d="m9 6 6 6-6 6"/>',
                'eye'        => '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/>',
                'compare'    => '<path d="M8 3 4 7l4 4"/><path d="M4 7h16"/><path d="m16 21 4-4-4-4"/><path d="M20 17H4"/>',
                'arrow-up'   => '<path d="m18 15-6-6-6 6"/>',
                'play'       => '<path d="M8 5.5v13l11-6.5-11-6.5Z"/>',
                'filter'     => '<path d="M3 6h18M7 12h10M10 18h4"/>',
                'grid'       => '<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/>',
                'list'       => '<path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>',
                'facebook'   => '<path d="M13.5 21v-8h2.7l.4-3.2h-3.1V7.7c0-.9.3-1.6 1.6-1.6h1.6V3.2c-.3 0-1.3-.1-2.4-.1-2.4 0-4 1.4-4 4.1v2.6H7.6V13h2.7v8h3.2Z"/>',
                'x'          => '<path d="M17.8 3h3l-6.6 7.6L22 21h-6.1l-4.8-6.3L5.6 21h-3l7.1-8.1L2 3h6.3l4.3 5.7L17.8 3Zm-1.1 16.2h1.7L7.4 4.7H5.6l11.1 14.5Z"/>',
                'youtube'    => '<path d="M22 8.2a3 3 0 0 0-2.1-2.1C18 5.5 12 5.5 12 5.5s-6 0-7.9.6A3 3 0 0 0 2 8.2 31 31 0 0 0 1.6 12 31 31 0 0 0 2 15.8a3 3 0 0 0 2.1 2.1c1.9.6 7.9.6 7.9.6s6 0 7.9-.6a3 3 0 0 0 2.1-2.1A31 31 0 0 0 22.4 12 31 31 0 0 0 22 8.2ZM9.9 14.9V9.1l5.4 2.9-5.4 2.9Z"/>',
                'pinterest'  => '<path d="M12 2C6.5 2 2 6.5 2 12c0 4.2 2.6 7.9 6.4 9.3-.1-.8-.2-2 0-2.9l1.2-4.9s-.3-.6-.3-1.5c0-1.4.8-2.4 1.8-2.4.9 0 1.3.6 1.3 1.4 0 .9-.6 2.2-.9 3.4-.2 1 .5 1.8 1.5 1.8 1.8 0 3.2-1.9 3.2-4.7 0-2.4-1.7-4.1-4.2-4.1-2.9 0-4.6 2.2-4.6 4.4 0 .9.3 1.8.8 2.3.1.1.1.2.1.3l-.3 1.1c0 .2-.1.2-.3.1-1.2-.6-2-2.4-2-3.9 0-3.2 2.3-6.1 6.7-6.1 3.5 0 6.2 2.5 6.2 5.8 0 3.5-2.2 6.3-5.3 6.3-1 0-2-.5-2.3-1.2l-.6 2.4c-.2.9-.8 2-1.2 2.6.9.3 1.9.4 2.9.4 5.5 0 10-4.5 10-10S17.5 2 12 2Z"/>',
                'instagram'  => '<rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.2" cy="6.8" r="1"/>',
                'menu'       => '<path d="M3 6h18M3 12h18M3 18h18"/>',
        );
        $fill = in_array( $name, array( 'facebook', 'x', 'youtube', 'pinterest', 'play' ), true ) ? ' fill="currentColor" stroke="none"' : '';
        $path = isset( $icons[ $name ] ) ? $icons[ $name ] : '';
        return '<svg ' . $a . $fill . ' ' . $extra . ' aria-hidden="true">' . $path . '</svg>';
}

/* -------------------------------------------------------------------------
 * Logo
 * ---------------------------------------------------------------------- */
function mimin_logo( $class = 'h-6 w-auto' ) {
        if ( has_custom_logo() ) {
                $id  = get_theme_mod( 'custom_logo' );
                $img = wp_get_attachment_image( $id, 'medium', false, array( 'class' => $class ) );
                echo $img; // phpcs:ignore
                return;
        }
        $url = get_theme_file_uri( 'assets/img/logo.svg' );
        echo '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" class="' . esc_attr( $class ) . '">';
}

/* -------------------------------------------------------------------------
 * Site header height (used by fixed mega menu positioning)
 * ---------------------------------------------------------------------- */
function mimin_header_height() {
        return 76;
}

/* -------------------------------------------------------------------------
 * Breadcrumbs: Home › Shop › Product / Home › Blog › Category
 * ---------------------------------------------------------------------- */
function mimin_breadcrumbs() {
        $items = array( array( 'label' => __( 'Home', 'mimin' ), 'url' => home_url( '/' ) ) );

        if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
                $shop_id = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
                if ( is_shop() ) {
                        $items[] = array( 'label' => woocommerce_page_title( false ), 'url' => '' );
                } else {
                        $items[] = array( 'label' => get_the_title( $shop_id ), 'url' => get_permalink( $shop_id ) );
                        if ( is_product() ) {
                                $items[] = array( 'label' => get_the_title(), 'url' => '' );
                        } elseif ( is_product_taxonomy() ) {
                                $items[] = array( 'label' => single_term_title( '', false ), 'url' => '' );
                        }
                }
        } elseif ( is_home() ) {
                $items[] = array( 'label' => get_theme_mod( 'mimin_blog_title', 'Blog' ), 'url' => '' );
        } elseif ( is_singular( 'post' ) ) {
                $blog = get_option( 'page_for_posts' );
                if ( $blog ) {
                        $items[] = array( 'label' => get_the_title( $blog ), 'url' => get_permalink( $blog ) );
                } else {
                        $items[] = array( 'label' => __( 'Blog', 'mimin' ), 'url' => home_url( '/?post_type=post' ) );
                }
                $items[] = array( 'label' => get_the_title(), 'url' => '' );
        } elseif ( is_archive() ) {
                $items[] = array( 'label' => get_the_archive_title(), 'url' => '' );
        } elseif ( is_search() ) {
                /* translators: %s: search query */
                $items[] = array( 'label' => sprintf( __( 'Search: %s', 'mimin' ), get_search_query() ), 'url' => '' );
        } elseif ( is_page() ) {
                $items[] = array( 'label' => get_the_title(), 'url' => '' );
        } elseif ( is_404() ) {
                $items[] = array( 'label' => __( 'Page not found', 'mimin' ), 'url' => '' );
        }

        echo '<nav class="py-7 text-[13.5px] text-soft flex items-center gap-2.5 flex-wrap" aria-label="' . esc_attr__( 'Breadcrumb', 'mimin' ) . '">';
        $last = count( $items ) - 1;
        foreach ( $items as $i => $item ) {
                if ( $i > 0 ) {
                        echo '<span class="text-[11px]">&rsaquo;</span>';
                }
                if ( $i === $last || empty( $item['url'] ) ) {
                        echo '<span class="text-black">' . esc_html( $item['label'] ) . '</span>';
                } else {
                        echo '<a href="' . esc_url( $item['url'] ) . '" class="hover:text-black transition-colors">' . esc_html( $item['label'] ) . '</a>';
                }
        }
        echo '</nav>';
}

/* -------------------------------------------------------------------------
 * Page header used by blog / archive / search / page templates
 * ---------------------------------------------------------------------- */
function mimin_page_header( $title, $subtitle = '' ) {
        ?>
        <section class="bg-smoke">
                <div class="max-w-boxed mx-auto px-[15px] py-14 lg:py-20 text-center">
                        <h1 class="text-[32px] sm:text-[40px] lg:text-[46px] leading-tight font-normal"><?php echo esc_html( $title ); ?></h1>
                        <?php if ( $subtitle ) : ?>
                                <p class="text-soft text-[14.5px] max-w-[560px] leading-relaxed mx-auto mt-4"><?php echo esc_html( $subtitle ); ?></p>
                        <?php endif; ?>
                </div>
        </section>
        <?php
}

/* -------------------------------------------------------------------------
 * Post meta line (date · category)
 * ---------------------------------------------------------------------- */
function mimin_post_meta() {
        echo '<div class="flex items-center gap-4 text-[12.5px] text-soft tracking-wide">';
        echo '<time datetime="' . esc_attr( get_the_date( 'c' ) ) . '">' . esc_html( get_the_date() ) . '</time>';
        $cats = get_the_category_list( ', ' );
        if ( $cats ) {
                echo '<span>' . wp_kses_post( $cats ) . '</span>';
        }
        echo '</div>';
}

/* -------------------------------------------------------------------------
 * Pagination (theme-styled page buttons)
 * ---------------------------------------------------------------------- */
function mimin_pagination() {
        the_posts_pagination( array(
                'mid_size'  => 1,
                'class'     => 'mimin-pagination',
                'prev_text' => mimin_icon( 'chevron-l', 15 ),
                'next_text' => mimin_icon( 'chevron-r', 15 ),
        ) );
}

/* -------------------------------------------------------------------------
 * Desktop menu walker — hover dropdowns + optional full-width mega panel.
 * Add the CSS class "mm-mega" to a top-level menu item to render its
 * children as columns inside a full-width panel under the header.
 * ---------------------------------------------------------------------- */
class Mimin_Walker_Desktop extends Walker_Nav_Menu {

        function start_lvl( &$output, $depth = 0, $args = null ) {
                $output .= "\n";
        }

        function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output = '' ) {
                if ( ! $element ) { return; }

                $id_field = $this->db_fields['id'];
                $classes  = empty( $element->classes ) ? array() : (array) $element->classes;
                $has_children = ! empty( $children_elements[ $element->$id_field ] );
                $is_mega  = in_array( 'mm-mega', $classes, true );
                $title    = apply_filters( 'the_title', $element->title, $element->ID );
                $href     = $element->url ? $element->url : '#';

                if ( 0 === $depth ) {
                        $caret = '<svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg>';

                        if ( $has_children && $is_mega ) {
                                $output .= '<div class="static group">';
                                $output .= '<a href="' . esc_url( $href ) . '" class="nav-link inline-flex items-center gap-1.5 py-2">' . esc_html( $title ) . $caret . '</a>';
                                $output .= '<div class="fixed left-0 right-0 top-[76px] opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">';
                                $output .= '<div class="bg-white border-t border-line shadow-[0_30px_60px_rgba(0,0,0,.09)]">';
                                $output .= '<div class="max-w-boxed mx-auto px-[15px] py-10 grid grid-cols-2 lg:grid-cols-6 gap-8">';
                                foreach ( $children_elements[ $element->$id_field ] as $col ) {
                                        $col_title = apply_filters( 'the_title', $col->title, $col->ID );
                                        $col_href  = $col->url ? $col->url : '#';
                                        $output   .= '<div>';
                                        $output   .= '<h4 class="text-[16px] font-medium mb-5"><a href="' . esc_url( $col_href ) . '">' . esc_html( $col_title ) . '</a></h4>';
                                        if ( isset( $children_elements[ $col->$id_field ] ) ) {
                                                $output .= '<ul class="space-y-2.5 text-[14px] text-soft">';
                                                foreach ( $children_elements[ $col->$id_field ] as $link ) {
                                                        $link_title = apply_filters( 'the_title', $link->title, $link->ID );
                                                        $link_href  = $link->url ? $link->url : '#';
                                                        $output    .= '<li><a class="hover:text-black transition-colors" href="' . esc_url( $link_href ) . '">' . esc_html( $link_title ) . '</a></li>';
                                                }
                                                $output .= '</ul>';
                                        }
                                        $output .= '</div>';
                                }
                                $output .= '</div></div></div>';
                        } elseif ( $has_children ) {
                                $output .= '<div class="relative group">';
                                $output .= '<a href="' . esc_url( $href ) . '" class="nav-link inline-flex items-center gap-1.5 py-2">' . esc_html( $title ) . $caret . '</a>';
                                $output .= '<div class="absolute left-1/2 -translate-x-1/2 top-full pt-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">';
                                $output .= '<ul class="w-[190px] bg-white border border-line shadow-[0_18px_40px_rgba(0,0,0,.08)] py-4">';
                                foreach ( $children_elements[ $element->$id_field ] as $item ) {
                                        $item_title = apply_filters( 'the_title', $item->title, $item->ID );
                                        $item_href  = $item->url ? $item->url : '#';
                                        $output    .= '<li><a class="block px-6 py-2 text-[14px] text-soft hover:text-black transition-colors" href="' . esc_url( $item_href ) . '">' . esc_html( $item_title ) . '</a></li>';
                                }
                                $output .= '</ul></div></div>';
                        } else {
                                $current = in_array( 'current-menu-item', $classes, true ) ? ' active' : '';
                                $output .= '<a href="' . esc_url( $href ) . '" class="nav-link' . esc_attr( $current ) . ' py-2">' . esc_html( $title ) . '</a>';
                        }
                }

                if ( $has_children && ( 0 !== $depth || $is_mega ) ) {
                        unset( $children_elements[ $element->$id_field ] );
                }
        }
}

/* -------------------------------------------------------------------------
 * Mobile menu walker — accordion drawers
 * ---------------------------------------------------------------------- */
class Mimin_Walker_Mobile extends Walker_Nav_Menu {

        function start_lvl( &$output, $depth = 0, $args = null ) { $output .= "\n"; }
        function end_lvl( &$output, $depth = 0, $args = null ) { $output .= "\n"; }

        function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args = array(), &$output = '' ) {
                if ( ! $element ) { return; }
                $id_field = $this->db_fields['id'];
                $has_children = ! empty( $children_elements[ $element->$id_field ] );
                $title = apply_filters( 'the_title', $element->title, $element->ID );
                $href  = $element->url ? $element->url : '#';

                if ( $depth > 0 ) {
                        $output .= '<li class="py-2"><a href="' . esc_url( $href ) . '">' . esc_html( $title ) . '</a></li>';
                } elseif ( $has_children ) {
                        $output .= '<li class="py-3">';
                        $output .= '<button class="acc-head w-full flex items-center justify-between" data-acc><span>' . esc_html( $title ) . '</span>';
                        $output .= '<svg class="acc-arrow transition-transform duration-300" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m6 9 6 6 6-6"/></svg></button>';
                        $output .= '<ul class="acc-body pl-4 text-[14px] text-soft">';
                        foreach ( $children_elements[ $element->$id_field ] as $child ) {
                                $this->display_element( $child, $children_elements, $max_depth, 1, $args, $output );
                        }
                        $output .= '</ul></li>';
                } else {
                        $output .= '<li class="py-3"><a href="' . esc_url( $href ) . '" class="block">' . esc_html( $title ) . '</a></li>';
                }

                unset( $children_elements[ $element->$id_field ] );
        }
}

/* -------------------------------------------------------------------------
 * Fallback menus (shown before the user assigns menus)
 * ---------------------------------------------------------------------- */
function mimin_default_menu() {
        $shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
        $items = array(
                array( __( 'Home', 'mimin' ), home_url( '/' ) ),
                array( __( 'Shop', 'mimin' ), $shop_url ),
                array( __( 'Blog', 'mimin' ), home_url( '/?post_type=post' ) ),
                array( __( 'Cart', 'mimin' ), function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : home_url( '/' ) ),
        );
        foreach ( $items as $item ) {
                printf(
                        '<a href="%1$s" class="nav-link py-2">%2$s</a>',
                        esc_url( $item[1] ),
                        esc_html( $item[0] )
                );
        }
}

function mimin_footer_information_fallback() {
        $shop_url = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'shop' ) : home_url( '/' );
        echo '<ul class="space-y-3 text-[14.5px] text-soft">';
        foreach ( array(
                array( __( 'My Account', 'mimin' ), mimin_account_url() ),
                array( __( 'Cart', 'mimin' ), function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : $shop_url ),
                array( __( 'Checkout', 'mimin' ), function_exists( 'wc_get_checkout_url' ) ? wc_get_checkout_url() : $shop_url ),
                array( __( 'Shop', 'mimin' ), $shop_url ),
                array( __( 'Blog', 'mimin' ), home_url( '/?post_type=post' ) ),
        ) as $link ) {
                printf( '<li><a href="%1$s" class="hover:text-black transition-colors">%2$s</a></li>', esc_url( $link[1] ), esc_html( $link[0] ) );
        }
        echo '</ul>';
}

function mimin_footer_about_fallback() {
        echo '<ul class="space-y-3 text-[14.5px] text-soft">';
        foreach ( array(
                array( __( 'Blog', 'mimin' ), home_url( '/?post_type=post' ) ),
                array( __( 'Search', 'mimin' ), home_url( '/' ) ),
                array( __( 'Archives', 'mimin' ), home_url( '/?post_type=post' ) ),
        ) as $link ) {
                printf( '<li><a href="%1$s" class="hover:text-black transition-colors">%2$s</a></li>', esc_url( $link[1] ), esc_html( $link[0] ) );
        }
        echo '</ul>';
}

function mimin_footer_legal_fallback() {
        echo '<ul class="flex flex-wrap justify-center gap-x-7 gap-y-2 text-[13.5px] text-soft">';
        foreach ( array(
                array( __( 'Terms of Use', 'mimin' ), home_url( '/?p=1' ) ),
                array( __( 'Privacy Policy', 'mimin' ), home_url( '/?p=1' ) ),
        ) as $link ) {
                printf( '<li><a href="%1$s" class="hover:text-black transition-colors">%2$s</a></li>', esc_url( $link[1] ), esc_html( $link[0] ) );
        }
        echo '</ul>';
}

/* -------------------------------------------------------------------------
 * Customizer option helper
 * ---------------------------------------------------------------------- */
function mimin_get_option( $key, $default = '' ) {
        $value = get_theme_mod( 'mimin_' . $key, $default );
        return $value;
}

/* Customizer image with theme-asset fallback */
function mimin_img_url( $key, $fallback_file ) {
        $value = mimin_get_option( $key );
        return $value ? $value : get_theme_file_uri( 'assets/img/' . $fallback_file );
}
