<?php
/**
 * Mimin — single post.
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
		<!-- post header -->
		<header class="max-w-[820px] mx-auto px-[15px] text-center pt-4 pb-10">
			<?php mimin_post_meta(); ?>
			<h1 class="text-[30px] sm:text-[38px] lg:text-[44px] leading-tight font-normal mt-4 mb-6"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="text-[15px] text-soft leading-[1.8]"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="max-w-boxed mx-auto px-[15px]">
				<div class="zoom-img overflow-hidden">
					<?php the_post_thumbnail( 'mimin-blog-wide', array( 'class' => 'w-full h-auto object-cover aspect-[1200/560]' ) ); ?>
				</div>
			</figure>
		<?php endif; ?>

		<!-- content -->
		<div class="max-w-[760px] mx-auto px-[15px] pt-12">
			<div class="entry-content">
				<?php
				the_content();
				wp_link_pages( array(
					'before' => '<div class="page-links mt-8 text-[14px] text-soft">' . esc_html__( 'Pages:', 'mimin' ),
					'after'  => '</div>',
				) );
				?>
			</div>

			<?php $tags = get_the_tag_list( '', ' ' ); ?>
			<?php if ( $tags ) : ?>
				<div class="flex flex-wrap items-center gap-2 mt-10">
					<span class="text-[13.5px] font-medium mr-2"><?php esc_html_e( 'Tags:', 'mimin' ); ?></span>
					<?php echo $tags; // phpcs:ignore ?>
				</div>
			<?php endif; ?>

			<!-- share -->
			<div class="flex items-center gap-4 mt-8">
				<span class="text-[13.5px] font-medium"><?php esc_html_e( 'Share:', 'mimin' ); ?></span>
				<div class="flex items-center gap-3.5 text-soft">
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="Facebook" class="hover:text-black transition-colors"><?php echo mimin_icon( 'facebook', 15 ); // phpcs:ignore ?></a>
					<a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&text=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener" aria-label="X" class="hover:text-black transition-colors"><?php echo mimin_icon( 'x', 14 ); // phpcs:ignore ?></a>
					<a href="https://pinterest.com/pin/create/button/?url=<?php echo esc_url( get_permalink() ); ?>" target="_blank" rel="noopener" aria-label="Pinterest" class="hover:text-black transition-colors"><?php echo mimin_icon( 'pinterest', 15 ); // phpcs:ignore ?></a>
				</div>
			</div>

			<!-- author box -->
			<div class="flex gap-5 items-start bg-smoke p-7 mt-12">
				<div class="w-14 h-14 rounded-full bg-sage flex items-center justify-center text-[18px] font-medium shrink-0 overflow-hidden">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 56 ); ?>
				</div>
				<div>
					<p class="text-[15px] font-medium mb-1.5"><?php echo esc_html( get_the_author() ); ?></p>
					<p class="text-[13.5px] text-soft leading-[1.8]"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
				</div>
			</div>

			<!-- prev / next -->
			<nav class="grid sm:grid-cols-2 gap-6 border-t border-line mt-12 pt-8 text-[14px]" aria-label="<?php esc_attr_e( 'Post navigation', 'mimin' ); ?>">
				<div>
					<?php
					$prev = get_previous_post();
					if ( $prev ) :
						?>
						<span class="block text-[12.5px] text-soft mb-1.5"><?php esc_html_e( 'Previous', 'mimin' ); ?></span>
						<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="hover:text-soft transition-colors"><?php echo esc_html( get_the_title( $prev ) ); ?></a>
					<?php endif; ?>
				</div>
				<div class="sm:text-right">
					<?php
					$next = get_next_post();
					if ( $next ) :
						?>
						<span class="block text-[12.5px] text-soft mb-1.5"><?php esc_html_e( 'Next', 'mimin' ); ?></span>
						<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="hover:text-soft transition-colors"><?php echo esc_html( get_the_title( $next ) ); ?></a>
					<?php endif; ?>
				</div>
			</nav>
		</div>

		<!-- related posts -->
		<?php
		$cats    = wp_get_post_categories( get_the_ID() );
		$related = new WP_Query( array(
			'post_type'           => 'post',
			'posts_per_page'      => 3,
			'post__not_in'        => array( get_the_ID() ),
			'category__in'        => $cats,
			'ignore_sticky_posts' => 1,
			'no_found_rows'       => 1,
		) );
		if ( ! $related->have_posts() ) {
			$related = new WP_Query( array(
				'post_type'      => 'post',
				'posts_per_page' => 3,
				'post__not_in'   => array( get_the_ID() ),
				'no_found_rows'  => 1,
			) );
		}
		if ( $related->have_posts() ) :
			?>
			<section class="max-w-boxed mx-auto px-[15px] mt-20 lg:mt-28">
				<h2 class="text-[26px] sm:text-[32px] leading-tight font-normal mb-12"><?php esc_html_e( 'Related posts', 'mimin' ); ?></h2>
				<div class="grid sm:grid-cols-3 gap-[30px]">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						get_template_part( 'template-parts/content' );
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</section>
		<?php endif; ?>

		<!-- comments -->
		<div class="max-w-[760px] mx-auto px-[15px] mt-20">
			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>

	<?php
endwhile;
?>

<?php get_footer(); ?>
