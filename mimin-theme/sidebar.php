<?php
/**
 * Mimin — blog sidebar (widgets with demo fallback).
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<aside class="mt-16 lg:mt-0">
	<?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>
		<div class="widget-area">
			<?php dynamic_sidebar( 'sidebar-blog' ); ?>
		</div>
	<?php else : ?>
		<div class="widget-area">

			<!-- search -->
			<div class="widget-block">
				<?php get_search_form(); ?>
			</div>

			<!-- recent posts -->
			<div class="widget-block">
				<h4 class="widget-title"><?php esc_html_e( 'Recent posts', 'mimin' ); ?></h4>
				<ul class="space-y-5">
					<?php
					$recent = new WP_Query( array(
						'post_type'      => 'post',
						'posts_per_page' => 3,
						'no_found_rows'  => 1,
					) );
					if ( $recent->have_posts() ) :
						while ( $recent->have_posts() ) :
							$recent->the_post();
							?>
							<li class="flex gap-3.5 items-center group">
								<a href="<?php the_permalink(); ?>" class="w-[72px] h-[72px] shrink-0 overflow-hidden zoom-img block bg-mist">
									<?php
									if ( has_post_thumbnail() ) {
										the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) );
									}
									?>
								</a>
								<div>
									<span class="block text-[12px] text-soft mb-1"><?php echo esc_html( get_the_date() ); ?></span>
									<a href="<?php the_permalink(); ?>" class="text-[13.5px] leading-snug group-hover:text-soft transition-colors"><?php echo esc_html( wp_trim_words( get_the_title(), 9 ) ); ?></a>
								</div>
							</li>
							<?php
						endwhile;
						wp_reset_postdata();
					else :
						echo '<li class="text-[13.5px] text-soft">' . esc_html__( 'No posts yet.', 'mimin' ) . '</li>';
					endif;
					?>
				</ul>
			</div>

			<!-- categories -->
			<div class="widget-block">
				<h4 class="widget-title"><?php esc_html_e( 'Categories', 'mimin' ); ?></h4>
				<?php
				wp_list_categories( array(
					'title_li' => '',
					'show_count' => true,
				) );
				?>
			</div>

			<!-- archive -->
			<div class="widget-block">
				<h4 class="widget-title"><?php esc_html_e( 'Archive', 'mimin' ); ?></h4>
				<?php
				wp_get_archives( array( 'type' => 'monthly', 'limit' => 6 ) );
				?>
			</div>

			<!-- tags -->
			<div>
				<h4 class="widget-title"><?php esc_html_e( 'Tags', 'mimin' ); ?></h4>
				<?php
				$tags = get_tags( array( 'number' => 12 ) );
				if ( $tags ) {
					echo '<div class="flex flex-wrap gap-2">';
					foreach ( $tags as $tag ) {
						printf( '<a href="%s" class="tag-chip">%s</a>', esc_url( get_tag_link( $tag ) ), esc_html( $tag->name ) );
					}
					echo '</div>';
				}
				?>
			</div>

		</div>
	<?php endif; ?>
</aside>
