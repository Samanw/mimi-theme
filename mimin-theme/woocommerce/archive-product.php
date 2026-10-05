<?php
/**
 * Mimin — shop archive (product listing) with filter sidebar, toolbar,
 * grid/list view and pagination.
 *
 * @package Mimin
 */

if ( ! defined( 'ABSPATH' ) ) { exit; }

get_header();

$shop_id  = function_exists( 'wc_get_page_id' ) ? wc_get_page_id( 'shop' ) : 0;
$is_list  = isset( $_GET['view'] ) && 'list' === sanitize_key( wp_unslash( $_GET['view'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
?>
<div class="max-w-boxed mx-auto px-[15px]">
        <?php mimin_breadcrumbs(); ?>
</div>

<section class="max-w-boxed mx-auto px-[15px] pb-24">

        <?php wc_print_notices(); ?>

        <!-- page title -->
        <div class="flex flex-wrap items-end justify-between gap-6 mb-10 reveal">
                <h1 class="text-[34px] sm:text-[42px] leading-tight font-normal">
                        <?php woocommerce_page_title(); ?>
                </h1>
                <?php
                $desc = is_product_taxonomy() ? term_description() : get_post_field( 'post_content', $shop_id );
                if ( $desc ) :
                        ?>
                        <div class="text-soft text-[14.5px] max-w-[430px] leading-relaxed"><?php echo wp_kses_post( wp_trim_words( $desc, 26, '…' ) ); ?></div>
                <?php endif; ?>
        </div>

        <div class="lg:grid lg:grid-cols-[270px_1fr] lg:gap-14">

                <!-- mobile filter backdrop -->
                <div id="filter-backdrop" class="modal-backdrop fixed inset-0 z-[74] bg-black/60 opacity-0 invisible max-lg:block hidden"></div>

                <?php get_template_part( 'sidebar-shop' ); ?>

                <!-- main column -->
                <div class="min-w-0">
                        <?php do_action( 'woocommerce_before_main_content' ); ?>

                        <!-- toolbar -->
                        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-line pb-5 mb-9">
                                <?php woocommerce_result_count(); ?>
                                <div class="flex items-center gap-3.5">
                                        <button id="filter-toggle" class="lg:hidden inline-flex items-center gap-2 border border-line px-4 py-2 text-[13.5px] hover:border-black transition-colors">
                                                <?php echo mimin_icon( 'filter', 15 ); // phpcs:ignore ?>
                                                <?php esc_html_e( 'Filter', 'mimin' ); ?>
                                        </button>
                                        <?php woocommerce_catalog_ordering(); ?>
                                        <div class="hidden sm:flex items-center border border-line">
                                                <a href="<?php echo esc_url( remove_query_arg( 'view' ) ); ?>" class="view-btn p-2.5<?php echo $is_list ? '' : ' is-active'; ?>" aria-label="<?php esc_attr_e( 'Grid view', 'mimin' ); ?>"><?php echo mimin_icon( 'grid', 15 ); // phpcs:ignore ?></a>
                                                <a href="<?php echo esc_url( add_query_arg( 'view', 'list' ) ); ?>" class="view-btn p-2.5<?php echo $is_list ? ' is-active' : ''; ?>" aria-label="<?php esc_attr_e( 'List view', 'mimin' ); ?>"><?php echo mimin_icon( 'list', 15 ); // phpcs:ignore ?></a>
                                        </div>
                                </div>
                        </div>

                        <?php if ( have_posts() ) : ?>
                                <div class="shop-grid grid grid-cols-2 md:grid-cols-3 gap-x-[30px] gap-y-12<?php echo $is_list ? ' list-view' : ''; ?>">
                                        <?php
                                        while ( have_posts() ) {
                                                the_post();
                                                wc_get_template_part( 'content', 'product' );
                                        }
                                        ?>
                                </div>
                        <?php else : ?>
                                <div class="text-center py-16">
                                        <p class="text-soft text-[14.5px] mb-8"><?php esc_html_e( 'No products matched your filters.', 'mimin' ); ?></p>
                                        <a href="<?php echo esc_url( get_permalink( $shop_id ) ); ?>" class="btn-outline"><?php esc_html_e( 'Reset filters', 'mimin' ); ?></a>
                                </div>
                        <?php endif; ?>

                        <?php do_action( 'woocommerce_after_shop_loop' ); ?>

                        <?php do_action( 'woocommerce_after_main_content' ); ?>
                </div>
        </div>
</section>

<?php
get_footer();
