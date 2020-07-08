<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.5.1
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;


// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = '';
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes .= 'first ';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes .= 'last ';

//$classes[] = 'col-lg-4 col-sm-4 col-xs-6';


if(!class_exists('YITH_WCWL')) {
	$classes .= 'wishlist-disabled ';
}

$hover = etheme_get_option('product_img_hover');

$style = '';

if (!empty($woocommerce_loop['style']) && $woocommerce_loop['style'] == 'advanced') {
	$style = 'advanced';
	$classes .= 'content-product-advanced ';
}

$hover = etheme_get_option('product_img_hover');
if( ! empty( $woocommerce_loop['hover'])) {
	$hover = $woocommerce_loop['hover'];
}

$lazy = false;
if( ! empty( $woocommerce_loop['lazy-load'])) {
	$lazy = $woocommerce_loop['lazy-load'];
}

$img_lazy_src = 'src';
$img_class = '';
if ( $lazy ) {
	$img_lazy_src = 'data-src';
	$img_class = 'owl-lazy';
}

$hoverUrl = '';
if ($hover == 'swap') {
	$hoverUrl = etheme_get_custom_field('hover_img');
	$size = get_option('shop_catalog_image_size');
	if ($hoverUrl != '') {
		$hoverImg = vt_resize(false, $hoverUrl, $size['width'], $size['height'], $size['crop'] );
        $hoverImg = $hoverImg['url'];
	}
    if ( empty($hoverImg) || $hoverImg === NULL ) {
        $hoverImg = $hoverUrl;
    }
}
?>


<div class="product <?php echo esc_attr($classes); ?>">
	<?php 
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    do_action( 'woocommerce_before_shop_loop_item' );
    add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
    ?>
	<div class="content-product">
		<?php if ($style == 'advanced'): ?>
			<div class="row">
				<div class="col-lg-6">
		<?php endif ?>
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10 [REMOVED in woo.php]
			 * @hooked woocommerce_template_loop_product_thumbnail - 10 [REMOVED in woo.php]
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<div class="product-image-wrapper hover-effect-<?php echo esc_attr($hover); ?>">
				<a class="product-content-image" href="<?php the_permalink(); ?>" data-images="<?php echo get_images_list(); ?>">
					<?php woocommerce_show_product_loop_sale_flash(); ?>
					<?php if ($hoverUrl != ''): ?>
						<img src="<?php echo esc_url($hoverImg); ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>" class="show-image">
					<?php endif; ?>
					<?php
						$props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
						$thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id(), apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' ) );
						$thumb_src = (is_array($thumbnail_image) && isset($thumbnail_image[0])) ? $thumbnail_image[0] : wc_placeholder_img_src();

						echo sprintf('<img '.$img_lazy_src.'="%s" class="'.$img_class.'" alt="%s" title="%s" data-srcset="%s" sizes="%s" height="%s" width="%s" />',esc_url( $thumb_src ),esc_attr($props['alt']),get_the_title(),wp_get_attachment_image_srcset( get_post_thumbnail_id(), apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' )), wp_get_attachment_image_sizes( get_post_thumbnail_id(), apply_filters( 'single_product_archive_thumbnail_size', 'shop_catalog' )), esc_attr($thumbnail_image[1]), esc_attr($thumbnail_image[2]) );

					 ?>
                    <?php if($hover == 'mask'): ?>
                            <div class="hover-mask">
                                <?php woocommerce_show_product_loop_sale_flash(); ?>
                                <div class="mask-content">
                                    <?php if (etheme_get_option('product_page_cats')): ?>
                                            <div class="products-page-cats">
                                                    <?php
                                                            $size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
                                                            echo wc_get_product_category_list( $post->ID, ', ' );
                                                    ?>
                                            </div>
                                    <?php endif ?>

                                    <?php if (etheme_get_option('product_page_productname')): ?>
                                            <div class="product-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                            </div>
                                    <?php endif ?>

                                    <?php
                                        /**
                                         * woocommerce_after_shop_loop_item_title hook
                                         *
                                         * @hooked woocommerce_template_loop_rating - 5
                                         * @hooked woocommerce_template_loop_price - 10
                                         */
                                        if (etheme_get_option('product_page_price')) {
                                            do_action( 'woocommerce_after_shop_loop_item_title' );
                                        }
                                    ?>


                                    <div class="product-excerpt">
                                            <?php echo do_shortcode(get_the_excerpt()); ?>
                                    </div>

                                    <?php
		                                if (etheme_get_option('product_page_addtocart')) {
		                                  	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
											do_action( 'woocommerce_after_shop_loop_item' );
						                    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		                                }
                                    ?>
                                </div>
                            </div>
                    <?php endif; ?>
				</a>
				<?php if( ( class_exists('YITH_WCWL') && class_exists( 'YITH_WCWL_Shortcode' ) ) || etheme_get_option('quick_view') ) : ?>
        			<footer class="footer-product">
        				<?php echo et_wishlist_btn(esc_html__('Wishlist', 'woopress')); ?>
        				<?php if (etheme_get_option('quick_view')): ?>
        					<span class="show-quickly" data-prodid="<?php echo esc_attr($post->ID); ?>"><?php esc_html_e('Quick View', 'woopress') ?></span>
        				<?php endif ?>
        			</footer>
                <?php endif; ?>
		</div>

		<?php if ($style == 'advanced'): ?>
			</div>
			<div class="col-lg-6">
		<?php endif ?>
		<div class="text-center product-details">
    		<?php if (etheme_get_option('product_page_cats')): ?>
    			<div class="products-page-cats">
    				<?php
    					$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
    					echo wc_get_product_category_list( $post->ID, ', ' );
    				?>
    			</div>
    		<?php endif ?>

    		<?php if (etheme_get_option('product_page_productname')): ?>
    			<div class="product-title">
    				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    			</div>
    		<?php endif ?>

			<div class="product-excerpt">
				<?php echo do_shortcode(get_the_excerpt()); ?>
			</div>


			<?php
				/**
				 * woocommerce_after_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_template_loop_rating - 5
				 * @hooked woocommerce_template_loop_price - 10
				 */

				if (etheme_get_option('product_page_price')) {
				    do_action( 'woocommerce_after_shop_loop_item_title' );
                }
			?>


			<?php
	        	if (etheme_get_option('product_page_addtocart')) {
	        	  	remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5);
					do_action( 'woocommerce_after_shop_loop_item' );
                    add_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
                }
            ?>
		</div>
		<?php if ($style == 'advanced'): ?>
				</div>
			</div>
		<?php endif ?>
	</div>
</div>
