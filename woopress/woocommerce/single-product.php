<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

get_header( 'shop' ); 
$l = et_page_config();
$sidebarname = 'single';
?>
<?php
	/**
	 * woocommerce_before_main_content hook
	 *
	 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
	 * @hooked woocommerce_breadcrumb - 20
	 */
	do_action('woocommerce_before_main_content');
?>

<div id="product-<?php the_ID(); ?>" class="container">
	<div class="page-content sidebar-position-<?php echo esc_attr( $l['sidebar'] ); ?> sidebar-mobile-<?php echo esc_attr( $l['shop-sidebar-mobile'] ); ?>">
        
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php wc_get_template_part( 'content', 'single-product' ); ?>
	
		<?php endwhile; // end of the loop. ?>
    
    	<?php
    		/**
    		 * woocommerce_after_main_content hook
    		 *
    		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
    		 */
    		do_action( 'woocommerce_after_main_content' );
    	?>
	</div>
</div>

<?php get_footer( 'shop' ); ?>