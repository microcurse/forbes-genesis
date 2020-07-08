<?php 
/**
 *  Template name: Mobile Partitions Product Page
 *  Author: Marc RM
 */

get_header();?>
<?php $l = et_page_config();?>

<?php do_action( 'et_page_heading' ); ?>
<?php
// Get the queried object and sanitize it
$current_page = sanitize_post( $GLOBALS['wp_the_query']->get_queried_object() );
// Get the page slug
$slug = $current_page->post_name;
?>

<div class="mp-title-bar">
    <div class="container mp-inner">
        <div class="mp-2">
            <div class="mp-title-sub"><a href="<?php echo get_site_url(); ?>/mobilepartitions">Mobile Partitions</a></div>
            <h1 class="mp-title"><?php echo get_the_title(); ?></h1>
        </div>
        <div class="mp-2" style="text-align:right;">
            <a href="<?php echo get_site_url(); ?>/wp-content/uploads/PDF-Media/mobile_partitions-<?php echo $slug; ?>.pdf"><i class="fas fa-file-pdf"></i> Download Info Sheet</a>
            <a href="<?php echo get_site_url(); ?>/mobilepartitions/quote-request/" class="req-quote">Request a Quote</a>
        </div>
    </div>
</div>
<div id="fix-main" class="container content-page">
	<div class="page-content sidebar-position-<?php esc_attr_e( $l['sidebar'] ); ?> sidebar-mobile-<?php esc_attr_e( class_exists('WooCommerce') && ( is_checkout() || is_cart() || is_account_page() || in_array( 'woocommerce-wishlist', get_body_class() ) ) ? $l['shop-sidebar-mobile'] : $l['sidebar-mobile'] ); ?>">
		<div class="row">
			<div class="content <?php esc_attr_e( $l['content-class'] ); ?>">
				<?php if(have_posts()): while(have_posts()) : the_post(); ?>

				<?php the_content(); ?>

				<div class="post-navigation">
					<?php wp_link_pages(); ?>
				</div>

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

		$('.mp-3').click(function() {
			$(this).addClass('mp-active').siblings().removeClass('mp-active');
			$('.mp-1').hide();
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

<?php get_footer(); ?>