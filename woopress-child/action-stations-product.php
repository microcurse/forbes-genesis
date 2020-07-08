<?php 
/**
 * Template Name: Action Station (Product)
 * 
 */
get_header();?>
<?php 
$l = et_page_config();
$delimiter    = '<span class="delimeter">/</span>';
?>

<?php do_action( 'et_page_heading' ); ?>

<div class="container content-page">
	<div class="page-content sidebar-position-<?php esc_attr_e( $l['sidebar'] ); ?> sidebar-mobile-<?php esc_attr_e( class_exists('WooCommerce') && ( is_checkout() || is_cart() || is_account_page() || in_array( 'woocommerce-wishlist', get_body_class() ) ) ? $l['shop-sidebar-mobile'] : $l['sidebar-mobile'] ); ?>">
		<div class="row">
			<div class="content <?php esc_attr_e( $l['content-class'] ); ?>">

			<?php if(have_posts()): while(have_posts()) : the_post(); ?>

			<?php the_content(); ?>

			<?php if ($post->ID != 0 && current_user_can('edit_post', $post->ID)): ?>
			<?php edit_post_link( __('Edit this', 'woopress'), '<p class="edit-link">', '</p>' ); ?>
			<?php endif ?>

			<?php endwhile; else: ?>

			<h3><?php esc_html_e('No pages were found!', 'woopress') ?></h3>

			<?php endif; ?>
			</div>
			<?php get_sidebar(); ?>
		</div><!-- end row-fluid -->
	</div>
</div><!-- end container -->


<script type="text/javascript">
(function($) {

	// Tier selection
	$(document).ready(function(){
		$('#row_executive').hide();
		$('#row_essentials').hide();

		$('.gbb-pick').click(function() {
			$(this).addClass('gbb-pick--action-stations__active').siblings().removeClass('gbb-pick--action-stations__active');
			$('.gbb-pick-specs').hide();
			$('#row_' + $(this).attr('id')).show();
			
			// Fix carousel images not loading when switching tiers
			$('.gallery').slick('setPosition');
		});
	});

	// Slick carousel
	$(document).ready(function(){
		$('.gallery').slick({
			accessibility: true,
			slidesToShow: 3,
			slidesToScroll: 3,
			infinite: true,
		});
	});

}(jQuery));

</script>

<?php
	get_footer();
?>