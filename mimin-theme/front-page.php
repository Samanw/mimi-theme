<?php
/**
 * Mimin — front page (Home 5 layout).
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

get_template_part( 'template-parts/home/hero' );
get_template_part( 'template-parts/home/banners' );

if ( mimin_get_option( 'best_enable', true ) ) {
	get_template_part( 'template-parts/home/best-sellers' );
}

if ( mimin_get_option( 'video_enable', true ) ) {
	get_template_part( 'template-parts/home/video-banner' );
}

get_template_part( 'template-parts/home/brands' );

if ( mimin_get_option( 'lookbook_enable', true ) ) {
	get_template_part( 'template-parts/home/lookbook' );
}

if ( mimin_get_option( 'insta_enable', true ) ) {
	get_template_part( 'template-parts/home/instagram' );
}

get_footer();
