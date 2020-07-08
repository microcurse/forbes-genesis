<?php 
	get_header();
?>

<?php do_action( 'et_page_heading' ); ?>

<div class="container">
	<div class="page-content page-404">
		<div class="row">
			<div class="col-md-12">
				<h1 class="largest">404</h1>
				<h1><?php esc_html_e('Oops! Page not found', 'woopress') ?></h1>
				<hr class="horizontal-break">
				<p><?php esc_html_e("This is awkward. We couldn't seem to find the page you were looking for. You can try using the search bar below or return the homepage.", 'woopress') ?> </p>
				<?php get_search_form( true ); ?>
				<a href="<?php echo home_url(); ?>" class="button medium"><?php esc_html_e('Go to home page', 'woopress'); ?></a>
			</div>
		</div>
	</div>
</div>

<footer class="main-footer main-footer-1 text-color-default">
    <div class="container">
        <?php echo do_shortcode("[block id='18695']"); ?>
    </div>
</footer>

<?php
	get_footer();
?>