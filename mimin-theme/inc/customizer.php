<?php
/**
 * Mimin — Customizer options (Home 5 sections, socials, footer).
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

function mimin_customize_register( $wp_customize ) {

	$wp_customize->add_panel( 'mimin_panel', array(
		'title'    => __( 'Mimin Theme Options', 'mimin' ),
		'priority' => 10,
	) );

	/* helpers -------------------------------------------------------- */
	$add = function ( $id, $label, $default, $section, $type = 'text', $sanitize = 'sanitize_text_field' ) use ( $wp_customize ) {
		$wp_customize->add_setting( 'mimin_' . $id, array(
			'default'           => $default,
			'sanitize_callback' => $sanitize,
			'transport'         => 'refresh',
		) );
		$args = array( 'label' => $label, 'section' => $section, 'type' => $type );
		if ( 'image' === $type ) {
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'mimin_' . $id, array(
				'label'   => $label,
				'section' => $section,
			) ) );
		} elseif ( 'url' === $type ) {
			$args['type'] = 'url';
			$wp_customize->add_control( 'mimin_' . $id, $args );
		} else {
			$wp_customize->add_control( 'mimin_' . $id, $args );
		}
	};

	/* ---------------------------------------------------------------- */
	/* Announcement bar                                                  */
	/* ---------------------------------------------------------------- */
	$wp_customize->add_section( 'mimin_announcement', array(
		'title' => __( 'Announcement Bar', 'mimin' ),
		'panel' => 'mimin_panel',
	) );
	$add( 'announcement_enable', __( 'Show announcement bar', 'mimin' ), true, 'mimin_announcement', 'checkbox', 'wp_validate_boolean' );
	$add( 'announcement_text', __( 'Announcement text', 'mimin' ), 'Free shipping on orders over $50 — easy 30-day returns', 'mimin_announcement' );

	/* ---------------------------------------------------------------- */
	/* Hero slider — 3 slides                                            */
	/* ---------------------------------------------------------------- */
	$wp_customize->add_section( 'mimin_hero', array(
		'title'       => __( 'Hero Slider', 'mimin' ),
		'description' => __( 'Three slides. Leave a title empty to hide that slide.', 'mimin' ),
		'panel'       => 'mimin_panel',
	) );

	$hero_defaults = array(
		1 => array( 'bg' => '#D5E4E1', 'title' => 'Minimal Watches', 'desc' => 'Simplicity is the ultimate sophistication. Our minimal watches are designed with purpose — refined, functional, and effortlessly elegant', 'btn' => 'Shop Now', 'url' => '/shop/', 'img' => 'image-41.png' ),
		2 => array( 'bg' => '#D5E4E1', 'title' => 'Accent Chairs', 'desc' => 'More than just a seat, an accent chair defines the mood of your space. Soft, inviting, and effortlessly stylish — made for moments of comfort and quiet relaxation', 'btn' => 'Shop Now', 'url' => '/shop/', 'img' => 'image-42.png' ),
		3 => array( 'bg' => '#F0F0F0', 'title' => 'Classic Perfection', 'desc' => 'Where heritage meets precision. Each detail is carefully considered to deliver a watch that reflects true sophistication — subtle, confident, and undeniably classic', 'btn' => 'Shop Now', 'url' => '/shop/', 'img' => 'image-42.png' ),
	);

	for ( $i = 1; $i <= 3; $i++ ) {
		$wp_customize->add_setting( 'mimin_hero_bg_' . $i, array(
			'default'           => $hero_defaults[ $i ]['bg'],
			'sanitize_callback' => 'sanitize_hex_color',
		) );
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'mimin_hero_bg_' . $i, array(
			'label'   => sprintf( __( 'Slide %d — background color', 'mimin' ), $i ),
			'section' => 'mimin_hero',
		) ) );
		$add( 'hero_title_' . $i, sprintf( __( 'Slide %d — title', 'mimin' ), $i ), $hero_defaults[ $i ]['title'], 'mimin_hero' );
		$add( 'hero_desc_' . $i, sprintf( __( 'Slide %d — description', 'mimin' ), $i ), $hero_defaults[ $i ]['desc'], 'mimin_hero' );
		$add( 'hero_btn_' . $i, sprintf( __( 'Slide %d — button label', 'mimin' ), $i ), $hero_defaults[ $i ]['btn'], 'mimin_hero' );
		$add( 'hero_url_' . $i, sprintf( __( 'Slide %d — button link', 'mimin' ), $i ), $hero_defaults[ $i ]['url'], 'mimin_hero', 'url', 'esc_url_raw' );
		$add( 'hero_img_' . $i, sprintf( __( 'Slide %d — image', 'mimin' ), $i ), '', 'mimin_hero', 'image' );
	}

	/* ---------------------------------------------------------------- */
	/* Category banners — 4 squares                                      */
	/* ---------------------------------------------------------------- */
	$wp_customize->add_section( 'mimin_banners', array(
		'title'       => __( 'Category Banners', 'mimin' ),
		'description' => __( 'Four square banners shown under the hero. Leave a label empty to hide that banner.', 'mimin' ),
		'panel'       => 'mimin_panel',
	) );
	$banner_defaults = array(
		1 => array( 'Home Decor', 'image-43.jpg' ),
		2 => array( 'Living Room', 'image-44.jpg' ),
		3 => array( 'Lighting', 'image-45.jpg' ),
		4 => array( 'Furniture', 'image-46.jpg' ),
	);
	for ( $i = 1; $i <= 4; $i++ ) {
		$add( 'banner_label_' . $i, sprintf( __( 'Banner %d — label', 'mimin' ), $i ), $banner_defaults[ $i ][0], 'mimin_banners' );
		$add( 'banner_url_' . $i, sprintf( __( 'Banner %d — link', 'mimin' ), $i ), '/shop/', 'mimin_banners', 'url', 'esc_url_raw' );
		$add( 'banner_img_' . $i, sprintf( __( 'Banner %d — image', 'mimin' ), $i ), '', 'mimin_banners', 'image' );
	}

	/* ---------------------------------------------------------------- */
	/* Best sellers                                                      */
	/* ---------------------------------------------------------------- */
	$wp_customize->add_section( 'mimin_best', array(
		'title'       => __( 'Best Sellers', 'mimin' ),
		'description' => __( 'Tabs are generated from your top-level product categories (needs WooCommerce).', 'mimin' ),
		'panel'       => 'mimin_panel',
	) );
	$add( 'best_enable', __( 'Show Best Sellers section', 'mimin' ), true, 'mimin_best', 'checkbox', 'wp_validate_boolean' );
	$add( 'best_title', __( 'Section title', 'mimin' ), 'Best Sellers', 'mimin_best' );
	$add( 'best_count', __( 'Products per tab', 'mimin' ), '8', 'mimin_best' );
	$add( 'best_more_label', __( 'Button label', 'mimin' ), 'Shop More', 'mimin_best' );

	/* ---------------------------------------------------------------- */
	/* Video banner                                                      */
	/* ---------------------------------------------------------------- */
	$wp_customize->add_section( 'mimin_video', array(
		'title' => __( 'Video Banner', 'mimin' ),
		'panel' => 'mimin_panel',
	) );
	$add( 'video_enable', __( 'Show video banner', 'mimin' ), true, 'mimin_video', 'checkbox', 'wp_validate_boolean' );
	$add( 'video_poster', __( 'Poster image', 'mimin' ), '', 'mimin_video', 'image' );
	$add( 'video_url', __( 'Video URL (mp4)', 'mimin' ), 'https://storage.googleapis.com/gtv-videos-bucket/sample/BigBuckBunny.mp4', 'mimin_video', 'url', 'esc_url_raw' );

	/* ---------------------------------------------------------------- */
	/* Lookbook                                                          */
	/* ---------------------------------------------------------------- */
	$wp_customize->add_section( 'mimin_lookbook', array(
		'title'       => __( 'Lookbook', 'mimin' ),
		'description' => __( 'Image with hotspots linking to products. Enter WooCommerce product IDs (comma separated).', 'mimin' ),
		'panel'       => 'mimin_panel',
	) );
	$add( 'lookbook_enable', __( 'Show lookbook section', 'mimin' ), true, 'mimin_lookbook', 'checkbox', 'wp_validate_boolean' );
	$add( 'lookbook_img', __( 'Lookbook image', 'mimin' ), '', 'mimin_lookbook', 'image' );
	$add( 'lookbook_products', __( 'Hotspot product IDs', 'mimin' ), '', 'mimin_lookbook' );
	$add( 'lookbook_hotspots', __( 'Hotspot positions', 'mimin' ), '30%|34%, 56%|56%, 72%|26%', 'mimin_lookbook' );

	/* ---------------------------------------------------------------- */
	/* Instagram                                                         */
	/* ---------------------------------------------------------------- */
	$wp_customize->add_section( 'mimin_instagram', array(
		'title' => __( 'Instagram', 'mimin' ),
		'panel' => 'mimin_panel',
	) );
	$add( 'insta_enable', __( 'Show Instagram section', 'mimin' ), true, 'mimin_instagram', 'checkbox', 'wp_validate_boolean' );
	$add( 'insta_eyebrow', __( 'Eyebrow text', 'mimin' ), 'Follow Us', 'mimin_instagram' );
	$add( 'insta_title', __( 'Section title', 'mimin' ), 'On Instagram', 'mimin_instagram' );
	$add( 'insta_url', __( 'Profile URL', 'mimin' ), 'https://www.instagram.com/', 'mimin_instagram', 'url', 'esc_url_raw' );
	for ( $i = 1; $i <= 4; $i++ ) {
		$add( 'insta_img_' . $i, sprintf( __( 'Image %d', 'mimin' ), $i ), '', 'mimin_instagram', 'image' );
	}

	/* ---------------------------------------------------------------- */
	/* Contact & socials                                                 */
	/* ---------------------------------------------------------------- */
	$wp_customize->add_section( 'mimin_social', array(
		'title' => __( 'Contact & Social', 'mimin' ),
		'panel' => 'mimin_panel',
	) );
	$add( 'contact_email', __( 'Contact email', 'mimin' ), 'touch@miminstore.com', 'mimin_social' );
	$add( 'contact_phone', __( 'Contact phone', 'mimin' ), '+4733378901', 'mimin_social' );
	$add( 'social_facebook', __( 'Facebook URL', 'mimin' ), '#', 'mimin_social', 'url', 'esc_url_raw' );
	$add( 'social_x', __( 'X (Twitter) URL', 'mimin' ), '#', 'mimin_social', 'url', 'esc_url_raw' );
	$add( 'social_youtube', __( 'YouTube URL', 'mimin' ), '#', 'mimin_social', 'url', 'esc_url_raw' );
	$add( 'social_instagram', __( 'Instagram URL', 'mimin' ), 'https://www.instagram.com/', 'mimin_social', 'url', 'esc_url_raw' );

	/* ---------------------------------------------------------------- */
	/* Footer & blog                                                     */
	/* ---------------------------------------------------------------- */
	$wp_customize->add_section( 'mimin_footer', array(
		'title' => __( 'Footer & Blog', 'mimin' ),
		'panel' => 'mimin_panel',
	) );
	$add( 'footer_about', __( 'Footer about text', 'mimin' ), 'Empowering everyone to create spaces they love — a curated collection of furniture, crafted with care for modern living.', 'mimin_footer' );
	$add( 'footer_newsletter_title', __( 'Newsletter title', 'mimin' ), 'Sign Up For 10% Off', 'mimin_footer' );
	$add( 'footer_newsletter_text', __( 'Newsletter text', 'mimin' ), 'Be the first to know about new releases, exclusive promotions, events and styling tips!', 'mimin_footer' );
	$add( 'footer_copyright', __( 'Copyright line', 'mimin' ), 'All Rights Reserved.', 'mimin_footer' );
	$add( 'blog_title', __( 'Blog page title', 'mimin' ), 'Blog', 'mimin_footer' );
	$add( 'blog_subtitle', __( 'Blog page subtitle', 'mimin' ), 'Ideas, stories and studio notes on furniture, craft and calm modern living.', 'mimin_footer' );
}
add_action( 'customize_register', 'mimin_customize_register' );
