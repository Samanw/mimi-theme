<?php
/**
 * Mimin — blog index / posts page.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

mimin_page_header( mimin_get_option( 'blog_title', 'Blog' ), mimin_get_option( 'blog_subtitle', 'Ideas, stories and studio notes on furniture, craft and calm modern living.' ) );
?>

<section class="max-w-boxed mx-auto px-[15px] py-16 lg:py-20">
	<div class="lg:grid lg:grid-cols-[1fr_300px] lg:gap-14">

		<div class="min-w-0">
			<?php if ( have_posts() ) : ?>
				<?php
				$grid_open = false;
				while ( have_posts() ) :
					the_post();

					if ( 0 === $wp_query->current_post ) :
						/* Featured first post */
						?>
						<article <?php post_class( 'reveal group mb-14' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<a href="<?php the_permalink(); ?>" class="block zoom-img overflow-hidden mb-8">
									<?php the_post_thumbnail( 'mimin-blog-wide', array( 'class' => 'w-full h-auto object-cover aspect-[1200/560]' ) ); ?>
								</a>
							<?php endif; ?>
							<?php mimin_post_meta(); ?>
							<h2 class="text-[26px] sm:text-[32px] leading-tight font-normal mt-3 mb-4">
								<a href="<?php the_permalink(); ?>" class="hover:text-soft transition-colors"><?php the_title(); ?></a>
							</h2>
							<p class="text-[14.5px] text-soft leading-[1.85] max-w-[720px] mb-6"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>
							<a href="<?php the_permalink(); ?>" class="inline-flex items-center gap-2 text-[13px] tracking-[1px] border-b border-black pb-0.5 hover:opacity-60 transition-opacity"><?php esc_html_e( 'Read more', 'mimin' ); ?></a>
						</article>
						<div class="grid sm:grid-cols-2 gap-x-[30px] gap-y-14">
						<?php
						$grid_open = true;
						continue;
					endif;

					get_template_part( 'template-parts/content' );
				endwhile;

				if ( $grid_open ) {
					echo '</div>';
				}
				?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>

			<div class="mt-16"><?php mimin_pagination(); ?></div>
		</div>

		<?php get_sidebar(); ?>
	</div>
</section>

<?php get_footer(); ?>
