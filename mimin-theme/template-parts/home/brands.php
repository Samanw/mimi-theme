<?php
/**
 * Brand marquee.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$brands = apply_filters( 'mimin_brands', array(
	array( 'brand.png', 'Altura' ),
	array( 'brand-3.png', 'Crafts' ),
	array( 'brand-5.png', 'Echelon' ),
	array( 'brand-2.png', 'Luminary' ),
	array( 'brand-4.png', 'Stellar' ),
	array( 'brand-6.png', 'Wooden' ),
) );
?>
<!-- ══════════════════════ BRANDS MARQUEE ══════════════════════ -->
<section class="max-w-boxed mx-auto px-[15px] mt-[70px] lg:mt-[100px]">
	<div class="marquee overflow-hidden reveal" data-marquee>
		<div class="marquee-track items-center gap-[90px] pr-[90px]">
			<?php for ( $pass = 0; $pass < 2; $pass++ ) : ?>
				<?php foreach ( $brands as $b ) : ?>
					<img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/' . $b[0] ) ); ?>" alt="<?php echo $pass ? '' : esc_attr( $b[1] ); ?>" <?php echo $pass ? 'aria-hidden="true"' : ''; ?> class="h-8 w-auto <?php echo $pass ? 'opacity-70' : 'opacity-70 hover:opacity-100 transition-opacity'; ?>">
				<?php endforeach; ?>
			<?php endfor; ?>
		</div>
	</div>
</section>
