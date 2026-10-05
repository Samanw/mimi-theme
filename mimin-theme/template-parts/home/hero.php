<?php
/**
 * Hero slider — 3 slides from Customizer.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$slides = array();
for ( $i = 1; $i <= 3; $i++ ) {
	$title = mimin_get_option( 'hero_title_' . $i, '' );
	if ( '' === $title ) { continue; }
	$slides[] = array(
		'bg'    => mimin_get_option( 'hero_bg_' . $i, '#D5E4E1' ),
		'title' => $title,
		'desc'  => mimin_get_option( 'hero_desc_' . $i ),
		'btn'   => mimin_get_option( 'hero_btn_' . $i, 'Shop Now' ),
		'url'   => mimin_get_option( 'hero_url_' . $i, home_url( '/' ) ),
		'img'   => mimin_img_url( 'hero_img_' . $i, $i <= 2 ? 'image-4' . ( $i ) . '.png' : 'image-42.png' ),
	);
}

if ( ! $slides ) {
	$slides = array( array(
		'bg'    => '#D5E4E1',
		'title' => get_bloginfo( 'name' ),
		'desc'  => get_bloginfo( 'description' ),
		'btn'   => 'Shop Now',
		'url'   => home_url( '/' ),
		'img'   => get_theme_file_uri( 'assets/img/image-41.png' ),
	) );
}

$default_imgs = array( 'image-41.png', 'image-42.png', 'image-42.png' );
$idx = 0;
?>
<!-- ══════════════════════ HERO SLIDER ══════════════════════ -->
<section id="hero" class="relative w-full overflow-hidden h-[550px] sm:h-[600px] lg:h-auto lg:aspect-[1920/860] lg:min-h-[560px] lg:max-h-[860px]" aria-roledescription="carousel">
	<?php foreach ( $slides as $s ) : ?>
	<div class="slide<?php echo 0 === $idx ? ' is-active' : ''; ?>" data-slide style="background-color:<?php echo esc_attr( $s['bg'] ? $s['bg'] : '#D5E4E1' ); ?>">
		<img src="<?php echo esc_url( $s['img'] ); ?>" alt="<?php echo esc_attr( $s['title'] ); ?>" class="slide-img absolute bottom-0 right-[-4%] sm:right-0 lg:right-[10.4%] h-[52%] sm:h-[60%] lg:h-full aspect-square w-auto object-cover" draggable="false">
		<div class="absolute left-[15px] sm:left-[8%] lg:left-[12.5%] top-[9%] lg:top-auto lg:bottom-[33%] lg:translate-y-0 lg:w-[29%] lg:min-w-[340px] lg:max-w-[550px]">
			<h2 class="slide-title text-[30px] sm:text-[38px] lg:text-[clamp(34px,3.35vw,64px)] leading-[1.12] font-normal mb-4 lg:mb-5"><?php echo esc_html( $s['title'] ); ?></h2>
			<?php if ( $s['desc'] ) : ?>
				<p class="slide-desc text-[13px] lg:text-[clamp(12px,0.87vw,16.5px)] lg:leading-[1.55] leading-[1.75] text-soft mb-7 lg:mb-8 max-w-[420px] lg:max-w-none lg:pr-6"><?php echo esc_html( $s['desc'] ); ?></p>
			<?php endif; ?>
			<a href="<?php echo esc_url( $s['url'] ); ?>" class="slide-btn btn-outline"><?php echo esc_html( $s['btn'] ); ?></a>
		</div>
	</div>
	<?php
	$idx++;
	endforeach; ?>

	<!-- arrows -->
	<button id="hero-prev" class="hidden lg:flex absolute left-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 items-center justify-center bg-white/85 hover:bg-black hover:text-white text-black transition-colors" aria-label="<?php esc_attr_e( 'Previous slide', 'mimin' ); ?>">
		<?php echo mimin_icon( 'chevron-l', 18 ); // phpcs:ignore ?>
	</button>
	<button id="hero-next" class="hidden lg:flex absolute right-6 top-1/2 -translate-y-1/2 z-10 w-11 h-11 items-center justify-center bg-white/85 hover:bg-black hover:text-white text-black transition-colors" aria-label="<?php esc_attr_e( 'Next slide', 'mimin' ); ?>">
		<?php echo mimin_icon( 'chevron-r', 18 ); // phpcs:ignore ?>
	</button>

	<!-- numbered bullets 01 / 02 / 03 -->
	<div class="absolute bottom-[6.5%] left-[15px] lg:left-auto lg:right-[12%] z-10 flex gap-[30px]" id="hero-bullets">
		<?php foreach ( $slides as $i => $s ) : ?>
			<button class="hero-bullet text-[13px]<?php echo 0 === $i ? ' is-active' : ''; ?>" data-index="<?php echo esc_attr( $i ); ?>"><?php printf( '%02d', $i + 1 ); ?></button>
		<?php endforeach; ?>
	</div>
</section>
