<?php
/**
 * Instagram grid.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$url = mimin_get_option( 'insta_url', 'https://www.instagram.com/' );
$default_imgs = array( 'ins.jpg', 'ins-2.jpg', 'ins-3.jpg', 'ins-4.jpg' );
?>
<!-- ══════════════════════ INSTAGRAM ══════════════════════ -->
<section class="max-w-boxed mx-auto px-[15px] mt-[80px] lg:mt-[120px]">
	<div class="text-center mb-12 reveal">
		<p class="text-[13px] tracking-[2px] uppercase text-soft mb-3"><?php echo esc_html( mimin_get_option( 'insta_eyebrow', 'Follow Us' ) ); ?></p>
		<h2 class="text-[30px] sm:text-[36px] lg:text-[40px] leading-tight font-normal"><?php echo esc_html( mimin_get_option( 'insta_title', 'On Instagram' ) ); ?></h2>
	</div>
	<div class="grid grid-cols-2 lg:grid-cols-4 gap-[30px]">
		<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
		<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" class="reveal group relative block zoom-img aspect-square" style="transition-delay:<?php echo esc_attr( $i * 0.07 ); ?>s">
			<img src="<?php echo esc_url( mimin_img_url( 'insta_img_' . $i, $default_imgs[ $i - 1 ] ) ); ?>" alt="<?php esc_attr_e( 'Instagram', 'mimin' ); ?>" class="w-full h-full object-cover" loading="lazy">
			<span class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
				<?php echo mimin_icon( 'instagram', 30, 'stroke="#fff" stroke-width="1.4"' ); // phpcs:ignore ?>
			</span>
		</a>
		<?php endfor; ?>
	</div>
	<div class="text-center mt-14 reveal">
		<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener" class="btn-line"><?php esc_html_e( 'Follow Us', 'mimin' ); ?></a>
	</div>
</section>
