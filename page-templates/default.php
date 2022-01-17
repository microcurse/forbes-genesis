<?php
/**
 * Default page template for site.
 *
 * Template Name: Default Template (MM)
 *
 * @package Genesis Sample
 * @author  Marc Maninang
 * @license GPL-2.0-or-later
 */

add_filter( 'body_class', 'genesis_full_width_class' );
/**
 * Adds landing page body class.
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

// Remove sidebar
remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
remove_action( 'genesis_sidebar', 'fi_add_woo_sidebar' );

// Add Slick Carousel Script
add_action( 'genesis_after_content_sidebar_wrap', 'fi_slick_carousel' );

// Runs the Genesis loop
genesis();