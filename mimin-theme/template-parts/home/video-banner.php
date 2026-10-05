<?php
/**
 * Video banner.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!-- ══════════════════════ VIDEO BANNER ══════════════════════ -->
<section class="mt-[80px] lg:mt-[120px] relative">
	<div class="relative h-[320px] sm:h-[420px] lg:h-[640px] overflow-hidden">
		<img src="<?php echo esc_url( mimin_img_url( 'video_poster', 'image-47.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Interior video', 'mimin' ); ?>" class="absolute inset-0 w-full h-full object-cover">
		<div class="absolute inset-0 bg-black/15"></div>
		<button id="video-open" class="absolute inset-0 m-auto w-[86px] h-[86px] rounded-full bg-white play-pulse flex items-center justify-center hover:scale-105 transition-transform" aria-label="<?php esc_attr_e( 'Play video', 'mimin' ); ?>">
			<?php echo mimin_icon( 'play', 22, 'class="ml-1" stroke="none"' ); // phpcs:ignore ?>
		</button>
	</div>
</section>
