<?php
/**
 * Shop breadcrumb
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $wp_query;

$l = et_page_config();

if ($l['heading'] !== 'disable' && !$l['slider'] && etheme_get_option('breadcrumb_type') != 9):
?>
<div class="page-heading bc-type-<?php etheme_option('breadcrumb_type'); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12 a-center">

				<?php do_action('etheme_before_breadcrumbs'); ?>
								<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
					<h1 class="title">
                        <?php if(is_single() && ! is_attachment()): ?>
                            <?php echo get_the_title(); ?>
                        <?php else: ?>
                            <?php woocommerce_page_title(); ?>
                        <?php endif; ?>
                    </h1>
				<?php endif; ?>

				<?php if ( $breadcrumb ) : ?>

					<?php $output = ''; ?>

					<?php $output .= $wrap_before; // Data escaped by WooCommerce ?>

					<?php foreach ( $breadcrumb as $key => $crumb ) : ?>

						<?php $output .=  $before; // Data escaped by WooCommerce ?>

						<?php if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) : ?>
							<?php $output .= '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>'; ?>
						<?php else : ?>
							<?php $output .= esc_html( $crumb[0] ); ?>
						<?php endif; ?>

						<?php $output .= $after; // Data escaped by WooCommerce ?>

						<?php if ( sizeof( $breadcrumb ) !== $key + 1 ) : ?>
							<?php $output .= '<span class="delimeter">/</span>'; ?>
						<?php endif; ?>

					<?php endforeach; ?>

					<?php $output .= $wrap_after; // Data escaped by WooCommerce ?>

					<?php echo $output; // All data escaped ?>

				<?php endif; ?>

				<?php
		            et_back_to_page();
		       	?>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<?php
	if($l['breadcrumb_image'] != '') {
	    ?>
	        <style type="text/css">
	            .page-heading {
	                background-image: url(<?php echo esc_attr( $l['breadcrumb_image'] ); ?>);
	            }
	        </style>
	    <?php
	}
 ?>


<?php if($l['slider']): ?>
	<div class="page-heading-slider">
		<?php  echo do_shortcode('[rev_slider_vc alias="'.$l['slider'].'"]'); ?>
	</div>
<?php endif; ?>
