<?php 

	$l = et_page_config();

?>

<?php 
	get_header();
?>

<?php do_action( 'et_page_heading' ); ?>

<div class="container">
	<div class="page-content sidebar-position-without">
		<div class="row">
			<div class="content col-md-12">
				<?php if ( ! woopress_plugin_notice() ): ?>

					<?php if ( etheme_get_option('portfolio_content_side') == 'top' ): ?>
					 	<?php if( have_posts() && get_query_var( 'portfolio_category' ) == '' ): while( have_posts() ) : the_post(); ?>
	                    	<?php the_content(); ?>
	               		<?php endwhile; endif; ?>
					<?php endif ?>
					
					<?php get_etheme_portfolio(); ?>

					<?php if ( etheme_get_option('portfolio_content_side') == 'bottom' ): ?>
					 	<?php if( have_posts() && get_query_var( 'portfolio_category' ) == '' ): while( have_posts() ) : the_post(); ?>
	                    	<?php the_content(); ?>
	               		<?php endwhile; endif; ?>
					<?php endif ?>
				<?php endif; ?>
			</div>
		</div>

	</div>
</div>
	
<?php
	get_footer();
?>