<?php 
/**
 * The main template file.
 *
 */
	get_header();
?>
<?php 

	$l = et_page_config();

	$content_layout = etheme_get_option('blog_layout');

	$full_width = false;

	if($content_layout == 'mosaic') {
		$full_width = etheme_get_option('blog_full_width');
	}

	if($content_layout == 'mosaic') {
		$content_layout = 'grid';
	}

	$class = '';
	if ( $content_layout == 'grid' ) {
		$class .= ' row';
		if ( etheme_get_option( 'blog_page_masonry' ) ) {
			$class .= ' blog-masonry';
		} else {
			$class .= ' masonry-off';
		}
	}
?>

<?php do_action( 'et_page_heading' ); ?>

<div class="<?php echo (!$full_width) ? 'container' : 'blog-full-width'; ?>">
	<div class="page-content sidebar-position-<?php echo esc_attr( $l['sidebar'] ); ?> sidebar-mobile-<?php echo esc_attr( $l['sidebar-mobile'] ); ?>">
		<div class="row">
			<div class="content <?php echo esc_attr( $l['content-class'] ); ?>">
		
				<div class="<?php echo esc_attr( $class ); ?>">
					<?php if(have_posts()): 
						while(have_posts()) : the_post(); ?>

							<?php get_template_part('content', $content_layout); ?>

						<?php endwhile; ?>
					<?php else: ?>

						<h1><?php esc_html_e('No posts were found!', 'woopress') ?></h1>

					<?php endif; ?>
				</div>

				<div class="articles-nav">
					<div class="left"><?php next_posts_link(__('&larr; Older Posts', 'woopress')); ?></div>
					<div class="right"><?php previous_posts_link(__('Newer Posts &rarr;', 'woopress')); ?></div>
					<div class="clear"></div>
				</div>

			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>
</div>

<?php
	get_footer();
?>