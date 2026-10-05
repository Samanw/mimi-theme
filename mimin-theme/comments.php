<?php
/**
 * Mimin — comments list & form.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

$count = get_comments_number();
?>
<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h3 class="text-[20px] font-normal mb-8">
			<?php
			/* translators: %d: comment count */
			printf( esc_html( _n( '%d Comment', '%d Comments', $count, 'mimin' ) ), intval( $count ) );
			?>
		</h3>

		<ol class="comment-list space-y-8 mb-12">
			<?php
			wp_list_comments( array(
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 48,
			) );
			?>
		</ol>

		<?php
		the_comments_pagination( array(
			'mid_size'  => 1,
			'prev_text' => mimin_icon( 'chevron-l', 15 ), // phpcs:ignore
			'next_text' => mimin_icon( 'chevron-r', 15 ), // phpcs:ignore
		) );
	endif;

	if ( ! comments_open() && get_comments_number() ) :
		?>
		<p class="no-comments text-[14px] text-soft"><?php esc_html_e( 'Comments are closed.', 'mimin' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( array(
		'class_form'          => 'comment-form space-y-5',
		'title_reply_before'  => '<h3 id="reply-title" class="comment-reply-title text-[20px] font-normal mb-6">',
		'title_reply_after'   => '</h3>',
		'class_submit'        => 'btn-solid',
		'comment_notes_before'=> '<p class="comment-notes text-[13.5px] text-soft">' . esc_html__( 'Your email address will not be published.', 'mimin' ) . '</p>',
	) );
	?>
</div>
