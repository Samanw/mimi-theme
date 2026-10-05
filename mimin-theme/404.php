<?php
/**
 * Mimin — 404 page.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<section class="max-w-boxed mx-auto px-[15px] py-24 lg:py-32 text-center">
	<p class="text-[100px] sm:text-[140px] leading-none font-light tracking-tight">404</p>
	<h1 class="text-[24px] sm:text-[30px] font-normal mt-4 mb-5"><?php esc_html_e( 'Page not found', 'mimin' ); ?></h1>
	<p class="text-[14.5px] text-soft leading-[1.8] max-w-[440px] mx-auto mb-10"><?php esc_html_e( 'The page you are looking for may have moved, or simply does not exist. Try a search or head back to the shop.', 'mimin' ); ?></p>
	<div class="max-w-[440px] mx-auto mb-10"><?php get_search_form(); ?></div>
	<div class="flex items-center justify-center gap-4 flex-wrap">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-solid"><?php esc_html_e( 'Back to home', 'mimin' ); ?></a>
		<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
			<a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-outline"><?php esc_html_e( 'Go to shop', 'mimin' ); ?></a>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
