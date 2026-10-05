<?php
/**
 * Mimin — site footer.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
</main><!-- #main -->

<!-- ══════════════════════ FOOTER ══════════════════════ -->
<footer class="bg-smoke mt-[90px] lg:mt-[130px]">
	<div class="max-w-boxed mx-auto px-[15px] pt-[70px] lg:pt-[90px] pb-[50px]">
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-y-12 gap-x-[30px]">

			<!-- brand + contact -->
			<div class="lg:col-span-4">
				<?php mimin_logo(); ?>
				<p class="text-[15px] text-soft leading-[1.8] max-w-[300px] mt-6 mb-7"><?php echo esc_html( mimin_get_option( 'footer_about' ) ); ?></p>
				<ul class="space-y-2.5 text-[15px]">
					<?php $email = mimin_get_option( 'contact_email' ); $phone = mimin_get_option( 'contact_phone' ); ?>
					<?php if ( $email ) : ?>
						<li><span class="font-medium"><?php esc_html_e( 'Email:', 'mimin' ); ?></span> <a href="mailto:<?php echo esc_attr( $email ); ?>" class="text-soft hover:text-black transition-colors"><?php echo esc_html( $email ); ?></a></li>
					<?php endif; ?>
					<?php if ( $phone ) : ?>
						<li><span class="font-medium"><?php esc_html_e( 'Call Us:', 'mimin' ); ?></span> <a href="tel:<?php echo esc_attr( preg_replace( '/[^+\d]/', '', $phone ) ); ?>" class="text-soft hover:text-black transition-colors"><?php echo esc_html( $phone ); ?></a></li>
					<?php endif; ?>
				</ul>
			</div>

			<!-- information -->
			<div class="lg:col-span-2">
				<h3 class="text-[17px] font-medium mb-6"><?php esc_html_e( 'Information', 'mimin' ); ?></h3>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer_information',
					'container'      => false,
					'menu_class'     => 'space-y-3 text-[14.5px] text-soft',
					'depth'          => 1,
					'fallback_cb'    => 'mimin_footer_information_fallback',
					'walker'         => new Walker_Nav_Menu(),
				) );
				?>
			</div>

			<!-- about us -->
			<div class="lg:col-span-2">
				<h3 class="text-[17px] font-medium mb-6"><?php esc_html_e( 'About Us', 'mimin' ); ?></h3>
				<?php
				wp_nav_menu( array(
					'theme_location' => 'footer_about',
					'container'      => false,
					'menu_class'     => 'space-y-3 text-[14.5px] text-soft',
					'depth'          => 1,
					'fallback_cb'    => 'mimin_footer_about_fallback',
					'walker'         => new Walker_Nav_Menu(),
				) );
				?>
			</div>

			<!-- newsletter -->
			<div class="lg:col-span-4">
				<h3 class="text-[17px] font-medium mb-6"><?php echo esc_html( mimin_get_option( 'footer_newsletter_title' ) ); ?></h3>
				<p class="text-[14.5px] text-soft leading-[1.8] mb-6"><?php echo esc_html( mimin_get_option( 'footer_newsletter_text' ) ); ?></p>
				<form id="newsletter-form" class="flex mb-7">
					<input type="email" required placeholder="<?php esc_attr_e( 'Your email address', 'mimin' ); ?>" class="flex-1 min-w-0 bg-white border border-line2 border-r-0 px-5 py-3.5 text-[14px] outline-none focus:border-black transition-colors">
					<button type="submit" class="shrink-0 bg-black text-white text-[13px] tracking-[1px] px-7 hover:bg-transparent hover:text-black border border-black transition-colors"><?php esc_html_e( 'Sign Up', 'mimin' ); ?></button>
				</form>
				<div class="flex items-center gap-5">
					<?php
					$socials = array(
						'facebook'  => mimin_get_option( 'social_facebook' ),
						'x'         => mimin_get_option( 'social_x' ),
						'youtube'   => mimin_get_option( 'social_youtube' ),
						'instagram' => mimin_get_option( 'social_instagram' ),
					);
					foreach ( $socials as $name => $url ) :
						if ( ! $url || '#' === $url && 'instagram' === $name ) { continue; }
						?>
						<a href="<?php echo esc_url( $url ); ?>" <?php if ( '#' !== $url ) : ?>target="_blank" rel="noopener"<?php endif; ?> aria-label="<?php echo esc_attr( ucfirst( $name ) ); ?>" class="text-soft hover:text-black transition-colors">
							<?php echo mimin_icon( $name, 'instagram' === $name ? 17 : ( 'youtube' === $name ? 19 : 16 ) ); // phpcs:ignore ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>

	<div class="border-t border-line2">
		<div class="max-w-boxed mx-auto px-[15px] py-6 flex flex-col md:flex-row items-center justify-between gap-4">
			<p class="text-[13.5px] text-soft">
				&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> – <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-black hover:underline"><?php bloginfo( 'name' ); ?></a>. <?php echo esc_html( mimin_get_option( 'footer_copyright' ) ); ?>
			</p>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'footer_legal',
				'container'      => false,
				'menu_class'     => 'flex flex-wrap justify-center gap-x-7 gap-y-2 text-[13.5px] text-soft',
				'depth'          => 1,
				'fallback_cb'    => 'mimin_footer_legal_fallback',
				'walker'         => new Walker_Nav_Menu(),
			) );
			?>
			<img src="<?php echo esc_url( get_theme_file_uri( 'assets/img/payment.png' ) ); ?>" alt="<?php esc_attr_e( 'Payment methods', 'mimin' ); ?>" class="h-5 w-auto">
		</div>
	</div>
</footer>

<?php if ( is_front_page() && mimin_get_option( 'video_enable', true ) ) : ?>
<!-- ══════════════════════ VIDEO MODAL ══════════════════════ -->
<div id="video-modal" class="modal-backdrop fixed inset-0 z-[80] bg-black/90 opacity-0 invisible flex items-center justify-center p-5" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Video', 'mimin' ); ?>">
	<button id="video-close" class="absolute top-5 right-5 text-white/80 hover:text-white transition-colors z-10" aria-label="<?php esc_attr_e( 'Close video', 'mimin' ); ?>">
		<?php echo mimin_icon( 'close', 28, 'stroke-width="1.4"' ); // phpcs:ignore ?>
	</button>
	<div class="w-full max-w-[960px] aspect-video bg-black">
		<video id="promo-video" controls preload="none" class="w-full h-full">
			<source src="<?php echo esc_url( mimin_get_option( 'video_url' ) ); ?>" type="video/mp4">
			<?php esc_html_e( 'Your browser does not support the video tag.', 'mimin' ); ?>
		</video>
	</div>
</div>
<?php endif; ?>

<!-- ══════════════════════ TOAST + BACK TO TOP ══════════════════════ -->
<div id="toast" class="toast fixed bottom-8 left-1/2 -translate-x-1/2 translate-y-20 opacity-0 z-[90] bg-black text-white text-[13.5px] tracking-wide px-6 py-3.5 shadow-xl pointer-events-none" role="status"></div>
<button id="back-to-top" class="fixed bottom-8 right-8 z-50 w-11 h-11 bg-black text-white flex items-center justify-center opacity-0 invisible transition-all duration-300 hover:bg-soft" aria-label="<?php esc_attr_e( 'Back to top', 'mimin' ); ?>">
	<?php echo mimin_icon( 'arrow-up', 16 ); // phpcs:ignore ?>
</button>

<?php wp_footer(); ?>
</body>
</html>
