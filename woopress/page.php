<?php
	get_header();
?>

<?php

	$l = et_page_config();

	global $post;

	$portfolio_page_id = etheme_get_option( 'portfolio_page' );

	if ( function_exists('icl_object_id') ) {

	    global $sitepress;

	    if ( ! empty( $sitepress )  ) {
	        $multy_id = icl_object_id ( get_the_id(), "page", false, $sitepress->get_default_language() );
	    } elseif( function_exists( 'pll_current_language' ) ) {
	        $multy_id = icl_object_id ( get_the_id(), "page", false, pll_current_language() );
	    } else {
	        $multy_id = false;
	    }

	    if (  get_the_id() == $portfolio_page_id || $portfolio_page_id == $multy_id ) {
	        get_template_part('portfolio');
	        return;
	    }
	} else {
	    if (  get_the_id() == $portfolio_page_id ) {
	        get_template_part('portfolio');
	        return;
	    }
	}

?>

<?php do_action( 'et_page_heading' ); ?>

	<div class="container content-page">
		<div class="page-content sidebar-position-<?php echo esc_attr( $l['sidebar'] ); ?> sidebar-mobile-<?php echo esc_attr( class_exists('WooCommerce') && ( is_checkout() || is_cart() || is_account_page() || in_array( 'woocommerce-wishlist', get_body_class() ) ) ? $l['shop-sidebar-mobile'] : $l['sidebar-mobile'] ); ?>">
			<div class="row">

				<div class="content <?php echo esc_attr( $l['content-class'] ); ?>">
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

<?php
	get_footer();
?>
