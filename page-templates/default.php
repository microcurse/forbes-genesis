<?php
/**
 * Default page template for site.
 *
 * Template Name: Default - Full Width Page Title
 *
 * @package Genesis Sample
 * @author  Marc Maninang
 * @license GPL-2.0-or-later
 */

add_filter( 'body_class', 'genesis_full_width_class' );
/**
 * Adds page body class.
 *
 * @since 1.0.0
 *
 * @param array $classes Original body classes.
 * @return array Modified body classes.
 */
function genesis_full_width_class( $classes ) {

	$classes[] = 'full-width-content';
	return $classes;

}

// Remove current header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

// Add current header
add_action( 'genesis_after_header', 'genesis_entry_header_markup_open', 5 );
add_action( 'genesis_after_header', 'fi_entry_header_wrap_open', 6 );
add_action( 'genesis_after_header', 'genesis_do_post_title' );
add_action( 'genesis_after_header', 'genesis_post_info' );
add_action( 'genesis_after_header', 'fi_do_entry_header_bg', 13);
add_action( 'genesis_after_header', 'fi_entry_header_wrap_close', 14 );
add_action( 'genesis_after_header', 'genesis_entry_header_markup_close', 15 );

// ACF Add background image to archive header
function fi_do_entry_header_bg() {
  $term = get_queried_object();
  $image = get_field('page_header_background', $term);

  ?>
  <style type="text/css">
	
    <?php if( $image ): ?>
    .entry-header {
      background-image: url(<?php echo $image['url']; ?>);
    }
    <?php endif; ?>
    
  </style>
  <?php
}

function fi_entry_header_wrap_open() {
    
	genesis_markup(
			[
					'open'      => '<div %s>',
					"context"   => 'wrap',
			]
	);

}

function fi_entry_header_wrap_close() {

	genesis_markup(
			[
					'open'      => '</div>',
					"context"   => 'wrap',
			]
	);

}

// Remove sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
remove_action( 'genesis_sidebar', 'fi_add_woo_sidebar' );

// Add Slick Carousel Script
add_action( 'genesis_after_content_sidebar_wrap', 'fi_slick_carousel' );

// Runs the Genesis loop
genesis();