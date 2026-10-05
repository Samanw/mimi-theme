<?php
/**
 * Mimin — search results.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

/* translators: %s: search query */
mimin_page_header( sprintf( __( 'Search: %s', 'mimin' ), get_search_query() ), __( 'Results from across the store and journal.', 'mimin' ) );
?>

<section class="max-w-boxed mx-auto px-[15px] py-16 lg:py-20">
	<div class="lg:grid lg:grid-cols-[1fr_300px] lg:gap-14">

		<div class="min-w-0">
			<?php if ( have_posts() ) : ?>
				<div class="grid sm:grid-cols-2 gap-x-[30px] gap-y-14">
					<?php
					while ( have_posts() ) :
						the_post();
						set_query_var( 'mimin_card_delay', min( $wp_query->current_post, 4 ) * 0.06 );
						get_template_part( 'template-parts/content' );
					endwhile;
					?>
				</div>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>

			<div class="mt-16"><?php mimin_pagination(); ?></div>
		</div>

		<?php get_sidebar(); ?>
	</div>
</section>

<?php get_footer(); ?>
