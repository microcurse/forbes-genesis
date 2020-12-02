<?php
/**
 * Genesis Sample.
 *
 * This file adds the landing page template to the Genesis Sample Theme.
 *
 * Template Name: Full-Width w/ Slick Carousel
 *
 * @package Genesis Sample
 * @author  StudioPress
 * @license GPL-2.0-or-later
 * @link    https://www.studiopress.com/
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