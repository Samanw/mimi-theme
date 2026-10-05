<?php
/**
 * Mimin — static page.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<div class="max-w-boxed mx-auto px-[15px]">
		<?php mimin_breadcrumbs(); ?>
	</div>

	<article <?php post_class(); ?>>
		<header class="max-w-[820px] mx-auto px-[15px] text-center pt-4 pb-10">
			<h1 class="text-[30px] sm:text-[38px] lg:text-[42px] leading-tight font-normal"><?php the_title(); ?></h1>
		</header>

		<div class="max-w-[760px] mx-auto px-[15px] pb-4">
			<?php if ( has_post_thumbnail() ) : ?>
				<figure class="mb-10 zoom-img overflow-hidden">
					<?php the_post_thumbnail( 'mimin-blog-wide', array( 'class' => 'w-full h-auto' ) ); ?>
				</figure>
			<?php endif; ?>

			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links mt-8 text-[14px] text-soft">' . esc_html__( 'Pages:', 'mimin' ),
					'after'  => '</div>',
				) );
				?>
			</div>
		</div>

		<?php
		if ( comments_open() || get_comments_number() ) :
			?>
			<div class="max-w-[760px] mx-auto px-[15px] mt-16">
				<?php comments_template(); ?>
			</div>
		<?php endif; ?>
	</article>

	<?php
endwhile;
?>

<?php get_footer(); ?>
