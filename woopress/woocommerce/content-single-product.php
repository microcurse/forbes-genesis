<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$l = et_page_config();

if ( etheme_get_custom_field('et_single_layout') != '' && etheme_get_custom_field('et_single_layout') != 'inherit' ) {
    $layout = etheme_get_custom_field('et_single_layout');
} else {
    $layout = etheme_get_option('single_product_layout');
}

$carousel_direction = etheme_get_option('carousel_direction');

if ( isset( $carousel_direction ) && "vertical" == $carousel_direction ) {
    $image_class = 'col-lg-6 col-md-6 col-sm-12 gallery_vertical';
    $infor_class = 'col-lg-6 col-md-6 col-sm-12';
} else {
    $image_class = 'col-lg-6 col-md-6 col-sm-12';
    $infor_class = 'col-lg-6 col-md-6 col-sm-12';
}

if($layout == 'small') {
    if ( isset( $carousel_direction ) && "vertical" == $carousel_direction ) {
        $image_class = 'col-lg-5 col-md-5 col-sm-12 gallery_vertical';
        $infor_class = 'col-lg-7 col-md-7 col-sm-12';
    } else {
        $image_class = 'col-lg-4 col-md-5 col-sm-12';
        $infor_class = 'col-lg-8 col-md-7 col-sm-12';
    }
}

if($layout == 'large') {
    if ( isset( $carousel_direction ) && "vertical" == $carousel_direction ) {
        $image_class = 'col-sm-12 gallery_vertical';
        $infor_class = 'col-lg-6 col-md-6 col-sm-12';
    } else {
        $image_class = 'col-sm-12';
        $infor_class = 'col-lg-6 col-md-6 col-sm-12';
    }
}


if($layout == 'fixed') {
    if ( isset( $carousel_direction ) && "vertical" == $carousel_direction ) {
        $image_class = 'col-sm-6 gallery_vertical';
        $infor_class = 'col-lg-3 col-md-3 col-sm-12';
    } else {
        $image_class = 'col-sm-6';
        $infor_class = 'col-lg-3 col-md-3 col-sm-12';
    }
}

?>

<?php

    $class = 'tabs-'.etheme_get_option('tabs_location');
    $class .= ' single-product-'.$layout;
    $class .= ' reviews-position-'.etheme_get_option('reviews_position');
    if(etheme_get_option('ajax_addtocart')) $class .= ' ajax-cart-enable';
    /**
     * woocommerce_before_single_product hook
     *
     * @hooked wc_print_notices - 10
     */
     do_action( 'woocommerce_before_single_product' );

     if ( post_password_required() ) {
        echo get_the_password_form();
        return;
     }

