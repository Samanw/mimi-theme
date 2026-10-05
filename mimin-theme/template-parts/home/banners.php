<?php
/**
 * Category banners — 4 squares.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$banners = array();
$default = array(
	1 => array( 'Home Decor', 'image-43.jpg' ),
	2 => array( 'Living Room', 'image-44.jpg' ),
	3 => array( 'Lighting', 'image-45.jpg' ),
	4 => array( 'Furniture', 'image-46.jpg' ),
);

for ( $i = 1; $i <= 4; $i++ ) {
	$label = mimin_get_option( 'banner_label_' . $i, $default[ $i ][0] );
	if ( '' === $label ) { continue; }
	$banners[] = array(
		'label' => $label,
		'url'   => mimin_get_option( 'banner_url_' . $i, home_url( '/' ) ),
		'img'   => mimin_img_url( 'banner_img_' . $i, $default[ $i ][1] ),
	);
}
?>
<!-- ══════════════════════ CATEGORY BANNERS ══════════════════════ -->
<section class="max-w-boxed mx-auto px-[15px] mt-[60px] lg:mt-[100px]">
	<div class="grid grid-cols-2 lg:grid-cols-4 gap-[30px]">
		<?php foreach ( $banners as $i => $b ) : ?>
		<div class="reveal group relative zoom-img" style="transition-delay:<?php echo esc_attr( $i * 0.08 ); ?>s">
			<a href="<?php echo esc_url( $b['url'] ); ?>" class="block aspect-square">
				<img src="<?php echo esc_url( $b['img'] ); ?>" alt="<?php echo esc_attr( $b['label'] ); ?>" class="w-full h-full object-cover">
			</a>
			<div class="absolute inset-x-0 bottom-7 flex justify-center">
				<a href="<?php echo esc_url( $b['url'] ); ?>" class="bg-white px-7 py-2.5 text-[13px] tracking-[1px] transition-all duration-300 group-hover:bg-black group-hover:text-white"><?php echo esc_html( $b['label'] ); ?></a>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
</section>
