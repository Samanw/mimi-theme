<?php
/**
 * Mimin — theme setup & bootstrap.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

define( 'MIMIN_VERSION', '1.0.0' );

/* -------------------------------------------------------------------------
 * Theme supports
 * ---------------------------------------------------------------------- */
function mimin_setup() {
	load_theme_textdomain( 'mimin', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'custom-logo', array(
		'height'      => 48,
		'width'       => 160,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'mimin' ),
		'footer_information' => __( 'Footer — Information', 'mimin' ),
		'footer_about'       => __( 'Footer — About Us', 'mimin' ),
		'footer_legal'       => __( 'Footer — Legal (bottom bar)', 'mimin' ),
	) );

	add_image_size( 'mimin-product', 600, 600, true );
	add_image_size( 'mimin-blog', 720, 480, true );
	add_image_size( 'mimin-blog-wide', 1200, 560, true );
}
add_action( 'after_setup_theme', 'mimin_setup' );

/* -------------------------------------------------------------------------
 * Content width
 * ---------------------------------------------------------------------- */
function mimin_content_width() {
	$GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'mimin_content_width', 0 );

/* -------------------------------------------------------------------------
 * Enqueue styles & scripts
 * ---------------------------------------------------------------------- */
function mimin_scripts() {
	/* Jost font (Futura substitute used by the demo) */
	wp_enqueue_style(
		'mimin-fonts',
		'https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500;600&display=swap',
		array(),
		null
	);

	wp_enqueue_style( 'mimin-style', get_stylesheet_uri(), array(), MIMIN_VERSION );
	wp_enqueue_style( 'mimin-theme', get_theme_file_uri( 'assets/css/theme.css' ), array( 'mimin-style' ), MIMIN_VERSION );

	if ( class_exists( 'WooCommerce' ) ) {
		wp_enqueue_style( 'mimin-woocommerce', get_theme_file_uri( 'assets/css/woocommerce.css' ), array( 'mimin-theme' ), MIMIN_VERSION );
		wp_enqueue_script( 'wc-cart-fragments' );
	}

	wp_enqueue_script( 'mimin-main', get_theme_file_uri( 'assets/js/mimin.js' ), array( 'jquery' ), MIMIN_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_localize_script( 'mimin-main', 'miminData', array(
		'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'mimin' ),
		'cartUrl'  => function_exists( 'wc_get_cart_url' ) ? wc_get_cart_url() : '',
		'isWoo'    => class_exists( 'WooCommerce' ),
		'i18n'     => array(
			'added'      => __( 'Added to cart', 'mimin' ),
			'wishAdd'    => __( 'Added to wishlist', 'mimin' ),
			'wishRemove' => __( 'Removed from wishlist', 'mimin' ),
			'wishList'   => __( 'Your wishlist is empty.', 'mimin' ),
			'wishItems'  => __( 'items in your wishlist.', 'mimin' ),
			'compare'    => __( 'Compare list is available via a comparison plugin.', 'mimin' ),
		),
	) );
}
add_action( 'wp_enqueue_scripts', 'mimin_scripts' );

/* Preconnect for Google Fonts */
function mimin_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'mimin_resource_hints', 10, 2 );

/* -------------------------------------------------------------------------
 * Widget areas
 * ---------------------------------------------------------------------- */
function mimin_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'mimin' ),
		'id'            => 'sidebar-blog',
		'description'   => __( 'Widgets shown next to blog listings and posts.', 'mimin' ),
		'before_widget' => '<div id="%1$s" class="widget-block widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );

	register_sidebar( array(
		'name'          => __( 'Shop Filters Sidebar', 'mimin' ),
		'id'            => 'sidebar-shop',
		'description'   => __( 'Drop WooCommerce filter widgets here (Price filter, Product categories, Filter by attribute, Rating filter, Products, Product tags…). Falls back to demo filters when empty.', 'mimin' ),
		'before_widget' => '<div id="%1$s" class="widget-block widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'mimin_widgets_init' );

/* -------------------------------------------------------------------------
 * Includes
 * ---------------------------------------------------------------------- */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/woo.php';
}

/* -------------------------------------------------------------------------
 * Misc helpers
 * ---------------------------------------------------------------------- */

/* Excerpt */
add_filter( 'excerpt_length', function () { return 26; } );
add_filter( 'excerpt_more', function () { return '…'; } );

/* Body classes */
function mimin_body_classes( $classes ) {
	$classes[] = 'antialiased text-black bg-white';
	if ( has_custom_logo() ) {
		$classes[] = 'custom-logo';
	}
	return $classes;
}
add_filter( 'body_class', 'mimin_body_classes' );

/* Search form covers products too */
function mimin_search_filter( $query ) {
	if ( ! is_admin() && $query->is_main_query() && $query->is_search() ) {
		/* keep everything searchable */
	}
	return $query;
}
add_filter( 'pre_get_posts', 'mimin_search_filter' );

/* Woo gallery columns / thumbnails */
add_filter( 'woocommerce_single_product_image_gallery_classes', function ( $classes ) {
	$classes[] = 'mimin-gallery';
	return $classes;
} );

/* Fallback account URL (Woo my-account or wp-login) */
function mimin_account_url() {
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		return wc_get_page_permalink( 'myaccount' );
	}
	return wp_login_url();
}
