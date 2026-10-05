<?php
/**
 * Post card — used in blog index / archives / search results.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$delay = get_query_var( 'mimin_card_delay', 0 );
?>
<article <?php post_class( 'reveal group' ); ?> style="transition-delay:<?php echo esc_attr( $delay ); ?>s">
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink(); ?>" class="block zoom-img overflow-hidden mb-6">
			<?php the_post_thumbnail( 'mimin-blog', array( 'class' => 'w-full h-auto object-cover aspect-[720/480]' ) ); ?>
		</a>
	<?php endif; ?>
	<?php mimin_post_meta(); ?>
	<h2 class="text-[19px] leading-snug font-normal mt-2.5 mb-3">
		<a href="<?php the_permalink(); ?>" class="hover:text-soft transition-colors"><?php the_title(); ?></a>
	</h2>
	<p class="text-[14px] text-soft leading-[1.8] mb-4"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
	<a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-[12.5px] tracking-[1px] border-b border-black pb-0.5 hover:opacity-60 transition-opacity"><?php esc_html_e( 'Read more', 'mimin' ); ?></a>
</article>
