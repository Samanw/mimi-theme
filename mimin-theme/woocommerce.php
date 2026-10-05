<?php
/**
 * Mimin — generic WooCommerce wrapper.
 * Used for cart, checkout, my-account, order tracking pages etc.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();
?>

<div class="max-w-boxed mx-auto px-[15px]">
	<?php mimin_breadcrumbs(); ?>
</div>

<div class="max-w-boxed mx-auto px-[15px] pb-24">
	<?php woocommerce_content(); ?>
</div>

<?php
get_footer();
