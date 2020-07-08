<?php 
	// Prevent the direct loading
	
	if ( ! defined( 'ABSPATH') ) exit( 'No direct script access allowed' );

	// Check if post is pwd protected

	if(post_password_required()){
		?>
			<p><?php esc_html_e('This post is password protected. Enter the password to view the comments.', 'woopress'); ?></p>
		<?php
		return;
	}
	
	if(have_comments()) :?>
		<div id="comments" class="comments">
		<h4 class="title-alt"><span><?php comments_number( esc_html__('No Comments', 'woopress'), esc_html__('One Comment', 'woopress'), esc_html__('% Comments', 'woopress')); ?></span></h4>

		<ul class="comments-list">
			<?php wp_list_comments('callback=etheme_comments'); ?>
		</ul>

		<?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
			
			<div class="comments-nav">
				<div class="pull-left"><?php previous_comments_link(__('&larr; Older Comments', 'woopress')); ?></div>
				<div class="pull-right"><?php next_comments_link(__('Newer Comments &rarr;', 'woopress')); ?></div>
				<div class="clear"></div>
			</div>

		<?php endif ?>	
		
		</div>

	<?php elseif(!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
		
		<p><?php esc_html_e('Comments are closed', 'woopress') ?></p>

	<?php 
	endif;

	// Display Comment Form
	comment_form(array('title_reply' => '<span>' . esc_html__('Leave a reply', 'woopress') . '</span><span class="divider"></span>'));
?>