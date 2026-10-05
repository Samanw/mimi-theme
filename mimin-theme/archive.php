<?php
/**
 * Mimin — archive (category, tag, date, author).
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

mimin_page_header( get_the_archive_title(), wp_strip_all_tags( get_the_archive_description() ) );
?>

<section class="max-w-boxed mx-auto px-[15px] py-16 lg:py-20">
	<div class="lg:grid lg:grid-cols-[1fr_300px] lg:gap-14">

		<div class="min-w-0">
			<!-- category chips -->
			<?php
			$cats = get_categories( array( 'number' => 8, 'hide_empty' => true ) );
			if ( $cats && ! is_category() ) :
				?>
				<div class="flex flex-wrap gap-2.5 mb-12">
					<?php foreach ( $cats as $c ) : ?>
						<a href="<?php echo esc_url( get_category_link( $c ) ); ?>" class="tag-chip"><?php echo esc_html( $c->name ); ?></a>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

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
