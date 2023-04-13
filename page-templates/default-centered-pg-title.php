<?php
/**
 *
 * Template Name: Default W-BG, Centered Title
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

	$classes[] = 'full-width-content' . ' centered-title_dark' . ' background-white';
	return $classes;

}

// Runs the Genesis loop
genesis();