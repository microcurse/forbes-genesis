<?php 
/**
 * Template Name: FW - Slick Carousel
 * 
 */
get_header();?>
<?php $l = et_page_config();?>

<?php do_action( 'et_page_heading' ); ?>

<div class="container-fluid content-page">
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

<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="https://www.forbesindustries.com/wp-content/themes/woopress-child/assets/slick/slick.min.js"></script>

<script>
	$('.grid-carousel').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		arrows: true,
		easing: true,
		responsive: [
			{
				breakpoint: 1200,
				settings: {
					slidesToShow: 3,
				}
			},
			{				
				breakpoint: 992,
				settings: {
					slidesToShow: 2,
				}
			},
			{				
				breakpoint: 480,
				settings: {
					slidesToShow: 2,
				}
			}
		],
	});
</script>
<?php
	get_footer();
?>