?>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

    <div class="row">
        <div class="<?php echo esc_attr( $l['content-class'] ); ?> product-content">
            <div class="row">
                 <?php if ($layout == 'fixed'): ?>
                    <div class="col-md-3 product-summary-fixed">
                        <div class="fixed-product-block">
                            <div class="fixed-content">
                                <?php
                                if(etheme_get_option('show_product_title')) {
                                    the_title( '<h2 class="product_title entry-title">', '</h2>' );
                                }
                                    woocommerce_template_single_rating();
                                    echo '<hr class="divider short">';
                                    woocommerce_template_single_excerpt();
                                    if (etheme_get_option('share_icons')) {
                                        echo do_shortcode('[share title="'.__('Share Social', 'woopress').'" text="'.get_the_title().'"]');
                                    }
                                 ?>
                             </div>
                         </div>
                    </div>
                <?php endif ?>
                <div class="<?php echo esc_attr( $image_class ); ?> product-images">
                    <?php
                        /**
                         * woocommerce_before_single_product_summary hook
                         *
                         * @hooked woocommerce_show_product_sale_flash - 10
                         * @hooked woocommerce_show_product_images - 20
                         */
                        do_action( 'woocommerce_before_single_product_summary' );
                    ?>
                </div><!-- Product images/ END -->

                <?php
                    if($layout == 'large') {
                        ?>
                        </div>
                        <div class="row">
                        <?php
                    }
                ?>

                <div class="<?php echo esc_attr( $infor_class ); ?> product-information <?php if(etheme_get_option('ajax_addtocart')): ?>ajax-enabled<?php endif; ?>">
                    <div class="product-information-inner <?php if($layout == 'fixed') echo 'fixed-product-block' ?>">
                        <div class="fixed-content">
                            <div class="product-navigation clearfix">
                                <h4 class="meta-title"><span><?php esc_html_e('Product Description', 'woopress'); ?></span></h4>
                                <?php etheme_products_links(array()); ?>
                            </div>

                            <?php
                                /**
                                 * woocommerce_single_product_summary hook
                                 *
                                 * @hooked woocommerce_template_single_title - 5
                                 * @hooked woocommerce_template_single_rating - 10
                                 * @hooked woocommerce_template_single_price - 10
                                 * @hooked woocommerce_template_single_excerpt - 20
                                 * @hooked woocommerce_template_single_add_to_cart - 30
                                 * @hooked woocommerce_template_single_meta - 40
                                 * @hooked woocommerce_template_single_sharing - 50
                                 */
                                 do_action( 'woocommerce_single_product_summary' );
                            ?>

                            <?php if(etheme_get_option('share_icons') && $layout != 'fixed') echo do_shortcode('[share text="'.get_the_title().'"]'); ?>
                        </div>
                    </div>
                     <?php if(etheme_get_option('tabs_location') == 'after_image' && $layout != 'large') {
                        woocommerce_output_product_data_tabs();
                    } ?>
                </div><!-- Product information/ END -->

                <?php
                    if($layout == 'large') {
                        ?>
                            <div class="<?php echo esc_attr( $infor_class ); ?>">
                                <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
                            </div>
                        <?php
                    }
                ?>
            </div>

            <?php
                /**
                 * woocommerce_after_single_product_summary hook
                 *
                 * @hooked woocommerce_output_product_data_tabs - 10
                 * @hooked woocommerce_output_related_products - 20 [REMOVED in woo.php]
                 */
                 if(etheme_get_option('tabs_location') == 'after_content' && $layout != 'large') {
                     do_action( 'woocommerce_after_single_product_summary' );
                 }
                 else if (etheme_get_option('tabs_location') == 'after_image' && $layout != 'large') {
                    do_action('show_product_reviews');
                 }
            ?>

        </div> <!-- CONTENT/ END -->

        <?php if($l['sidebar'] != '' && $l['sidebar'] != 'without' && $l['sidebar'] != 'no_sidebar'): ?>
            <div class="<?php echo esc_attr( $l['sidebar-class'] ); ?> single-product-sidebar sidebar-<?php echo esc_attr( $l['sidebar'] ); ?>">
            <?php if (etheme_get_option('single_sidebar_responsive_display') && etheme_get_option('single_sidebar') != 'without') : ?>
                <button type="button" class="btn filled medium" id="show-shop-sidebar"><?php esc_html_e('Show sidebar', 'woopress'); ?></button> <div class="hidden-shop-sidebar already-hidden"> <?php endif; ?>
                <?php if ( function_exists( 'woopress_core_load_textdomain' ) ) : ?>
                    <?php if ( ! woopress_plugin_notice() ): ?>
                        <?php et_product_brand_image(); ?>
                    <?php endif; ?>
                <?php endif ?>
                
                <?php if(etheme_get_option('upsell_location') == 'sidebar') woocommerce_upsell_display(); ?>

                <?php  dynamic_sidebar('single-sidebar'); ?>
                    <?php if (etheme_get_option('single_sidebar_responsive_display') && etheme_get_option('single_sidebar') != 'without' ) : echo '</div>'; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if(etheme_get_option('upsell_location') == 'after_content') woocommerce_upsell_display(); ?>
    <?php
        if(etheme_get_custom_field('additional_block') != '') {
            echo '<div class="product-extra-content">';
                et_show_block(etheme_get_custom_field('additional_block'));
            echo '</div>';
        }
    ?>
    <?php if(etheme_get_option('show_related')) woocommerce_output_related_products(); ?>


    <meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
