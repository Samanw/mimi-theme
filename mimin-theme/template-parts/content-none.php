<?php
/**
 * Empty state (no posts found).
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div class="text-center py-20">
	<h2 class="text-[22px] font-normal mb-4"><?php esc_html_e( 'Nothing found', 'mimin' ); ?></h2>
	<p class="text-[14.5px] text-soft leading-[1.8] max-w-[420px] mx-auto mb-8"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'mimin' ); ?></p>
	<div class="max-w-[420px] mx-auto"><?php get_search_form(); ?></div>
</div>
