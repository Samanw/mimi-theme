<?php
/**
 * Mimin — search form.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<form role="search" method="get" class="search-form flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="search-field"><?php esc_html_e( 'Search for:', 'mimin' ); ?></label>
	<input id="search-field" type="search" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php esc_attr_e( 'Search…', 'mimin' ); ?>" class="flex-1 min-w-0 bg-white border border-line2 border-r-0 px-5 py-3.5 text-[14px] outline-none focus:border-black transition-colors">
	<button type="submit" class="shrink-0 bg-black text-white text-[13px] tracking-[1px] px-7 hover:bg-transparent hover:text-black border border-black transition-colors" aria-label="<?php esc_attr_e( 'Search', 'mimin' ); ?>"><?php echo mimin_icon( 'search', 16 ); // phpcs:ignore ?></button>
</form>
